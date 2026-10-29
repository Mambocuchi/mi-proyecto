<?php
/**
 * Plugin Name: Karu Esencial - Opiniones de clientes
 * Description: Guarda cada opinión del formulario "Opiniones de clientes" (WPForms) como "Opinión" pendiente en WordPress. Solo se pueden publicar las que el cliente autorizó, y las publicadas se muestran con el shortcode [karu_testimonios].
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const KARU_OPINIONES_FORM = 146;
const KARU_OPINIONES_CAMPO_TIPO      = 9; // ¿Sobre qué es tu opinión?
const KARU_OPINIONES_CAMPO_PRODUCTOS = 4;
const KARU_OPINIONES_TIPO_ATENCION   = 'La atención y el servicio de Karu';

/**
 * Texto corto de qué trata la opinión (para la tarjeta pública y la lista del administrador).
 */
function karu_opinion_sobre( $id ) {
	$tipo      = (string) get_post_meta( $id, '_karu_tipo', true );
	$productos = (string) get_post_meta( $id, '_karu_productos', true );
	if ( $tipo === KARU_OPINIONES_TIPO_ATENCION ) {
		return 'La atención de Karu';
	}
	if ( $productos === '' ) {
		return '';
	}
	return strpos( $tipo, 'Ambos' ) === 0 ? $productos . ' y la atención' : $productos;
}

add_action( 'init', function () {
	register_post_type( 'karu_testimonio', array(
		'labels'          => array(
			'name'               => 'Opiniones',
			'singular_name'      => 'Opinión',
			'menu_name'          => 'Opiniones',
			'add_new'            => 'Agregar opinión',
			'add_new_item'       => 'Agregar opinión',
			'edit_item'          => 'Revisar opinión',
			'all_items'          => 'Todas las opiniones',
			'search_items'       => 'Buscar opiniones',
			'not_found'          => 'Todavía no hay opiniones.',
			'not_found_in_trash' => 'No hay opiniones en la papelera.',
		),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'menu_position'   => 26,
		'menu_icon'       => 'dashicons-format-quote',
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'post',
	) );
} );

/* ------------------------------------------------------------------ Guardar desde el formulario */

add_action( 'wpforms_process_complete_' . KARU_OPINIONES_FORM, function ( $fields ) {
	$valor    = function ( $id ) use ( $fields ) {
		return isset( $fields[ $id ]['value'] ) ? trim( (string) $fields[ $id ]['value'] ) : '';
	};
	$nombre   = sanitize_text_field( $valor( 1 ) );
	$autoriza = $valor( 7 ) !== '';
	$id       = wp_insert_post( array(
		'post_type'    => 'karu_testimonio',
		'post_status'  => $autoriza ? 'pending' : 'private',
		'post_title'   => $nombre ? $nombre : 'Cliente',
		'post_content' => sanitize_textarea_field( $valor( 6 ) ),
	) );
	if ( ! $id || is_wp_error( $id ) ) {
		return;
	}
	$tipo = sanitize_text_field( $valor( KARU_OPINIONES_CAMPO_TIPO ) );
	update_post_meta( $id, '_karu_comuna', sanitize_text_field( $valor( 2 ) ) );
	update_post_meta( $id, '_karu_tipo', $tipo );
	update_post_meta( $id, '_karu_productos', $tipo === KARU_OPINIONES_TIPO_ATENCION ? '' : sanitize_text_field( str_replace( "\n", ', ', $valor( KARU_OPINIONES_CAMPO_PRODUCTOS ) ) ) );
	update_post_meta( $id, '_karu_experiencia', sanitize_text_field( $valor( 5 ) ) );
	update_post_meta( $id, '_karu_autoriza', $autoriza ? 1 : 0 );
	update_post_meta( $id, '_karu_email', sanitize_email( $valor( 3 ) ) );
}, 20 );

/* ------------------------------------------------------------------ Formulario: producto solo cuando corresponde */

