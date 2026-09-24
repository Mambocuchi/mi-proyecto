<?php
/**
 * Title: Pie de página
 * Slug: karu-esencial/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Inserter: no
 * Description: Logo, horarios, zona de despacho, redes sociales y contacto.
 *
 * @package Karu_Esencial
 */

?>
<!-- wp:group {"align":"full","className":"karu-footer","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull karu-footer"><!-- wp:columns {"align":"wide","className":"karu-footer__grid"} -->
<div class="wp-block-columns alignwide karu-footer__grid"><!-- wp:column {"className":"karu-footer__brand"} -->
<div class="wp-block-column karu-footer__brand"><!-- wp:image {"linkDestination":"custom","className":"karu-logo"} -->
<figure class="wp-block-image karu-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo-light.svg' ) ); ?>" alt="Karü Esencial, ir al inicio"/></a></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Productos de limpieza naturales para un hogar sano, seguro y sustentable.</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"openInNewTab":true,"className":"is-style-logos-only karu-social"} -->
<ul class="wp-block-social-links is-style-logos-only karu-social"><!-- wp:social-link {"url":"https://www.facebook.com/","service":"facebook","label":"Facebook de Karü Esencial"} /-->

<!-- wp:social-link {"url":"https://wa.me/56989048914","service":"whatsapp","label":"WhatsApp de Karü Esencial"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"className":"karu-footer__title"} -->
<h2 class="wp-block-heading karu-footer__title">Horario de atención</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Lunes a viernes: 9:00 a 19:00<br>Sábados: 10:00 a 14:00<br>Domingos y festivos: cerrado</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"className":"karu-footer__title"} -->
<h2 class="wp-block-heading karu-footer__title">Despacho y retiro</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Despacho a domicilio dentro de nuestra zona de reparto.<br>Retiro en punto acordado previamente.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"className":"karu-footer__title"} -->
<h2 class="wp-block-heading karu-footer__title">Contacto</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>WhatsApp: <a href="https://wa.me/56989048914" target="_blank" rel="noreferrer noopener">+56 9 8904 8914</a><br>Teléfono: <a href="tel:+56989048914">+56 9 8904 8914</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:separator {"align":"wide","className":"karu-footer__divider"} -->
<hr class="wp-block-separator alignwide has-alpha-channel-opacity karu-footer__divider"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"align":"center","className":"karu-footer__legal"} -->
<p class="has-text-align-center karu-footer__legal">© <?php echo esc_html( gmdate( 'Y' ) ); ?> Karü Esencial · Limpieza natural para tu hogar</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
