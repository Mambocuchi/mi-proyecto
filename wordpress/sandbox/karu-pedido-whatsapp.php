<?php
/**
 * Plugin Name: Karu Esencial - Pedido por WhatsApp
 * Description: Ajusta el carrito y el pago de WooCommerce para Karu Esencial: comunas del Gran Concepción, tarifas de despacho por comuna (gratis desde $20.000), retiro en Castellón 1333 y envío del pedido por WhatsApp.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const KARU_WA_NUMERO        = '56989048914';
const KARU_DESPACHO_GRATIS = 20000;
const KARU_RETIRO_TEXTO    = 'Castellón 1333, Concepción. Lunes a jueves de 08:30 a 18:00 y viernes de 08:30 a 13:00.';

/**
 * Comunas con despacho y su costo bajo el monto de despacho gratis.
 */
function karu_comunas() {
	return array(
		'Concepción'         => 1000,
		'San Pedro de la Paz' => 1000,
		'Chiguayante'         => 2000,
		'Talcahuano'          => 3000,
		'Hualpén'             => 3000,
		'Penco'               => 3000,
		'Tomé'                => 3000,
		'Coronel'             => 3000,
		'Lota'                => 3000,
		'Hualqui'             => 3000,
	);
}

function karu_clp( $monto ) {
	return '$' . number_format( (float) $monto, 0, ',', '.' );
}

/* ------------------------------------------------------------------ Campos del pago */

add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
	$b = &$fields['billing'];
	unset( $b['billing_last_name'], $b['billing_company'], $b['billing_address_2'], $b['billing_postcode'], $b['billing_state'] );

	$b['billing_first_name']['label']    = 'Nombre y apellido';
	$b['billing_first_name']['class']    = array( 'form-row-wide' );
	$b['billing_first_name']['priority'] = 10;

	$b['billing_phone']['label']    = 'Teléfono / WhatsApp';
	$b['billing_phone']['required'] = true;
	$b['billing_phone']['priority'] = 20;
	$b['billing_phone']['class']    = array( 'form-row-first' );

	$b['billing_email']['label']       = 'Correo electrónico';
	$b['billing_email']['description'] = 'Te enviaremos el resumen del pedido.';
	$b['billing_email']['priority']    = 30;
	$b['billing_email']['class']       = array( 'form-row-last' );

	$opciones = array( '' => 'Selecciona tu comuna' );
	foreach ( array_keys( karu_comunas() ) as $c ) {
		$opciones[ $c ] = $c;
	}
	$b['billing_city'] = array(
		'type'     => 'select',
		'label'    => 'Comuna',
		'required' => true,
		'options'  => $opciones,
		'class'    => array( 'form-row-wide', 'update_totals_on_change' ),
		'priority' => 40,
	);

	$b['billing_address_1']['label']       = 'Dirección (calle, número, depto.)';
	$b['billing_address_1']['placeholder'] = 'Solo si eliges despacho a domicilio';
	$b['billing_address_1']['required']    = false;
	$b['billing_address_1']['priority']    = 50;

	if ( isset( $b['billing_country'] ) ) {
		$b['billing_country']['priority'] = 90;
		$b['billing_country']['class']    = array( 'form-row-wide', 'karu-oculto' );
	}

	if ( isset( $fields['order']['order_comments'] ) ) {
		$fields['order']['order_comments']['label']       = 'Comentarios';
		$fields['order']['order_comments']['placeholder'] = 'Ej.: horario preferido, referencia del domicilio o día de retiro.';
	}
	return $fields;
}, 20 );

// La dirección de facturación no pide región ni código postal.
add_filter( 'woocommerce_default_address_fields', function ( $fields ) {
	foreach ( array( 'state', 'postcode' ) as $k ) {
		if ( isset( $fields[ $k ] ) ) {
			$fields[ $k ]['required'] = false;
		}
	}
	return $fields;
} );

add_filter( 'woocommerce_get_country_locale', function ( $locale ) {
	$locale['CL']['state']    = array( 'required' => false, 'hidden' => true );
	$locale['CL']['postcode'] = array( 'required' => false, 'hidden' => true );
	$locale['CL']['city']     = array( 'label' => 'Comuna' );
	$locale['CL']['phone']    = array( 'label' => KARU_ETIQUETA_TELEFONO, 'required' => true );
	return $locale;
} );

// El teléfono es obligatorio y se indica con "(obligatorio)" en vez del asterisco.
const KARU_ETIQUETA_TELEFONO = 'Teléfono / WhatsApp <span class="required karu-obligatorio" aria-hidden="true">(obligatorio)</span>';

add_filter( 'woocommerce_get_country_locale_default', function ( $locale ) {
	$locale['phone']['label']    = KARU_ETIQUETA_TELEFONO;
	$locale['phone']['required'] = true;
	return $locale;
} );

add_filter( 'woocommerce_form_field_tel', function ( $campo, $key ) {
	if ( $key === 'billing_phone' ) {
		$campo = str_replace( 'Teléfono / WhatsApp&nbsp;<span class="required" aria-hidden="true">*</span>', KARU_ETIQUETA_TELEFONO, $campo );
	}
	return $campo;
}, 10, 2 );