// Si la opinión es sobre un producto (o ambos), hay que marcar cuál.
add_action( 'wpforms_process', function ( $fields, $entry, $form_data ) {
	if ( (int) $form_data['id'] !== KARU_OPINIONES_FORM ) {
		return;
	}
	$tipo      = trim( (string) ( $fields[ KARU_OPINIONES_CAMPO_TIPO ]['value'] ?? '' ) );
	$productos = trim( (string) ( $fields[ KARU_OPINIONES_CAMPO_PRODUCTOS ]['value'] ?? '' ) );
	if ( $tipo !== '' && $tipo !== KARU_OPINIONES_TIPO_ATENCION && $productos === '' ) {
		wpforms()->obj( 'process' )->errors[ KARU_OPINIONES_FORM ][ KARU_OPINIONES_CAMPO_PRODUCTOS ] = 'Marca el producto sobre el que opinas.';
	}
}, 10, 3 );

// Muestra la lista de productos solo si la opinión es sobre un producto.
add_action( 'wp_footer', function () {
	?>
<script id="karu-opiniones-form">
(function () {
	var form = document.getElementById('wpforms-form-<?php echo (int) KARU_OPINIONES_FORM; ?>');
	if (!form) { return; }
	var caja = document.getElementById('wpforms-<?php echo (int) KARU_OPINIONES_FORM; ?>-field_<?php echo (int) KARU_OPINIONES_CAMPO_PRODUCTOS; ?>-container');
	var radios = form.querySelectorAll('input[name="wpforms[fields][<?php echo (int) KARU_OPINIONES_CAMPO_TIPO; ?>]"]');
	var texto = form.querySelector('#wpforms-<?php echo (int) KARU_OPINIONES_FORM; ?>-field_6');
	if (!caja || !radios.length) { return; }
	function actualizar() {
		var elegido = form.querySelector('input[name="wpforms[fields][<?php echo (int) KARU_OPINIONES_CAMPO_TIPO; ?>]"]:checked');
		var valor = elegido ? elegido.value : '';
		var atencion = valor === <?php echo wp_json_encode( KARU_OPINIONES_TIPO_ATENCION ); ?>;
		caja.style.display = (valor && !atencion) ? '' : 'none';
		if (atencion) { caja.querySelectorAll('input[type=checkbox]').forEach(function (c) { c.checked = false; }); }
		if (texto) {
			texto.placeholder = atencion ? 'Cuéntanos cómo te atendimos: el pedido, la entrega, la comunicación…'
				: (valor.indexOf('Ambos') === 0 ? 'Cuéntanos qué te pareció el producto y cómo te atendimos'
				: 'Cuéntanos qué te pareció el producto');
		}
	}
	radios.forEach(function (r) { r.addEventListener('change', actualizar); });
	actualizar();
})();
</script>
	<?php
}, 30 );

/* ------------------------------------------------------------------ Solo se publican las autorizadas */

add_filter( 'wp_insert_post_data', function ( $data, $postarr ) {
	if ( $data['post_type'] !== 'karu_testimonio' || $data['post_status'] !== 'publish' ) {
		return $data;
	}
	$id       = (int) ( $postarr['ID'] ?? 0 );
	// Desde el editor manda la casilla del formulario; desde la lista (edición rápida) manda lo guardado.
	$autoriza = isset( $_POST['karu_opinion_nonce'] ) ? isset( $_POST['karu_autoriza'] ) : ( $id && get_post_meta( $id, '_karu_autoriza', true ) );
	if ( ! $autoriza ) {
		$data['post_status'] = 'private';
		set_transient( 'karu_opinion_no_autorizada', 1, 60 );
	}
	return $data;
}, 10, 2 );

add_action( 'admin_notices', function () {
	$screen = get_current_screen();
	if ( ! $screen || $screen->post_type !== 'karu_testimonio' ) {
		return;
	}
	if ( get_transient( 'karu_opinion_no_autorizada' ) ) {
		delete_transient( 'karu_opinion_no_autorizada' );
		echo '<div class="notice notice-error"><p><strong>No se publicó:</strong> el cliente no autorizó publicar su opinión. Quedó guardada como privada.</p></div>';
	}
	if ( $screen->base === 'edit' ) {
		echo '<div class="notice notice-info"><p>Las opiniones nuevas llegan como <strong>Pendientes</strong>. Ábrelas, revisa el texto y presiona <strong>Publicar</strong> para mostrarlas en la sección Testimonios. Solo se pueden publicar las que el cliente autorizó; el correo nunca se muestra.</p></div>';
	}
} );

