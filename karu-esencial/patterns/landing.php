<?php
/**
 * Title: Landing page completa
 * Slug: karu-esencial/landing
 * Categories: karu-esencial, featured
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Viewport Width: 1400
 * Description: Todas las secciones de la landing de Karü Esencial en una sola página.
 *
 * @package Karu_Esencial
 */

$karu_sections = array( 'hero', 'products', 'benefits', 'uses', 'how-to-buy', 'gallery', 'testimonials', 'faq', 'cta' );

foreach ( $karu_sections as $karu_section ) {
	require get_theme_file_path( 'patterns/' . $karu_section . '.php' );
	echo "\n\n";
}
