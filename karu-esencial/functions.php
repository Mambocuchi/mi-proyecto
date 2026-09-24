<?php
/**
 * Funciones del tema Karü Esencial.
 *
 * @package Karu_Esencial
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KARU_ESENCIAL_WHATSAPP', '56989048914' );

/**
 * Configuración base del tema.
 */
function karu_esencial_setup() {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/styles.css' );
}
add_action( 'after_setup_theme', 'karu_esencial_setup' );

/**
 * Carga la hoja de estilos del tema (assets/css/styles.css).
 *
 * Prioridad 20 para que se imprima después de los estilos globales y de bloques.
 */
function karu_esencial_enqueue_styles() {
	$path = get_theme_file_path( 'assets/css/styles.css' );

	wp_enqueue_style(
		'karu-esencial',
		get_theme_file_uri( 'assets/css/styles.css' ),
		array(),
		(string) filemtime( $path )
	);
}
add_action( 'wp_enqueue_scripts', 'karu_esencial_enqueue_styles', 20 );

/**
 * Precarga las fuentes locales para mejorar el LCP.
 */
function karu_esencial_preload_fonts() {
	$fonts = array( 'fraunces-latin-wght.woff2', 'plus-jakarta-sans-latin-wght.woff2' );

	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_theme_file_uri( 'assets/fonts/' . $font ) )
		);
	}
}
add_action( 'wp_head', 'karu_esencial_preload_fonts', 1 );

/**
 * Quita el script de emojis: el tema no lo necesita.
 */
function karu_esencial_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'karu_esencial_disable_emojis' );

/**
 * Categoría de patrones y estilo de botón "WhatsApp".
 */
function karu_esencial_register_block_assets() {
	register_block_pattern_category(
		'karu-esencial',
		array(
			'label'       => __( 'Karü Esencial', 'karu-esencial' ),
			'description' => __( 'Secciones de la landing page de Karü Esencial.', 'karu-esencial' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'whatsapp',
			'label' => __( 'WhatsApp', 'karu-esencial' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'light',
			'label' => __( 'Claro', 'karu-esencial' ),
		)
	);
}
add_action( 'init', 'karu_esencial_register_block_assets' );

/**
 * Devuelve el enlace de WhatsApp, opcionalmente con un mensaje prellenado.
 *
 * @param string $message Mensaje inicial del chat.
 * @return string
 */
function karu_esencial_whatsapp_url( $message = '' ) {
	$url = 'https://wa.me/' . KARU_ESENCIAL_WHATSAPP;

	if ( '' !== $message ) {
		$url .= '?text=' . rawurlencode( $message );
	}

	return $url;
}

/**
 * Devuelve el contenido de bloques de la landing completa.
 *
 * @return string
 */
function karu_esencial_get_landing_content() {
	ob_start();
	include get_theme_file_path( 'patterns/landing.php' );
	return ob_get_clean();
}

/**
 * Al activar el tema, crea la página "Inicio" con la landing completa
 * (editable desde el editor de páginas) y la define como portada.
 */
function karu_esencial_create_landing_page() {
	$page_id = (int) get_option( 'karu_esencial_landing_page_id' );

	if ( $page_id && 'page' === get_post_type( $page_id ) && 'trash' !== get_post_status( $page_id ) ) {
		return;
	}

	$page_id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => __( 'Inicio', 'karu-esencial' ),
			'post_content' => wp_slash( karu_esencial_get_landing_content() ),
		)
	);

	if ( ! $page_id || is_wp_error( $page_id ) ) {
		return;
	}

	update_post_meta( $page_id, '_wp_page_template', 'page-landing' );
	update_option( 'karu_esencial_landing_page_id', $page_id );
	update_option( 'karu_esencial_landing_version', wp_get_theme()->get( 'Version' ) );

	if ( 'page' !== get_option( 'show_on_front' ) || ! get_option( 'page_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_id );
	}
}
add_action( 'after_switch_theme', 'karu_esencial_create_landing_page' );

/**
 * Al actualizar el tema, renueva el diseño de la página "Inicio" solo si
 * nunca fue editada (fecha de modificación igual a la de creación).
 * Si ya tiene cambios del usuario, no se toca.
 */
function karu_esencial_maybe_update_landing_page() {
	$version = wp_get_theme()->get( 'Version' );

	if ( get_option( 'karu_esencial_landing_version' ) === $version || ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	update_option( 'karu_esencial_landing_version', $version );

	$page = get_post( (int) get_option( 'karu_esencial_landing_page_id' ) );

	if ( ! $page || 'page' !== $page->post_type || 'trash' === $page->post_status || $page->post_modified_gmt !== $page->post_date_gmt ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => wp_slash( karu_esencial_get_landing_content() ),
		)
	);

	// Conserva la fecha original para que futuras versiones también puedan actualizarla.
	global $wpdb;
	$wpdb->update(
		$wpdb->posts,
		array(
			'post_modified'     => $page->post_date,
			'post_modified_gmt' => $page->post_date_gmt,
		),
		array( 'ID' => $page->ID )
	);
	clean_post_cache( $page->ID );
}
add_action( 'admin_init', 'karu_esencial_maybe_update_landing_page' );