/* ------------------------------------------------------------------ Datos en el editor */

add_action( 'add_meta_boxes_karu_testimonio', function () {
	add_meta_box( 'karu_opinion_datos', 'Datos de la opinión', function ( $post ) {
		wp_nonce_field( 'karu_opinion', 'karu_opinion_nonce' );
		$g = function ( $k ) use ( $post ) {
			return esc_attr( get_post_meta( $post->ID, $k, true ) );
		};
		echo '<p><label>Comuna<br><input type="text" name="karu_comuna" value="' . $g( '_karu_comuna' ) . '" class="widefat"></label></p>';
		echo '<p><label>Experiencia<br><select name="karu_experiencia" class="widefat">';
		foreach ( array( '', 'Excelente', 'Buena', 'Regular', 'Mala' ) as $op ) {
			echo '<option value="' . esc_attr( $op ) . '"' . selected( get_post_meta( $post->ID, '_karu_experiencia', true ), $op, false ) . '>' . esc_html( $op ? $op : '—' ) . '</option>';
		}
		echo '</select></label></p>';
		echo '<p><label>Opina sobre<br><select name="karu_tipo" class="widefat">';
		foreach ( array( '', 'Un producto que compré', KARU_OPINIONES_TIPO_ATENCION, 'Ambos: producto y atención' ) as $op ) {
			echo '<option value="' . esc_attr( $op ) . '"' . selected( get_post_meta( $post->ID, '_karu_tipo', true ), $op, false ) . '>' . esc_html( $op ? $op : '—' ) . '</option>';
		}
		echo '</select></label></p>';
		echo '<p><label>Productos<br><input type="text" name="karu_productos" value="' . $g( '_karu_productos' ) . '" class="widefat"></label></p>';
		echo '<p><label><input type="checkbox" name="karu_autoriza" value="1"' . checked( (int) get_post_meta( $post->ID, '_karu_autoriza', true ), 1, false ) . '> El cliente autorizó publicar su opinión con su nombre y comuna</label></p>';
		$email = get_post_meta( $post->ID, '_karu_email', true );
		if ( $email ) {
			echo '<p style="color:#646970">Correo (no se publica): ' . esc_html( $email ) . '</p>';
		}
	}, 'karu_testimonio', 'side' );
} );

add_action( 'save_post_karu_testimonio', function ( $id ) {
	if ( ! isset( $_POST['karu_opinion_nonce'] ) || ! wp_verify_nonce( $_POST['karu_opinion_nonce'], 'karu_opinion' ) || ! current_user_can( 'edit_post', $id ) ) {
		return;
	}
	update_post_meta( $id, '_karu_comuna', sanitize_text_field( wp_unslash( $_POST['karu_comuna'] ?? '' ) ) );
	update_post_meta( $id, '_karu_experiencia', sanitize_text_field( wp_unslash( $_POST['karu_experiencia'] ?? '' ) ) );
	update_post_meta( $id, '_karu_productos', sanitize_text_field( wp_unslash( $_POST['karu_productos'] ?? '' ) ) );
	update_post_meta( $id, '_karu_tipo', sanitize_text_field( wp_unslash( $_POST['karu_tipo'] ?? '' ) ) );
	update_post_meta( $id, '_karu_autoriza', isset( $_POST['karu_autoriza'] ) ? 1 : 0 );
} );

add_filter( 'manage_karu_testimonio_posts_columns', function ( $cols ) {
	return array(
		'cb'          => $cols['cb'],
		'title'       => 'Nombre',
		'karu_texto'  => 'Opinión',
		'karu_sobre'  => 'Sobre',
		'karu_exp'    => 'Experiencia',
		'karu_aut'    => 'Autorizó',
		'date'        => $cols['date'],
	);
} );

