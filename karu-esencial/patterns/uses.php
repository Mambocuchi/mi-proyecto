<?php
/**
 * Title: Cómo usarlos
 * Slug: karu-esencial/uses
 * Categories: karu-esencial
 * Viewport Width: 1400
 * Description: Ideas de uso en el hogar en tarjetas simples.
 *
 * @package Karu_Esencial
 */

$karu_uses = array(
	array( 'icon-cocina.svg', 'Cocina', 'Desengrasa encimeras y campana con vinagre diluido en agua (1:1). Para ollas quemadas, espolvorea bicarbonato, agrega agua caliente y deja actuar.', 'Vinagre · Bicarbonato' ),
	array( 'icon-bano.svg', 'Baño', 'Elimina el sarro de llaves y mamparas con vinagre. Limpia juntas y azulejos con una pasta de percarbonato y agua tibia.', 'Vinagre · Percarbonato' ),
	array( 'icon-ropa.svg', 'Ropa', 'Agrega una cucharada de percarbonato al lavado para blanquear y media taza de vinagre en el enjuague como suavizante natural.', 'Percarbonato · Vinagre' ),
	array( 'icon-olores.svg', 'Eliminar olores', 'Deja un pocillo con café en grano o bicarbonato en el refrigerador, el clóset o el zapatero, y renuévalo cada mes.', 'Café · Bicarbonato' ),
	array( 'icon-manchas.svg', 'Quitar manchas', 'Aplica una pasta de bicarbonato con agua sobre la mancha, deja actuar 15 minutos y frota suavemente antes de lavar.', 'Bicarbonato · Percarbonato' ),
	array( 'icon-muebles.svg', 'Muebles y maderas', 'Aplica unas gotas de aceite de oliva en un paño suave para nutrir la madera y devolverle su brillo natural.', 'Aceite de oliva' ),
);
?>
<!-- wp:group {"tagName":"section","anchor":"como-usarlos","align":"full","className":"karu-section karu-uses","layout":{"type":"constrained"}} -->
<section id="como-usarlos" class="wp-block-group alignfull karu-section karu-uses"><!-- wp:group {"className":"karu-section-head","layout":{"type":"default"}} -->
<div class="wp-block-group karu-section-head"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Cómo usarlos</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"karu-section-title"} -->
<h2 class="wp-block-heading karu-section-title">Ideas simples para cada rincón de la casa</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-lead"} -->
<p class="karu-lead">Con pocos productos resuelves la limpieza diaria. Estas son algunas de las formas favoritas de nuestros clientes.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"karu-grid karu-grid--3","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-grid karu-grid--3">
<?php foreach ( $karu_uses as $karu_use ) : ?>
<!-- wp:group {"className":"karu-card karu-use","layout":{"type":"default"}} -->
<div class="wp-block-group karu-card karu-use"><!-- wp:image {"className":"karu-icon karu-icon--small"} -->
<figure class="wp-block-image karu-icon karu-icon--small"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $karu_use[0] ) ); ?>" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"className":"karu-card__title"} -->
<h3 class="wp-block-heading karu-card__title"><?php echo esc_html( $karu_use[1] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-card__text"} -->
<p class="karu-card__text"><?php echo esc_html( $karu_use[2] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"karu-tag"} -->
<p class="karu-tag"><?php echo esc_html( $karu_use[3] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"karu-note"} -->
<p class="karu-note">Prueba siempre primero en una zona pequeña y poco visible, y nunca mezcles estos productos con cloro u otros limpiadores químicos.</p>
<!-- /wp:paragraph --></section>
<!-- /wp:group -->
