<?php
/**
 * Title: Galería
 * Slug: karu-esencial/gallery
 * Categories: karu-esencial, gallery
 * Viewport Width: 1400
 * Description: Galería tipo mosaico con productos y resultados de limpieza antes y después.
 *
 * @package Karu_Esencial
 */

$karu_images = get_theme_file_uri( 'assets/images/' );
?>
<!-- wp:group {"tagName":"section","anchor":"galeria","align":"full","className":"karu-section karu-gallery","layout":{"type":"constrained"}} -->
<section id="galeria" class="wp-block-group alignfull karu-section karu-gallery"><!-- wp:group {"className":"karu-section-head","layout":{"type":"default"}} -->
<div class="wp-block-group karu-section-head"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Galería</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Resultados que se ven (y se sienten)</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-lead"} -->
<p class="karu-lead">Nuestros productos en acción: superficies sin grasa, sin sarro y con brillo natural.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"karu-gallery__grid","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-gallery__grid"><!-- wp:image {"className":"karu-gallery__item karu-gallery__item--feature"} -->
<figure class="wp-block-image karu-gallery__item karu-gallery__item--feature"><img src="<?php echo esc_url( $karu_images . 'galeria-productos.svg' ); ?>" alt="Línea completa de productos Karü Esencial"/><figcaption class="wp-element-caption">Nuestra línea esencial</figcaption></figure>
<!-- /wp:image -->

<!-- wp:image {"className":"karu-gallery__item is-before"} -->
<figure class="wp-block-image karu-gallery__item is-before"><img src="<?php echo esc_url( $karu_images . 'galeria-cocina-antes.svg' ); ?>" alt="Cocina con grasa y manchas antes de limpiar"/><figcaption class="wp-element-caption">Antes · Cocina</figcaption></figure>
<!-- /wp:image -->

<!-- wp:image {"className":"karu-gallery__item is-after"} -->
<figure class="wp-block-image karu-gallery__item is-after"><img src="<?php echo esc_url( $karu_images . 'galeria-cocina-despues.svg' ); ?>" alt="La misma cocina limpia y brillante después de usar vinagre y bicarbonato"/><figcaption class="wp-element-caption">Después · Cocina</figcaption></figure>
<!-- /wp:image -->

<!-- wp:image {"className":"karu-gallery__item is-before"} -->
<figure class="wp-block-image karu-gallery__item is-before"><img src="<?php echo esc_url( $karu_images . 'galeria-bano-antes.svg' ); ?>" alt="Lavamanos y llave con sarro antes de limpiar"/><figcaption class="wp-element-caption">Antes · Baño</figcaption></figure>
<!-- /wp:image -->

<!-- wp:image {"className":"karu-gallery__item is-after"} -->
<figure class="wp-block-image karu-gallery__item is-after"><img src="<?php echo esc_url( $karu_images . 'galeria-bano-despues.svg' ); ?>" alt="El mismo lavamanos sin sarro y reluciente después de la limpieza"/><figcaption class="wp-element-caption">Después · Baño</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