// Dirección obligatoria solo para despacho a domicilio.
add_action( 'woocommerce_after_checkout_validation', function ( $data, $errors ) {
	$metodo = (array) ( $data['shipping_method'] ?? array() );
	$es_despacho = false;
	foreach ( $metodo as $m ) {
		if ( strpos( (string) $m, 'flat_rate' ) === 0 ) {
			$es_despacho = true;
		}
	}
	if ( trim( (string) ( $data['billing_phone'] ?? '' ) ) === '' && ! $errors->get_error_data( 'billing_phone_required' ) ) {
		$errors->add( 'billing_phone_required', 'Ingresa tu <strong>teléfono / WhatsApp</strong> para confirmar el pedido.', array( 'id' => 'billing_phone' ) );
	}
	if ( $es_despacho && trim( (string) ( $data['billing_address_1'] ?? '' ) ) === '' ) {
		$errors->add( 'validation', 'Ingresa tu <strong>dirección</strong> para el despacho a domicilio, o elige retiro en Castellón 1333.' );
	}
	$comuna = (string) ( $data['billing_city'] ?? '' );
	if ( $comuna !== '' && ! array_key_exists( $comuna, karu_comunas() ) ) {
		$errors->add( 'validation', 'Por ahora solo despachamos dentro del Gran Concepción.' );
	}
}, 10, 2 );

/* ------------------------------------------------------------------ Tarifas de despacho */

add_filter( 'woocommerce_package_rates', function ( $rates, $package ) {
	$comuna   = (string) ( $package['destination']['city'] ?? '' );
	$subtotal = (float) ( $package['contents_cost'] ?? 0 );
	$tabla    = karu_comunas();
	foreach ( $rates as $rate_id => $rate ) {
		if ( $rate->get_method_id() === 'flat_rate' ) {
			if ( $subtotal >= KARU_DESPACHO_GRATIS ) {
				$rate->set_cost( 0 );
				$rate->set_label( 'Despacho a domicilio: gratis' );
			} elseif ( isset( $tabla[ $comuna ] ) ) {
				$rate->set_cost( $tabla[ $comuna ] );
				$rate->set_label( 'Despacho a domicilio (' . $comuna . ')' );
			} else {
				$rate->set_cost( 0 );
				$rate->set_label( 'Despacho a domicilio (elige tu comuna para ver el costo)' );
			}
			$rate->set_taxes( array() );
		}
		if ( $rate->get_method_id() === 'local_pickup' ) {
			$rate->set_cost( 0 );
			$rate->set_label( 'Retiro gratis en Castellón 1333, Concepción' );
		}
	}
	return $rates;
}, 20, 2 );

// Recalcular siempre (las tarifas dependen de la comuna y del monto).
add_filter( 'woocommerce_cart_shipping_packages', function ( $packages ) {
	foreach ( $packages as &$p ) {
		$p['karu_v'] = 2;
	}
	return $packages;
} );

// Horario de retiro bajo la opción.
add_action( 'woocommerce_after_shipping_rate', function ( $rate ) {
	if ( $rate->get_method_id() === 'local_pickup' ) {
		echo '<small class="karu-retiro" style="display:block;opacity:.8">Lunes a jueves de 08:30 a 18:00 y viernes de 08:30 a 13:00.</small>';
	}
} );

/* ------------------------------------------------------------------ Avisos y textos */

function karu_aviso_despacho_gratis() {
	if ( ! WC()->cart ) {
		return;
	}
	$subtotal = (float) WC()->cart->get_subtotal();
	if ( $subtotal <= 0 ) {
		return;
	}
	if ( $subtotal >= KARU_DESPACHO_GRATIS ) {
		$msg = '¡Tu pedido tiene <strong>despacho gratis</strong> en el Gran Concepción!';
	} else {
		$msg = 'Te faltan <strong>' . karu_clp( KARU_DESPACHO_GRATIS - $subtotal ) . '</strong> para tener <strong>despacho gratis</strong> en el Gran Concepción.';
	}
	echo '<div class="woocommerce-info karu-despacho"><span>' . wp_kses_post( $msg ) . '</span></div>';
}
add_action( 'woocommerce_before_cart', 'karu_aviso_despacho_gratis' );
add_action( 'woocommerce_before_checkout_form', 'karu_aviso_despacho_gratis', 5 );

add_filter( 'woocommerce_order_button_text', function () {
	return 'Confirmar pedido y enviar por WhatsApp';
} );

