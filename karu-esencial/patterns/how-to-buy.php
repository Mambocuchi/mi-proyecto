<?php
/**
 * Title: Cómo comprar
 * Slug: karu-esencial/how-to-buy
 * Categories: karu-esencial
 * Viewport Width: 1400
 * Description: Proceso de compra en cuatro pasos con botón de WhatsApp.
 *
 * @package Karu_Esencial
 */

$karu_steps = array(
	array( 'Elige tus productos', 'Revisa nuestro catálogo y anota los productos y cantidades que necesitas.' ),
	array( 'Escríbenos por WhatsApp', 'Envíanos tu pedido y resolvemos tus dudas al instante, sin formularios.' ),
	array( 'Coordina la entrega o retiro', 'Acordamos juntos el día, el horario y el medio de pago que más te acomode.' ),
	array( 'Disfruta tu hogar limpio', 'Recibe tus productos y siente la diferencia de limpiar de forma natural.' ),
);
?>
<!-- wp:group {"tagName":"section","anchor":"como-comprar","align":"full","className":"karu-section karu-section--tint karu-steps","layout":{"type":"constrained"}} -->
<section id="como-comprar" class="wp-block-group alignfull karu-section karu-section--tint karu-steps"><!-- wp:group {"className":"karu-section-head","layout":{"type":"default"}} -->
<div class="wp-block-group karu-section-head"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Cómo comprar</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Pedir es tan fácil como enviar un mensaje</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-lead"} -->
<p class="karu-lead">Sin registros ni carritos: hablas directamente con nosotros y recibes atención personalizada.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"tagName":"ol","align":"wide","className":"karu-grid karu-grid--4 karu-steps__list","layout":{"type":"default"}} -->
<ol class="wp-block-group alignwide karu-grid karu-grid--4 karu-steps__list">
<?php foreach ( $karu_steps as $karu_index => $karu_step ) : ?>
<!-- wp:group {"tagName":"li","className":"karu-card karu-step","layout":{"type":"default"}} -->
<li class="wp-block-group karu-card karu-step"><!-- wp:paragraph {"className":"karu-step__number"} -->
<p class="karu-step__number"><?php echo esc_html( sprintf( '%02d', $karu_index + 1 ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"karu-card__title"} -->
<h3 class="wp-block-heading karu-card__title"><?php echo esc_html( $karu_step[0] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-card__text"} -->
<p class="karu-card__text"><?php echo esc_html( $karu_step[1] ); ?></p>
<!-- /wp:paragraph --></li>
<!-- /wp:group -->
<?php endforeach; ?>
</ol>
<!-- /wp:group -->

<!-- wp:buttons {"className":"karu-center-actions","layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons karu-center-actions"><!-- wp:button {"className":"is-style-whatsapp","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button is-style-whatsapp"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url( 'Hola Karü Esencial, quiero hacer un pedido.' ) ); ?>" target="_blank" rel="noreferrer noopener">Empezar mi pedido por WhatsApp</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></section>
<!-- /wp:group -->
