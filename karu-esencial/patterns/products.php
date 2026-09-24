<?php
/**
 * Title: Productos
 * Slug: karu-esencial/products
 * Categories: karu-esencial
 * Viewport Width: 1400
 * Description: Mosaico de productos con uno destacado, usos principales y botón de pedido por WhatsApp.
 *
 * @package Karu_Esencial
 */

$karu_products = array(
	array(
		'image' => 'producto-bicarbonato.svg',
		'tag'   => 'Limpia · Desodoriza',
		'name'  => 'Bicarbonato de sodio',
		'text'  => 'Abrasivo suave que limpia sin rayar. Quita manchas, neutraliza olores y deja ollas y hornos como nuevos.',
	),
	array(
		'image' => 'producto-percarbonato.svg',
		'tag'   => 'Blanquea · Oxígeno activo',
		'name'  => 'Percarbonato de sodio',
		'text'  => 'Blanqueador ecológico que aviva la ropa blanca, remueve manchas difíciles y limpia juntas y tablas.',
	),
	array(
		'image' => 'producto-aceite-oliva.svg',
		'tag'   => 'Nutre · Da brillo',
		'name'  => 'Aceite de oliva',
		'text'  => 'Nutre y protege maderas, muebles y cueros, y devuelve el brillo al acero inoxidable.',
	),
	array(
		'image' => 'producto-cafe.svg',
		'tag'   => 'Absorbe olores',
		'name'  => 'Café en grano',
		'text'  => 'Neutraliza olores en refrigerador, clóset y zapatero, y deja un aroma cálido en tu hogar.',
	),
);
?>
<!-- wp:group {"tagName":"section","anchor":"productos","align":"full","className":"karu-section karu-products","layout":{"type":"constrained"}} -->
<section id="productos" class="wp-block-group alignfull karu-section karu-products"><!-- wp:group {"align":"wide","className":"karu-split-head","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-split-head"><!-- wp:group {"className":"karu-split-head__main","layout":{"type":"default"}} -->
<div class="wp-block-group karu-split-head__main"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Nuestros productos</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Cinco esenciales para <em>todo tu hogar</em></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"karu-lead karu-split-head__aside"} -->
<p class="karu-lead karu-split-head__aside">Ingredientes simples, puros y de origen natural. Menos envases, menos químicos y resultados que se notan desde el primer uso.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"karu-products__grid","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-products__grid"><!-- wp:group {"tagName":"article","className":"karu-product karu-product--featured","layout":{"type":"default"}} -->
<article class="wp-block-group karu-product karu-product--featured"><!-- wp:paragraph {"className":"karu-product__badge"} -->
<p class="karu-product__badge">Esencial n.º 1</p>
<!-- /wp:paragraph -->

<!-- wp:image {"className":"karu-product__image"} -->
<figure class="wp-block-image karu-product__image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/producto-vinagre-destacado.svg' ) ); ?>" alt="Vinagre incoloro de limpieza Karü Esencial"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"karu-product__body","layout":{"type":"default"}} -->
<div class="wp-block-group karu-product__body"><!-- wp:paragraph {"className":"karu-tag"} -->
<p class="karu-tag">Desengrasa · Desinfecta</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"karu-product__title"} -->
<h3 class="wp-block-heading karu-product__title">Vinagre incoloro de limpieza</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-product__text"} -->
<p class="karu-product__text">El multiuso por excelencia: elimina grasa, sarro y malos olores en toda la casa.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"karu-checklist karu-product__uses"} -->
<ul class="wp-block-list karu-checklist karu-product__uses"><!-- wp:list-item -->
<li>Vidrios y espejos sin marcas</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Sarro en baño y cocina</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Suavizante natural de ropa</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons {"className":"karu-product__actions"} -->
<div class="wp-block-buttons karu-product__actions"><!-- wp:button {"className":"is-style-whatsapp","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button is-style-whatsapp"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url( 'Hola Karü Esencial, quiero pedir: Vinagre incoloro de limpieza.' ) ); ?>" target="_blank" rel="noreferrer noopener">Pedir por WhatsApp</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></article>
<!-- /wp:group -->
<?php foreach ( $karu_products as $karu_product ) : ?>
<!-- wp:group {"tagName":"article","className":"karu-product","layout":{"type":"default"}} -->
<article class="wp-block-group karu-product"><!-- wp:image {"className":"karu-product__image"} -->
<figure class="wp-block-image karu-product__image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $karu_product['image'] ) ); ?>" alt="<?php echo esc_attr( $karu_product['name'] . ' Karü Esencial' ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"karu-product__body","layout":{"type":"default"}} -->
<div class="wp-block-group karu-product__body"><!-- wp:paragraph {"className":"karu-tag"} -->
<p class="karu-tag"><?php echo esc_html( $karu_product['tag'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"karu-product__title"} -->
<h3 class="wp-block-heading karu-product__title"><?php echo esc_html( $karu_product['name'] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-product__text"} -->
<p class="karu-product__text"><?php echo esc_html( $karu_product['text'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"karu-product__actions"} -->
<div class="wp-block-buttons karu-product__actions"><!-- wp:button {"className":"is-style-whatsapp","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button is-style-whatsapp"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url( 'Hola Karü Esencial, quiero pedir: ' . $karu_product['name'] . '.' ) ); ?>" target="_blank" rel="noreferrer noopener">Pedir por WhatsApp</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></article>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></section>
<!-- /wp:group -->
