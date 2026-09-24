<?php
/**
 * Title: Llamado a la acción final
 * Slug: karu-esencial/cta
 * Categories: karu-esencial, call-to-action
 * Viewport Width: 1400
 * Description: Panel destacado con botón grande para pedir por WhatsApp.
 *
 * @package Karu_Esencial
 */

?>
<!-- wp:group {"tagName":"section","anchor":"pedido","align":"full","className":"karu-section karu-cta","layout":{"type":"constrained"}} -->
<section id="pedido" class="wp-block-group alignfull karu-section karu-cta"><!-- wp:group {"align":"wide","className":"karu-cta__panel","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide karu-cta__panel"><!-- wp:paragraph {"className":"karu-eyebrow karu-eyebrow--light"} -->
<p class="karu-eyebrow karu-eyebrow--light">Haz tu pedido hoy</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-cta__title"} -->
<h2 class="wp-block-heading karu-cta__title">Tu hogar más limpio y natural empieza con un mensaje</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-cta__text"} -->
<p class="karu-cta__text">Cuéntanos qué necesitas y te ayudamos a elegir los productos ideales para tu casa, tu familia y tus mascotas.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-light karu-button--xl","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button is-style-light karu-button--xl"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url( 'Hola Karü Esencial, quiero hacer un pedido.' ) ); ?>" target="_blank" rel="noreferrer noopener">Haz tu pedido por WhatsApp</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"className":"karu-cta__small"} -->
<p class="karu-cta__small">+56 9 8904 8914 · Respondemos en horario de atención</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
