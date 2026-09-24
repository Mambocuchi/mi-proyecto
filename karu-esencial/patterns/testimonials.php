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
	array( 'Desde que uso el percarbonato, la ropa blanca de mis hijos quedó como nueva. Y lo mejor: limpio toda la casa sin ese olor fuerte a químicos. Me quedo tranquila porque los niños juegan en el suelo todo el día.', 'Camila R.', 'Mamá de dos niños' ),
	array( 'Tengo dos perros y un gato. Con el vinagre y el bicarbonato limpio pisos y camas sin preocuparme de que se intoxiquen.', 'Javier M.', 'Tutor de tres mascotas' ),
	array( 'Me encantó la atención por WhatsApp: me explicaron cómo usar cada producto y el pedido llegó el mismo día que lo coordinamos.', 'Francisca P.', 'Clienta frecuente' ),
);
$karu_stars       = get_theme_file_uri( 'assets/images/estrellas.svg' );
$karu_stars_light = get_theme_file_uri( 'assets/images/estrellas-claras.svg' );
?>
<!-- wp:group {"tagName":"section","anchor":"testimonios","align":"full","className":"karu-section karu-section--sky karu-testimonials","layout":{"type":"constrained"}} -->
<section id="testimonios" class="wp-block-group alignfull karu-section karu-section--sky karu-testimonials"><!-- wp:group {"className":"karu-section-head","layout":{"type":"default"}} -->
<div class="wp-block-group karu-section-head"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Testimonios</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Hogares más limpios, <em>familias más tranquilas</em></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"karu-testimonials__grid","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-testimonials__grid">
<?php foreach ( $karu_testimonials as $karu_index => $karu_testimonial ) : ?>
<?php if ( 0 === $karu_index ) : ?>
<!-- wp:group {"className":"karu-card karu-testimonial karu-testimonial--featured","layout":{"type":"default"}} -->
<div class="wp-block-group karu-card karu-testimonial karu-testimonial--featured"><!-- wp:image {"className":"karu-testimonial__stars"} -->
<figure class="wp-block-image karu-testimonial__stars"><img src="<?php echo esc_url( $karu_stars_light ); ?>" alt="Calificación: 5 de 5 estrellas"/></figure>
<?php else : ?>
<!-- wp:group {"className":"karu-card karu-testimonial","layout":{"type":"default"}} -->
<div class="wp-block-group karu-card karu-testimonial"><!-- wp:image {"className":"karu-testimonial__stars"} -->
<figure class="wp-block-image karu-testimonial__stars"><img src="<?php echo esc_url( $karu_stars ); ?>" alt="Calificación: 5 de 5 estrellas"/></figure>
<?php endif; ?>
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
