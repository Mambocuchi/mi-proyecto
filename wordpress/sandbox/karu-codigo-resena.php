<?php
/**
 * Plugin Name: Karu Esencial - Código de descuento por opinión
 * Description: Al enviar el formulario "Opiniones de clientes" (WPForms), genera un código único de 15% (válido 30 días, un uso, uno por correo), lo registra como cupón de WooCommerce y lo envía al correo del cliente.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const KARU_RESENA_FORM_ID    = 146;
const KARU_RESENA_EMAIL_FIELD = 3;
const KARU_RESENA_NAME_FIELD  = 1;
const KARU_RESENA_CODE_FIELD  = 8;
const KARU_RESENA_DESCUENTO  = 15;
const KARU_RESENA_DIAS       = 30;

/**
 * Estado de la solicitud actual: código generado o correo repetido.
 */
function karu_resena_state( $set = null ) {
	static $state = null;
	if ( $set !== null ) {
		$state = $set;
	}
	return $state;
}

/**
 * Busca un cupón ya entregado a este correo.
 */
function karu_resena_codigo_existente( $email ) {
	$ids = get_posts( array(
		'post_type'      => 'shop_coupon',
		'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
		'meta_key'       => '_karu_resena_email',
		'meta_value'     => strtolower( $email ),
		'fields'         => 'ids',
		'posts_per_page' => 1,
	) );
	return $ids ? strtoupper( get_the_title( $ids[0] ) ) : null;
}

function karu_resena_generar_codigo() {
	$alfabeto = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
	do {
		$codigo = 'KARU-';
		for ( $i = 0; $i < 5; $i++ ) {
			$codigo .= $alfabeto[ random_int( 0, strlen( $alfabeto ) - 1 ) ];
		}
	} while ( function_exists( 'wc_get_coupon_id_by_code' ) && wc_get_coupon_id_by_code( $codigo ) );
	return $codigo;
}

/**
 * Antes de enviar los avisos: decide el código y lo guarda en el campo oculto
 * para que aparezca en el correo que recibe Karu Esencial.
 */
add_filter( 'wpforms_process_filter', function ( $fields, $entry, $form_data ) {
	if ( (int) $form_data['id'] !== KARU_RESENA_FORM_ID || ! class_exists( 'WC_Coupon' ) ) {
		return $fields;
	}
	$email = strtolower( trim( $fields[ KARU_RESENA_EMAIL_FIELD ]['value'] ?? '' ) );
	if ( ! is_email( $email ) ) {
		return $fields;
	}
	$existente = karu_resena_codigo_existente( $email );
	if ( $existente ) {
		karu_resena_state( array( 'repetido' => true, 'email' => $email ) );
		$valor = 'Ninguno: este correo ya había recibido el código ' . $existente;
	} else {
		$codigo = karu_resena_generar_codigo();
		karu_resena_state( array( 'repetido' => false, 'email' => $email, 'codigo' => $codigo ) );
		$valor = $codigo;
	}
	if ( isset( $fields[ KARU_RESENA_CODE_FIELD ] ) ) {
		$fields[ KARU_RESENA_CODE_FIELD ]['value'] = $valor;
	}
	return $fields;
}, 10, 3 );

/**
 * Opinión guardada con éxito: crea el cupón y envía el código al cliente.
 */
