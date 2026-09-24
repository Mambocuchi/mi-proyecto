<?php
/**
 * Title: Preguntas frecuentes
 * Slug: karu-esencial/faq
 * Categories: karu-esencial
 * Viewport Width: 1400
 * Description: Acordeón de preguntas frecuentes con bloques Detalles nativos.
 *
 * @package Karu_Esencial
 */

$karu_faqs = array(
	array( '¿Son seguros para mascotas?', 'Sí. Son ingredientes de origen natural, sin fragancias sintéticas ni químicos agresivos. Como con cualquier producto de limpieza, guárdalos fuera del alcance de niños y mascotas y deja secar las superficies antes de que vuelvan a circular por ellas.' ),
	array( '¿Cómo se usan?', 'Cada producto tiene usos específicos: el vinagre desengrasa y quita sarro, el bicarbonato limpia y desodoriza, el percarbonato blanquea, el aceite de oliva nutre maderas y el café absorbe olores. Con tu pedido te enviamos por WhatsApp una guía simple con dosis y recomendaciones.' ),
	array( '¿Hacen envíos?', 'Sí. Coordinamos el despacho a domicilio dentro de nuestra zona de reparto o el retiro en un punto acordado. El costo y el horario de entrega te los confirmamos al momento de tu pedido.' ),
	array( '¿Cuáles son los medios de pago?', 'Puedes pagar por transferencia bancaria o en efectivo al recibir o retirar tu pedido. Te enviamos los datos al coordinar la compra por WhatsApp.' ),
	array( '¿Se pueden mezclar los productos?', 'Algunas combinaciones funcionan muy bien, como bicarbonato con vinagre para destapar desagües. Úsalas al momento y nunca las guardes mezcladas en envases cerrados, porque liberan gas. Y nunca combines ninguno de estos productos con cloro u otros limpiadores químicos.' ),
	array( '¿Cómo hago mi pedido?', 'Solo escríbenos por WhatsApp al +56 9 8904 8914 con los productos que quieres. Te respondemos en horario de atención y coordinamos todo contigo.' ),
);
?>
<!-- wp:group {"tagName":"section","anchor":"preguntas","align":"full","className":"karu-section karu-faq","layout":{"type":"constrained"}} -->
<section id="preguntas" class="wp-block-group alignfull karu-section karu-faq"><!-- wp:columns {"align":"wide","className":"karu-faq__grid"} -->
<div class="wp-block-columns alignwide karu-faq__grid"><!-- wp:column {"className":"karu-faq__intro"} -->
<div class="wp-block-column karu-faq__intro"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Preguntas frecuentes</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Resolvemos <em>tus dudas</em></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-lead"} -->
<p class="karu-lead">Todo lo que necesitas saber antes de hacer tu pedido.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"karu-help","layout":{"type":"default"}} -->
<div class="wp-block-group karu-help"><!-- wp:image {"className":"karu-icon"} -->
<figure class="wp-block-image karu-icon"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/icon-atencion.svg' ) ); ?>" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"className":"karu-help__title"} -->
<h3 class="wp-block-heading karu-help__title">¿Tienes otra pregunta?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-help__text"} -->
<p class="karu-help__text">Escríbenos y te respondemos personalmente en horario de atención.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-whatsapp","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button is-style-whatsapp"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url( 'Hola Karü Esencial, tengo una consulta.' ) ); ?>" target="_blank" rel="noreferrer noopener">Hacer una consulta</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"karu-faq__list"} -->
<div class="wp-block-column karu-faq__list">
<?php foreach ( $karu_faqs as $karu_faq ) : ?>
<!-- wp:details {"className":"karu-faq__item"} -->
<details class="wp-block-details karu-faq__item"><summary><?php echo esc_html( $karu_faq[0] ); ?></summary><!-- wp:paragraph -->
<p><?php echo esc_html( $karu_faq[1] ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<?php endforeach; ?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
