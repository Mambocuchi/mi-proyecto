<?php
/**
 * Title: Contenido 404
 * Slug: karu-esencial/404
 * Inserter: no
 * Description: Mensaje para páginas no encontradas.
 *
 * @package Karu_Esencial
 */

?>
<!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Error 404</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"karu-section-title"} -->
<h1 class="wp-block-heading karu-section-title">Esta página no existe</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-lead"} -->
<p class="karu-lead">Puede que el enlace haya cambiado. Vuelve al inicio para conocer nuestros productos de limpieza natural.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">Volver al inicio</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url() ); ?>" target="_blank" rel="noreferrer noopener">Escríbenos por WhatsApp</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
