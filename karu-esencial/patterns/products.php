<?php
/**
 * Title: Productos
 * Slug: karu-esencial/products
 * Categories: karu-esencial
 * Viewport Width: 1400
 * Description: Tarjetas de productos con imagen, usos principales y botón de pedido por WhatsApp.
 *
 * @package Karu_Esencial
 */

$karu_products = array(
	array(
		'image' => 'producto-vinagre.svg',
		'tag'   => 'Desengrasa · Desinfecta',
		'name'  => 'Vinagre incoloro de limpieza',
		'text'  => 'Elimina grasa, sarro y malos olores. Ideal para vidrios, baños, cocina y como suavizante natural de la ropa.',
	),
	array(
		'image' => 'producto-bicarbonato.svg',
		'tag'   => 'Limpia · Desodoriza',
		'name'  => 'Bicarbonato de sodio',
		'text'  => 'Abrasivo suave que limpia sin rayar. Quita manchas, neutraliza olores y deja ollas, hornos y superficies como nuevos.',
	),
	array(
		'image' => 'producto-percarbonato.svg',
		'tag'   => 'Blanquea · Oxígeno activo',
		'name'  => 'Percarbonato de sodio',
		'text'  => 'Blanqueador ecológico que libera oxígeno activo. Aviva la ropa blanca, remueve manchas difíciles y limpia juntas y tablas.',
	),
	array(
		'image' => 'producto-aceite-oliva.svg',
		'tag'   => 'Nutre · Da brillo',
		'name'  => 'Aceite de oliva',
		'text'  => 'Nutre y protege maderas, muebles y cueros. Devuelve el brillo al acero inoxidable y ayuda a retirar restos de adhesivo.',
	),
	array(
		'image' => 'producto-cafe.svg',
		'tag'   => 'Absorbe olores · Aromatiza',
		'name'  => 'Café en grano',
		'text'  => 'Neutralizador natural de olores para refrigerador, clóset y zapatero, que además deja un aroma cálido en tu hogar.',
	),
);
?>
<!-- wp:group {"tagName":"section","anchor":"productos","align":"full","className":"karu-section karu-products","layout":{"type":"constrained"}} -->
<section id="productos" class="wp-block-group alignfull karu-section karu-products"><!-- wp:group {"className":"karu-section-head","layout":{"type":"default"}} -->
<div class="wp-block-group karu-section-head"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Nuestros productos</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Cinco esenciales para limpiar todo tu hogar</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-lead"} -->
<p class="karu-lead">Ingredientes simples, puros y de origen natural. Menos envases, menos químicos y resultados que se notan.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"karu-grid karu-products__grid","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-grid karu-products__grid">
<?php foreach ( $karu_products as $karu_product ) : ?>
<!-- wp:group {"tagName":"article","className":"karu-card karu-product","layout":{"type":"default"}} -->
<article class="wp-block-group karu-card karu-product"><!-- wp:image {"className":"karu-product__image"} -->
<figure class="wp-block-image karu-product__image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $karu_product['image'] ) ); ?>" alt="<?php echo esc_attr( $karu_product['name'] . ' Karü Esencial' ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"karu-product__body","layout":{"type":"default"}} -->
<div class="wp-block-group karu-product__body"><!-- wp:paragraph {"className":"karu-tag"} -->
<p class="karu-tag"><?php echo esc_html( $karu_product['tag'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"karu-card__title"} -->
<h3 class="wp-block-heading karu-card__title"><?php echo esc_html( $karu_product['name'] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-card__text"} -->
<p class="karu-card__text"><?php echo esc_html( $karu_product['text'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"karu-product__actions"} -->
<div class="wp-block-buttons karu-product__actions"><!-- wp:button {"width":100,"className":"is-style-whatsapp","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 is-style-whatsapp"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url( 'Hola Karü Esencial, quiero pedir: ' . $karu_product['name'] . '.' ) ); ?>" target="_blank" rel="noreferrer noopener">Pedir por WhatsApp</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></article>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></section>
<!-- /wp:group -->
