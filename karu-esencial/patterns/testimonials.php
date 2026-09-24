<?php
/**
 * Title: Testimonios
 * Slug: karu-esencial/testimonials
 * Categories: karu-esencial, testimonials
 * Viewport Width: 1400
 * Description: Tarjetas con opiniones de clientes. Reemplaza los textos de ejemplo por testimonios reales.
 *
 * @package Karu_Esencial
 */

$karu_testimonials = array(
	array( 'Desde que uso el percarbonato, la ropa blanca de mis hijos quedó como nueva. Y me quedo tranquila porque no tiene químicos fuertes.', 'Camila R.', 'Mamá de dos niños' ),
	array( 'Tengo dos perros y un gato. Con el vinagre y el bicarbonato limpio pisos y camas sin preocuparme de que se intoxiquen.', 'Javier M.', 'Tutor de tres mascotas' ),
	array( 'Me encantó la atención por WhatsApp: me explicaron cómo usar cada producto y el pedido llegó el mismo día que lo coordinamos.', 'Francisca P.', 'Clienta frecuente' ),
);
$karu_stars = get_theme_file_uri( 'assets/images/estrellas.svg' );
?>
<!-- wp:group {"tagName":"section","anchor":"testimonios","align":"full","className":"karu-section karu-section--tint karu-testimonials","layout":{"type":"constrained"}} -->
<section id="testimonios" class="wp-block-group alignfull karu-section karu-section--tint karu-testimonials"><!-- wp:group {"className":"karu-section-head","layout":{"type":"default"}} -->
<div class="wp-block-group karu-section-head"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Testimonios</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Hogares más limpios, familias más tranquilas</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"karu-grid karu-grid--3","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-grid karu-grid--3">
<?php foreach ( $karu_testimonials as $karu_testimonial ) : ?>
<!-- wp:group {"className":"karu-card karu-testimonial","layout":{"type":"default"}} -->
<div class="wp-block-group karu-card karu-testimonial"><!-- wp:image {"className":"karu-testimonial__stars"} -->
<figure class="wp-block-image karu-testimonial__stars"><img src="<?php echo esc_url( $karu_stars ); ?>" alt="Calificación: 5 de 5 estrellas"/></figure>
<!-- /wp:image -->

<!-- wp:quote {"className":"karu-testimonial__quote"} -->
<blockquote class="wp-block-quote karu-testimonial__quote"><!-- wp:paragraph -->
<p><?php echo esc_html( $karu_testimonial[0] ); ?></p>
<!-- /wp:paragraph --><cite><strong><?php echo esc_html( $karu_testimonial[1] ); ?></strong><br><?php echo esc_html( $karu_testimonial[2] ); ?></cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></section>
<!-- /wp:group -->
