<?php
/**
 * Title: Beneficios
 * Slug: karu-esencial/benefits
 * Categories: karu-esencial, about
 * Viewport Width: 1400
 * Description: Razones para elegir Karü Esencial: introducción con promesa de marca y lista de beneficios con íconos.
 *
 * @package Karu_Esencial
 */

$karu_benefits = array(
	array( 'icon-natural.svg', '100% naturales', 'Ingredientes puros y de origen natural, sin fragancias sintéticas ni químicos agresivos.' ),
	array( 'icon-mascotas.svg', 'Seguros para niños y mascotas', 'Limpia con tranquilidad los espacios donde tu familia y tus mascotas juegan y descansan.' ),
	array( 'icon-multiuso.svg', 'Multiusos', 'Pocos productos que resuelven toda la casa: cocina, baño, ropa, pisos y más.' ),
	array( 'icon-ahorro.svg', 'Económicos', 'Rinden muchísimo y reemplazan a varios limpiadores. Ahorras dinero y espacio.' ),
	array( 'icon-planeta.svg', 'Amigables con el planeta', 'Biodegradables y con menos envases plásticos, para cuidar el agua y la tierra.' ),
	array( 'icon-atencion.svg', 'Atención personalizada', 'Te asesoramos por WhatsApp para elegir los productos ideales y usarlos bien.' ),
);
?>
<!-- wp:group {"tagName":"section","anchor":"beneficios","align":"full","className":"karu-section karu-section--tint karu-benefits","layout":{"type":"constrained"}} -->
<section id="beneficios" class="wp-block-group alignfull karu-section karu-section--tint karu-benefits"><!-- wp:columns {"align":"wide","className":"karu-benefits__grid"} -->
<div class="wp-block-columns alignwide karu-benefits__grid"><!-- wp:column {"className":"karu-benefits__intro"} -->
<div class="wp-block-column karu-benefits__intro"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Por qué elegirnos</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Limpieza que cuida <em>lo que más quieres</em></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-lead"} -->
<p class="karu-lead">Un hogar limpio no tiene por qué oler a químicos. Por eso elegimos ingredientes nobles que funcionan.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"karu-promise","layout":{"type":"default"}} -->
<div class="wp-block-group karu-promise"><!-- wp:paragraph {"className":"karu-promise__quote"} -->
<p class="karu-promise__quote">“Si no lo usaríamos en nuestra propia casa, no llega a la tuya.”</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"karu-promise__author"} -->
<p class="karu-promise__author">Equipo Karü Esencial</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"karu-benefits__list"} -->
<div class="wp-block-column karu-benefits__list"><!-- wp:group {"className":"karu-features","layout":{"type":"default"}} -->
<div class="wp-block-group karu-features">
<?php foreach ( $karu_benefits as $karu_benefit ) : ?>
<!-- wp:group {"className":"karu-feature","layout":{"type":"default"}} -->
<div class="wp-block-group karu-feature"><!-- wp:image {"className":"karu-icon"} -->
<figure class="wp-block-image karu-icon"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $karu_benefit[0] ) ); ?>" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"className":"karu-feature__title"} -->
<h3 class="wp-block-heading karu-feature__title"><?php echo esc_html( $karu_benefit[1] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-feature__text"} -->
<p class="karu-feature__text"><?php echo esc_html( $karu_benefit[2] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
