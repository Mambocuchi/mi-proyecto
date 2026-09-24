<?php
/**
 * Title: Hero
 * Slug: karu-esencial/hero
 * Categories: karu-esencial, banner
 * Viewport Width: 1400
 * Description: Portada con título, beneficios clave y botones de pedido por WhatsApp.
 *
 * @package Karu_Esencial
 */

?>
<!-- wp:group {"tagName":"section","align":"full","className":"karu-section karu-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull karu-section karu-hero"><!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"karu-hero__grid"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center karu-hero__grid"><!-- wp:column {"verticalAlignment":"center","className":"karu-hero__content"} -->
<div class="wp-block-column is-vertically-aligned-center karu-hero__content"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Limpieza natural para tu hogar</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"karu-hero__title"} -->
<h1 class="wp-block-heading karu-hero__title">Un hogar impecable, <em>de forma natural</em>.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-lead"} -->
<p class="karu-lead">Productos puros y multiusos para limpiar sin químicos agresivos, cuidando a tu familia, a tus mascotas y al planeta.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"karu-hero__actions"} -->
<div class="wp-block-buttons karu-hero__actions"><!-- wp:button {"className":"is-style-whatsapp","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button is-style-whatsapp"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url( 'Hola Karü Esencial, quiero hacer un pedido.' ) ); ?>" target="_blank" rel="noreferrer noopener">Pedir por WhatsApp</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#productos">Ver productos</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:list {"className":"karu-checklist karu-hero__trust"} -->
<ul class="wp-block-list karu-checklist karu-hero__trust"><!-- wp:list-item -->
<li>Ingredientes 100% naturales</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Seguros para niños y mascotas</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Despacho o retiro coordinado</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","className":"karu-hero__media"} -->
<div class="wp-block-column is-vertically-aligned-center karu-hero__media"><!-- wp:image {"className":"karu-hero__image"} -->
<figure class="wp-block-image karu-hero__image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-productos.svg' ) ); ?>" alt="Productos de limpieza natural Karü Esencial sobre un mesón luminoso: vinagre, bicarbonato, percarbonato, aceite de oliva y café en grano"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"karu-hero__badge","layout":{"type":"default"}} -->
<div class="wp-block-group karu-hero__badge"><!-- wp:paragraph {"className":"karu-hero__badge-title"} -->
<p class="karu-hero__badge-title">Sin químicos agresivos</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"karu-hero__badge-text"} -->
<p class="karu-hero__badge-text">Ingredientes puros, sin fragancias sintéticas.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