add_action( 'manage_karu_testimonio_posts_custom_column', function ( $col, $id ) {
	if ( $col === 'karu_texto' ) {
		echo esc_html( wp_trim_words( get_post_field( 'post_content', $id ), 18 ) );
	} elseif ( $col === 'karu_sobre' ) {
		echo esc_html( karu_opinion_sobre( $id ) );
	} elseif ( $col === 'karu_exp' ) {
		echo esc_html( get_post_meta( $id, '_karu_experiencia', true ) );
	} elseif ( $col === 'karu_aut' ) {
		echo get_post_meta( $id, '_karu_autoriza', true ) ? 'Sí' : '<strong style="color:#b32d2e">No</strong>';
	}
}, 10, 2 );

/* ------------------------------------------------------------------ Sección pública */

add_shortcode( 'karu_testimonios', function ( $atts ) {
	$atts      = shortcode_atts( array( 'cantidad' => 3 ), $atts );
	$opiniones = get_posts( array(
		'post_type'      => 'karu_testimonio',
		'post_status'    => 'publish',
		'posts_per_page' => max( 1, (int) $atts['cantidad'] ),
		'meta_key'       => '_karu_autoriza',
		'meta_value'     => 1,
	) );
	$comilla = '<svg class="karu-op__comilla" viewBox="0 0 448 512" width="28" height="28" aria-hidden="true" focusable="false"><path fill="currentColor" d="M0 216C0 149.7 53.7 96 120 96h8c17.7 0 32 14.3 32 32s-14.3 32-32 32h-8c-30.9 0-56 25.1-56 56v8h64c35.3 0 64 28.7 64 64v64c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V216zm256 0c0-66.3 53.7-120 120-120h8c17.7 0 32 14.3 32 32s-14.3 32-32 32h-8c-30.9 0-56 25.1-56 56v8h64c35.3 0 64 28.7 64 64v64c0 35.3-28.7 64-64 64H320c-35.3 0-64-28.7-64-64V216z"/></svg>';
	$html    = '<div class="karu-op">';
	foreach ( $opiniones as $op ) {
		$comuna = get_post_meta( $op->ID, '_karu_comuna', true );
		$exp    = get_post_meta( $op->ID, '_karu_experiencia', true );
		$sobre  = karu_opinion_sobre( $op->ID );
		$html  .= '<figure class="karu-op__card">' . $comilla
			. ( $sobre ? '<span class="karu-op__sobre">Sobre: ' . esc_html( $sobre ) . '</span>' : '' )
			. '<blockquote>' . wpautop( esc_html( $op->post_content ) ) . '</blockquote>'
			. '<figcaption><strong>' . esc_html( $op->post_title ) . '</strong>' . ( $comuna ? '<span>' . esc_html( $comuna ) . '</span>' : '' ) . '</figcaption>'
			. ( $exp ? '<span class="karu-op__exp">Experiencia: ' . esc_html( $exp ) . '</span>' : '' )
			. '</figure>';
	}
	// Solo opiniones reales: sin recuadros vacíos.
	return $html . '</div>';
} );

add_action( 'wp_head', function () {
	?>
<style id="karu-testimonios">
.karu-op { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 380px)); justify-content: center; gap: 20px; }
.karu-op__card { margin: 0; display: flex; flex-direction: column; gap: 14px; padding: 28px; border-radius: 20px; background: #FFFFFF; border: 1px solid #E4ECF4; box-shadow: 0 4px 16px rgba(36,61,91,.05); color: #5B6C82; }
.karu-op__card--vacia { border: 2px dashed #CBD9E8; box-shadow: none; }
.karu-op__comilla { color: #B8E0FF; }
.karu-op blockquote { margin: 0; padding: 0; border: 0; font-style: normal; color: #243D5B; font-size: 16px; line-height: 1.6; }
.karu-op blockquote p { margin: 0 0 8px; }
.karu-op figcaption { display: flex; flex-direction: column; gap: 2px; margin-top: auto; }
.karu-op figcaption strong, .karu-op__card--vacia strong { color: #243D5B; font-size: 14px; font-weight: 700; }
.karu-op figcaption span { font-size: 14px; }
.karu-op__sobre { font-size: 12px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: #4A90E2; }
.karu-op__exp { align-self: flex-start; padding: 4px 10px; border-radius: 999px; background: #EDF6FF; color: #243D5B; font-size: 12px; font-weight: 700; }
@media (max-width: 767px) { .karu-op { grid-template-columns: 1fr; } }
</style>
	<?php
} );
