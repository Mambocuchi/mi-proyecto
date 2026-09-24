<?php
/**
 * Title: Galería
 * Slug: karu-esencial/gallery
 * Categories: karu-esencial, gallery
 * Viewport Width: 1400
 * Description: Imagen destacada de productos y comparaciones de limpieza antes y después.
 *
 * @package Karu_Esencial
 */

$karu_images   = get_theme_file_uri( 'assets/images/' );
$karu_compares = array(
	array(
		'title'  => 'Cocina',
		'uses'   => 'Vinagre + bicarbonato',
		'before' => array( 'galeria-cocina-antes.svg', 'Cocina con grasa y manchas antes de limpiar' ),
		'after'  => array( 'galeria-cocina-despues.svg', 'La misma cocina limpia y brillante después de la limpieza' ),
	),
	array(
		'title'  => 'Baño',
		'uses'   => 'Vinagre + percarbonato',
		'before' => array( 'galeria-bano-antes.svg', 'Lavamanos y llave con sarro antes de limpiar' ),
		'after'  => array( 'galeria-bano-despues.svg', 'El mismo lavamanos sin sarro y reluciente después de la limpieza' ),
	),
);
?>
<!-- wp:group {"tagName":"section","anchor":"galeria","align":"full","className":"karu-section karu-gallery","layout":{"type":"constrained"}} -->
<section id="galeria" class="wp-block-group alignfull karu-section karu-gallery"><!-- wp:group {"align":"wide","className":"karu-split-head","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-split-head"><!-- wp:group {"className":"karu-split-head__main","layout":{"type":"default"}} -->
<div class="wp-block-group karu-split-head__main"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Galería</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Resultados que <em>se ven</em></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"karu-lead karu-split-head__aside"} -->
<p class="karu-lead karu-split-head__aside">Superficies sin grasa, sin sarro y con brillo natural. Así se ve la limpieza con ingredientes nobles.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"karu-gallery__grid","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-gallery__grid"><!-- wp:image {"className":"karu-gallery__feature"} -->
<figure class="wp-block-image karu-gallery__feature"><img src="<?php echo esc_url( $karu_images . 'galeria-productos.svg' ); ?>" alt="Línea completa de productos Karü Esencial"/><figcaption class="wp-element-caption">Nuestra línea esencial</figcaption></figure>
<!-- /wp:image -->
<?php foreach ( $karu_compares as $karu_compare ) : ?>
<!-- wp:group {"className":"karu-compare","layout":{"type":"default"}} -->
<div class="wp-block-group karu-compare"><!-- wp:group {"className":"karu-compare__head","layout":{"type":"flex","justifyContent":"space-between"}} -->
<div class="wp-block-group karu-compare__head"><!-- wp:heading {"level":3,"className":"karu-compare__title"} -->
<h3 class="wp-block-heading karu-compare__title"><?php echo esc_html( $karu_compare['title'] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-tag"} -->
<p class="karu-tag"><?php echo esc_html( $karu_compare['uses'] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"karu-compare__pair","layout":{"type":"default"}} -->
<div class="wp-block-group karu-compare__pair"><!-- wp:image {"className":"karu-compare__image is-before"} -->
<figure class="wp-block-image karu-compare__image is-before"><img src="<?php echo esc_url( $karu_images . $karu_compare['before'][0] ); ?>" alt="<?php echo esc_attr( $karu_compare['before'][1] ); ?>"/><figcaption class="wp-element-caption">Antes</figcaption></figure>
<!-- /wp:image -->

<!-- wp:image {"className":"karu-compare__image is-after"} -->
<figure class="wp-block-image karu-compare__image is-after"><img src="<?php echo esc_url( $karu_images . $karu_compare['after'][0] ); ?>" alt="<?php echo esc_attr( $karu_compare['after'][1] ); ?>"/><figcaption class="wp-element-caption">Después</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></section>
<!-- /wp:group -->
