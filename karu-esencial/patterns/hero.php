<?php
/**
 * Title: Hero
 * Slug: karu-esencial/hero
 * Categories: karu-esencial, banner
 * Viewport Width: 1400
 * Description: Portada en panel celeste con título, botones de WhatsApp, ilustración y barra de datos clave.
 *
 * @package Karu_Esencial
 */

?>
<!-- wp:group {"tagName":"section","align":"full","className":"karu-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull karu-hero"><!-- wp:group {"align":"wide","className":"karu-hero__panel","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-hero__panel"><!-- wp:columns {"verticalAlignment":"center","className":"karu-hero__grid"} -->
<div class="wp-block-columns are-vertically-aligned-center karu-hero__grid"><!-- wp:column {"verticalAlignment":"center","className":"karu-hero__content"} -->
<div class="wp-block-column is-vertically-aligned-center karu-hero__content"><!-- wp:paragraph {"className":"karu-eyebrow"} -->
<p class="karu-eyebrow">Limpieza natural para tu hogar</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"karu-hero__title"} -->
<h1 class="wp-block-heading karu-hero__title">Un hogar impecable, <em>de forma natural</em>.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"karu-hero__lead"} -->
<p class="karu-hero__lead">Productos puros y multiusos para limpiar sin químicos agresivos, cuidando a tu familia, a tus mascotas y al planeta.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"karu-hero__actions"} -->
<div class="wp-block-buttons karu-hero__actions"><!-- wp:button {"className":"is-style-whatsapp","linkTarget":"_blank","rel":"noreferrer noopener"} -->
<div class="wp-block-button is-style-whatsapp"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( karu_esencial_whatsapp_url( 'Hola Karü Esencial, quiero hacer un pedido.' ) ); ?>" target="_blank" rel="noreferrer noopener">Pedir por WhatsApp</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline karu-btn-arrow"} -->
<div class="wp-block-button is-style-outline karu-btn-arrow"><a class="wp-block-button__link wp-element-button" href="#productos">Ver productos</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:list {"className":"karu-checklist karu-hero__trust"} -->
<ul class="wp-block-list karu-checklist karu-hero__trust"><!-- wp:list-item -->
<li>Seguros para niños y mascotas</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Despacho o retiro coordinado</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","className":"karu-hero__media"} -->
<div class="wp-block-column is-vertically-aligned-center karu-hero__media"><!-- wp:image {"className":"karu-hero__image"} -->
<figure class="wp-block-image karu-hero__image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-productos.svg' ) ); ?>" alt="Productos de limpieza natural Karü Esencial: vinagre, bicarbonato, percarbonato, aceite de oliva y café en grano"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"karu-float karu-float--top","layout":{"type":"default"}} -->
<div class="wp-block-group karu-float karu-float--top"><!-- wp:paragraph {"className":"karu-float__title"} -->
<p class="karu-float__title">100% natural</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"karu-float__text"} -->
<p class="karu-float__text">Biodegradable</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"karu-float karu-float--bottom","layout":{"type":"default"}} -->
<div class="wp-block-group karu-float karu-float--bottom"><!-- wp:paragraph {"className":"karu-float__title"} -->
<p class="karu-float__title">Sin químicos agresivos</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"karu-float__text"} -->
<p class="karu-float__text">Ni fragancias sintéticas</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"karu-stats","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide karu-stats"><!-- wp:group {"className":"karu-stat","layout":{"type":"default"}} -->
<div class="wp-block-group karu-stat"><!-- wp:paragraph {"className":"karu-stat__value"} -->
<p class="karu-stat__value">100%</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"karu-stat__label"} -->
<p class="karu-stat__label">Ingredientes de origen natural</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"karu-stat","layout":{"type":"default"}} -->
<div class="wp-block-group karu-stat"><!-- wp:paragraph {"className":"karu-stat__value"} -->
<p class="karu-stat__value">5</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"karu-stat__label"} -->
<p class="karu-stat__label">Esenciales para toda la casa</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"karu-stat","layout":{"type":"default"}} -->
<div class="wp-block-group karu-stat"><!-- wp:paragraph {"className":"karu-stat__value"} -->
<p class="karu-stat__value">0</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"karu-stat__label"} -->
<p class="karu-stat__label">Químicos agresivos o sintéticos</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"karu-stat","layout":{"type":"default"}} -->
<div class="wp-block-group karu-stat"><!-- wp:paragraph {"className":"karu-stat__value"} -->
<p class="karu-stat__value">1 mensaje</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"karu-stat__label"} -->
<p class="karu-stat__label">Y coordinamos tu pedido</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"karu-band","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull karu-band"><!-- wp:list {"className":"karu-band__list"} -->
<ul class="wp-block-list karu-band__list"><!-- wp:list-item -->
<li>Sin químicos agresivos</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Biodegradables</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Multiusos</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Seguros para mascotas</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Menos plástico</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