add_filter( 'gettext', function ( $traducido, $texto, $dominio ) {
	if ( $dominio !== 'woocommerce' ) {
		return $traducido;
	}
	switch ( $texto ) {
		case 'Proceed to checkout':
			return 'Continuar con el pedido';
		case 'Have a coupon?':
			return '¿Tienes un código de descuento?';
		case 'Click here to enter your code':
			return 'Ingrésalo aquí';
		case 'Coupon code':
			return 'Código de descuento';
		case 'Apply coupon':
			return 'Aplicar código';
		case 'Billing details':
		case 'Billing &amp; Shipping':
			return 'Tus datos';
		case 'Shipping costs are calculated during checkout.':
		case 'Shipping options will be updated during checkout.':
			return 'El costo de despacho se calcula al elegir tu comuna en el siguiente paso. Retiro en Castellón 1333: gratis.';
	}
	return $traducido;
}, 20, 3 );

// En el carrito no se calcula el despacho (depende de la comuna, que se elige al finalizar).
add_filter( 'woocommerce_cart_ready_to_calc_shipping', function ( $listo ) {
	return is_cart() ? false : $listo;
} );

// Campo de país oculto (solo Chile).
add_action( 'wp_head', function () {
	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		echo '<style>.karu-oculto{display:none!important}.karu-obligatorio{font-size:.85em;font-weight:400}</style>';
	}
} );

/* ------------------------------------------------------------------ Pedido a WhatsApp */

function karu_mensaje_pedido( WC_Order $order ) {
	$l   = array();
	$l[] = 'Hola Karu Esencial, quiero confirmar mi pedido #' . $order->get_order_number() . ':';
	$l[] = '';
	foreach ( $order->get_items() as $item ) {
		$l[] = '- ' . $item->get_quantity() . ' x ' . $item->get_name() . ' = ' . karu_clp( $item->get_subtotal() + $item->get_subtotal_tax() );
	}
	$l[] = '';
	$l[] = 'Subtotal: ' . karu_clp( $order->get_subtotal() );
	$codigos = $order->get_coupon_codes();
	if ( $order->get_discount_total() > 0 ) {
		$l[] = 'Descuento' . ( $codigos ? ' (' . strtoupper( implode( ', ', $codigos ) ) . ')' : '' ) . ': -' . karu_clp( $order->get_discount_total() );
	}
	$envio = $order->get_shipping_method();
	$l[]   = 'Entrega: ' . $envio . ( (float) $order->get_shipping_total() > 0 ? ' ' . karu_clp( $order->get_shipping_total() ) : ' (gratis)' );
	$l[]   = 'Total: ' . karu_clp( $order->get_total() );
	$l[]   = 'Pago: ' . $order->get_payment_method_title();
	$l[]   = '';
	$l[]   = 'Nombre: ' . $order->get_billing_first_name();
	$l[]   = 'Teléfono: ' . $order->get_billing_phone();
	$l[]   = 'Comuna: ' . $order->get_billing_city();
	if ( $order->get_billing_address_1() && strpos( implode( ' ', array_map( fn( $s ) => $s->get_method_id(), $order->get_shipping_methods() ) ), 'flat_rate' ) !== false ) {
		$l[] = 'Dirección: ' . $order->get_billing_address_1();
	}
	if ( $order->get_customer_note() ) {
		$l[] = 'Comentarios: ' . $order->get_customer_note();
	}
	return implode( "\n", $l );
}

function karu_url_whatsapp_pedido( WC_Order $order ) {
	return 'https://wa.me/' . KARU_WA_NUMERO . '?text=' . rawurlencode( karu_mensaje_pedido( $order ) );
}

// Mensaje principal de la página "pedido recibido".
add_filter( 'woocommerce_thankyou_order_received_text', function ( $texto, $order ) {
	if ( ! $order instanceof WC_Order ) {
		return $texto;
	}
	$url = karu_url_whatsapp_pedido( $order );
	$pago = $order->get_payment_method() === 'bacs'
		? 'Te responderemos con los datos para transferir.'
		: 'Pagas en efectivo al recibir o al retirar.';
	return '<span class="karu-gracias" style="display:block;padding:24px;border:1px solid #B8E0FF;background:#EDF6FF;border-radius:20px;text-align:center">'
		. '<strong style="display:block;font-size:1.25em;color:#243D5B;margin-bottom:6px">¡Pedido #' . esc_html( $order->get_order_number() ) . ' recibido!</strong>'
		. 'Último paso: envíanos el pedido por WhatsApp para confirmarlo. ' . esc_html( $pago )
		. '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener" class="button karu-wa-pedido" style="display:inline-block;margin-top:16px;background:#25D366;color:#FFFFFF;border-radius:999px;padding:14px 28px;font-weight:700;text-decoration:none">Enviar pedido por WhatsApp</a>'
		. '</span>';
}, 20, 2 );

// Enlace de WhatsApp también en el correo de confirmación al cliente.
add_action( 'woocommerce_email_before_order_table', function ( $order, $sent_to_admin ) {
	if ( $sent_to_admin || ! $order instanceof WC_Order ) {
		return;
	}
	echo '<p>Si aún no nos enviaste el pedido por WhatsApp, puedes hacerlo aquí: <a href="' . esc_url( karu_url_whatsapp_pedido( $order ) ) . '">Enviar pedido por WhatsApp</a></p>';
}, 5, 2 );