add_action( 'wpforms_process_complete_' . KARU_RESENA_FORM_ID, function ( $fields ) {
	$state = karu_resena_state();
	if ( ! $state || ! empty( $state['repetido'] ) || empty( $state['codigo'] ) ) {
		return;
	}
	$nombre = sanitize_text_field( $fields[ KARU_RESENA_NAME_FIELD ]['value'] ?? '' );
	$vence  = ( new DateTimeImmutable( 'now', wp_timezone() ) )->modify( '+' . KARU_RESENA_DIAS . ' days' )->setTime( 23, 59, 59 );

	$cupon = new WC_Coupon();
	$cupon->set_code( $state['codigo'] );
	$cupon->set_discount_type( 'percent' );
	$cupon->set_amount( KARU_RESENA_DESCUENTO );
	$cupon->set_date_expires( $vence->getTimestamp() );
	$cupon->set_usage_limit( 1 );
	$cupon->set_email_restrictions( array( $state['email'] ) );
	$cupon->set_description( sprintf( 'Opinión en el sitio. Cliente: %s (%s). Se canjea por WhatsApp.', $nombre, $state['email'] ) );
	$id = $cupon->save();
	if ( ! $id ) {
		return;
	}
	update_post_meta( $id, '_karu_resena_email', $state['email'] );

	$fecha   = wp_date( 'j \d\e F \d\e Y', $vence->getTimestamp() );
	$wa      = 'https://wa.me/56989048914?text=' . rawurlencode( 'Hola Karu Esencial, quiero hacer un pedido con mi código ' . $state['codigo'] . '.' );
	$saludo  = $nombre ? 'Hola ' . esc_html( $nombre ) . ',' : 'Hola,';
	$mensaje = '<div style="font-family:Arial,Helvetica,sans-serif;color:#243D5B;font-size:16px;line-height:1.6;max-width:520px">'
		. '<p>' . $saludo . '</p>'
		. '<p>Gracias por compartir tu experiencia con Karu Esencial. Como agradecimiento, este es tu código de <strong>' . KARU_RESENA_DESCUENTO . '% de descuento</strong> para tu próxima compra:</p>'
		. '<p style="font-size:26px;font-weight:bold;letter-spacing:2px;background:#EDF6FF;border:1px dashed #4A90E2;border-radius:12px;padding:14px;text-align:center">' . esc_html( $state['codigo'] ) . '</p>'
		. '<ul><li>Válido hasta el ' . esc_html( $fecha ) . '.</li><li>Un solo uso, en cualquier producto o pack.</li><li>Para usarlo, ingrésalo en el carrito de <a href="' . esc_url( home_url( '/productos/' ) ) . '">karuesencial.cl</a> con este mismo correo, o indícanoslo por WhatsApp al +56 9 8904 8914.</li></ul>'
		. '<p><a href="' . esc_url( home_url( '/productos/' ) ) . '" style="display:inline-block;background:#4A90E2;color:#FFFFFF;text-decoration:none;font-weight:bold;padding:12px 24px;border-radius:999px">Hacer mi pedido</a> &nbsp; <a href="' . esc_url( $wa ) . '" style="color:#4A90E2;font-weight:bold">o pedir por WhatsApp</a></p>'
		. '<p>Un saludo,<br>Karu Esencial</p></div>';
	wp_mail(
		$state['email'],
		'Tu código de ' . KARU_RESENA_DESCUENTO . '% de descuento - Karu Esencial',
		$mensaje,
		array( 'Content-Type: text/html; charset=UTF-8', 'Reply-To: Karu Esencial <contacto@karuesencial.cl>' )
	);
} );

/**
 * Mensaje que ve el cliente al enviar el formulario.
 */
add_filter( 'wpforms_frontend_confirmation_message', function ( $message, $form_data ) {
	if ( (int) $form_data['id'] !== KARU_RESENA_FORM_ID ) {
		return $message;
	}
	$state = karu_resena_state();
	if ( $state && ! empty( $state['repetido'] ) ) {
		$texto = 'Este correo ya había recibido un código de descuento anteriormente (uno por persona). Revísalo en tu bandeja de entrada.';
	} elseif ( $state && ! empty( $state['codigo'] ) ) {
		$texto = 'Te enviamos tu código de ' . KARU_RESENA_DESCUENTO . '% de descuento a <strong>' . esc_html( $state['email'] ) . '</strong>. Si no lo ves en unos minutos, revisa la carpeta de spam.';
	} else {
		$texto = '';
	}
	return str_replace( '{karu_mensaje_codigo}', $texto, $message );
}, 10, 2 );
