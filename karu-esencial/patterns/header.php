<?php
/**
 * Title: Encabezado
 * Slug: karu-esencial/header
 * Categories: header
 * Block Types: core/template-part/header
 * Inserter: no
 * Description: Logo, menú de anclas y botón de pedido por WhatsApp.
 *
 * @package Karu_Esencial
 */

$karu_home = home_url( '/' );
?>
<!-- wp:group {"align":"full","className":"karu-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull karu-header"><!-- wp:group {"align":"wide","className":"karu-header__inner","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide karu-header__inner"><!-- wp:image {"linkDestination":"custom","className":"karu-logo"} -->
<figure class="wp-block-image karu-logo"><a href="<?php echo esc_url( $karu_home ); ?>"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo.svg' ) ); ?>" alt="Karü Esencial, ir al inicio"/></a></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"karu-header__actions","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group karu-header__actions"><!-- wp:navigation {"overlayMenu":"mobile","className":"karu-nav","layout":{"type":"flex","justifyContent":"right"}} -->
<!-- wp:navigation-link {"label":"Productos","url":"<?php echo esc_url( $karu_home . '#productos' ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Beneficios","url":"<?php echo esc_url( $karu_home . '#beneficios' ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Cómo usarlos","url":"<?php echo esc_url( $karu_home . '#como-usarlos' ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Cómo comprar","url":"<?php echo esc_url( $karu_home . '#como-comprar' ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Preguntas","url":"<?php echo esc_url( $karu_home . '#preguntas' ); ?>","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:buttons {"className":"karu-header__cta"} -->
<div class="wp-block-buttons karu-header__cta"><!-- wp:button {"className":"is-style-whatsapp","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button is-style-whatsapp"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url( 'Hola Karü Esencial, quiero hacer un pedido.' ) ); ?>" target="_blank" rel="noreferrer noopener">Pedir por WhatsApp</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
