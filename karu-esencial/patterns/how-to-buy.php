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
<!-- wp:group {"tagName":"section","anchor":"como-comprar","align":"full","className":"karu-section karu-section--dark karu-steps","layout":{"type":"constrained"}} -->
<section id="como-comprar" class="wp-block-group alignfull karu-section karu-section--dark karu-steps"><!-- wp:group {"align":"wide","className":"karu-split-head","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-split-head"><!-- wp:group {"className":"karu-split-head__main","layout":{"type":"default"}} -->
<div class="wp-block-group karu-split-head__main"><!-- wp:paragraph {"className":"karu-eyebrow karu-eyebrow--light"} -->
<p class="karu-eyebrow karu-eyebrow--light">Cómo comprar</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Pedir es tan fácil como <em>enviar un mensaje</em></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"karu-lead karu-split-head__aside"} -->
<p class="karu-lead karu-split-head__aside">Sin registros ni carritos: hablas directamente con nosotros y recibes atención personalizada de principio a fin.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"tagName":"ol","align":"wide","className":"karu-grid karu-grid--4 karu-steps__list","layout":{"type":"default"}} -->
<ol class="wp-block-group alignwide karu-grid karu-grid--4 karu-steps__list">
<?php foreach ( $karu_steps as $karu_index => $karu_step ) : ?>
<!-- wp:group {"tagName":"li","className":"karu-step","layout":{"type":"default"}} -->
<li class="wp-block-group karu-step"><!-- wp:paragraph {"className":"karu-step__number"} -->
<p class="karu-step__number"><?php echo esc_html( sprintf( '%02d', $karu_index + 1 ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"karu-step__title"} -->
<h3 class="wp-block-heading karu-step__title"><?php echo esc_html( $karu_step[0] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-step__text"} -->
<p class="karu-step__text"><?php echo esc_html( $karu_step[1] ); ?></p>
<!-- /wp:paragraph --></li>
<!-- /wp:group -->
<?php endforeach; ?>
</ol>
<!-- /wp:group -->

<!-- wp:buttons {"align":"wide","className":"karu-center-actions"} -->
<div class="wp-block-buttons alignwide karu-center-actions"><!-- wp:button {"className":"is-style-light","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button is-style-light"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url( 'Hola Karü Esencial, quiero hacer un pedido.' ) ); ?>" target="_blank" rel="noreferrer noopener">Empezar mi pedido por WhatsApp</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></section>
<!-- /wp:group -->
