<?php
/**
 * Plugin Name: Karu Esencial - Evento clic_whatsapp
 * Description: Envía el evento "clic_whatsapp" a Google Analytics (Site Kit) cuando un visitante toca un enlace a WhatsApp (wa.me).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'wp_footer',
	function () {
		if ( is_admin() ) {
			return;
		}
		?>
<script id="karu-evento-whatsapp">
document.addEventListener('click', function (e) {
	var a = e.target && e.target.closest ? e.target.closest('a[href*="wa.me/"]') : null;
	if (!a || typeof window.gtag !== 'function') { return; }
	window.gtag('event', 'clic_whatsapp', {
		link_url: a.href,
		link_text: (a.textContent || a.getAttribute('aria-label') || '').trim().slice(0, 100)
	});
}, true);
</script>
		<?php
	},
	100
);
