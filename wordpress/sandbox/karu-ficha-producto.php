<?php
/**
 * Plugin Name: Karu Esencial - Ficha de producto
 * Description: Ajusta la ficha de producto de WooCommerce (Blocksy) a la estética del sitio: formatos como botones, precio "Desde", confianza de compra, consulta por WhatsApp y estilos de la descripción.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Productos con la ficha nueva. Mientras la opción "karu_ficha_todas" no esté activa,
 * solo se aplica a los productos de esta lista (para revisarla antes de extenderla).
 */
const KARU_FICHA_PRODUCTOS = array( 203 );

function karu_ficha_activa() {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
		return false;
	}
	return (bool) get_option( 'karu_ficha_todas' ) || in_array( (int) get_queried_object_id(), KARU_FICHA_PRODUCTOS, true );
}

// Productos de la categoría "Cocina" (y sus subcategorías): detalles en tono crema.
function karu_es_cocina( $producto_id ) {
	$cocina = get_term_by( 'slug', 'cocina', 'product_cat' );
	if ( ! $cocina ) {
		return false;
	}
	foreach ( wc_get_product_term_ids( $producto_id, 'product_cat' ) as $cat ) {
		if ( (int) $cat === (int) $cocina->term_id || term_is_ancestor_of( $cocina->term_id, $cat, 'product_cat' ) ) {
			return true;
		}
	}
	return false;
}

add_filter( 'body_class', function ( $clases ) {
	if ( karu_ficha_activa() ) {
		$clases[] = 'karu-ficha';
		if ( karu_es_cocina( get_queried_object_id() ) ) {
			$clases[] = 'karu-cocina';
		}
	}
	return $clases;
} );

// Sección de la Guía de usos para cada producto de limpieza.
const KARU_GUIA_PRODUCTOS = array(
	163 => array( 'guia-vinagre', 'Ver cómo usar el Vinagre Incoloro' ),
	164 => array( 'guia-percarbonato', 'Ver cómo usar el Percarbonato de Sodio' ),
	165 => array( 'guia-bicarbonato', 'Ver cómo usar el Bicarbonato de Sodio' ),
	166 => array( '', 'Ver cómo usar el vinagre y el bicarbonato' ),
	167 => array( 'guia-vinagre', 'Ver cómo usar el Vinagre Incoloro' ),
);

// Productos con formatos: "Desde $9.500" en vez de un rango de precios.
add_filter( 'woocommerce_variable_price_html', function ( $html, $producto ) {
	$min = $producto->get_variation_price( 'min', true );
	if ( $min === '' || $min === null ) {
		return $html;
	}
	return '<span class="karu-desde">Desde</span> ' . wc_price( $min );
}, 10, 2 );

/* ------------------------------------------------------------------ Bajo el botón de compra */

function karu_ficha_wa_url( $producto ) {
	$msg = 'Hola Karu Esencial, quiero consultar por ' . $producto->get_name() . '.';
	return 'https://wa.me/56989048914?text=' . rawurlencode( $msg );
}

add_action( 'woocommerce_after_add_to_cart_form', function () {
	global $product;
	if ( ! karu_ficha_activa() || ! $product instanceof WC_Product ) {
		return;
	}
	$icono = '<svg viewBox="0 0 32 32" width="18" height="18" aria-hidden="true" focusable="false"><path fill="currentColor" d="M16 3C8.8 3 3 8.7 3 15.8c0 2.5.7 4.9 2 7L3 29l6.4-2c2 1.1 4.3 1.7 6.6 1.7 7.2 0 13-5.7 13-12.8S23.2 3 16 3zm0 23.4c-2.1 0-4.1-.6-5.9-1.7l-.4-.3-3.8 1.2 1.2-3.7-.3-.4c-1.2-1.8-1.9-3.8-1.9-6 0-5.8 4.9-10.6 11-10.6s11 4.8 11 10.6-4.9 10.9-10.9 10.9zm6-7.9c-.3-.2-1.9-.9-2.2-1s-.5-.2-.7.2-.8 1-1 1.2-.4.2-.7.1c-.3-.2-1.4-.5-2.6-1.6-1-.9-1.6-1.9-1.8-2.3-.2-.3 0-.5.1-.7l.5-.6c.2-.2.2-.3.3-.6.1-.2 0-.4 0-.6l-1-2.4c-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4s-1.2 1.1-1.2 2.7 1.2 3.2 1.4 3.4 2.4 3.6 5.8 5c.8.3 1.4.5 1.9.7.8.3 1.5.2 2.1.1.6-.1 1.9-.8 2.2-1.5.3-.7.3-1.4.2-1.5-.1-.2-.3-.3-.6-.4z"/></svg>';
	echo '<a class="karu-ficha-wa" href="' . esc_url( karu_ficha_wa_url( $product ) ) . '" target="_blank" rel="noopener">' . $icono . '<span>Consultar por WhatsApp</span></a>';
	echo '<ul class="karu-confianza">'
		. '<li><strong>Despacho gratis</strong> en el Gran Concepción por compras desde $20.000</li>'
		. '<li><strong>Retiro gratis</strong> en Castellón 1333, Concepción</li>'
		. '<li>Paga con <strong>transferencia</strong> o en <strong>efectivo</strong></li>'
		. '</ul>';
	$id = $product->get_id();
	if ( isset( KARU_GUIA_PRODUCTOS[ $id ] ) ) {
		list( $ancla, $texto ) = KARU_GUIA_PRODUCTOS[ $id ];
		$url = home_url( '/guia-de-usos/' ) . ( $ancla ? '#' . $ancla : '' );
		echo '<a class="karu-ficha-guia" href="' . esc_url( $url ) . '"><span>' . esc_html( $texto ) . '</span> <span aria-hidden="true">→</span></a>';
	}
} );

/* ------------------------------------------------------------------ Formatos como botones */

add_action( 'wp_footer', function () {
	if ( ! karu_ficha_activa() ) {
		return;
	}
	?>
<script id="karu-ficha-formatos">
(function () {
	function crear(select) {
		if (select.dataset.karuPills) { return; }
		select.dataset.karuPills = '1';
		select.classList.add('karu-select-oculto');
		var grupo = document.createElement('div');
		grupo.className = 'karu-formatos';
		grupo.setAttribute('role', 'group');
		var etiqueta = document.querySelector('label[for="' + select.id + '"]');
		if (etiqueta) { grupo.setAttribute('aria-label', etiqueta.textContent.trim()); }
		Array.prototype.forEach.call(select.options, function (op) {
			if (!op.value) { return; }
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'karu-formato';
			b.textContent = op.textContent;
			b.dataset.valor = op.value;
			b.addEventListener('click', function () {
				if (window.jQuery) { window.jQuery(select).val(op.value).trigger('change'); }
				else { select.value = op.value; select.dispatchEvent(new Event('change', { bubbles: true })); }
				marcar();
			});
			grupo.appendChild(b);
		});
		function marcar() {
			grupo.querySelectorAll('.karu-formato').forEach(function (b) {
				var activo = b.dataset.valor === select.value;
				b.classList.toggle('is-activo', activo);
				b.setAttribute('aria-pressed', activo ? 'true' : 'false');
			});
		}
		select.addEventListener('change', marcar);
		if (window.jQuery) { window.jQuery(select).on('change', marcar); }
		select.parentNode.insertBefore(grupo, select);
		marcar();
	}
	function iniciar() {
		document.querySelectorAll('.karu-ficha .variations_form .variations select').forEach(crear);
	}
	if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', iniciar); } else { iniciar(); }
})();
</script>
	<?php
}, 100 );

/* ------------------------------------------------------------------ Estilos */

add_action( 'wp_head', function () {
	if ( ! karu_ficha_activa() ) {
		return;
	}
	?>
<style id="karu-ficha-producto">
.karu-ficha .woocommerce-product-gallery .flexy-view,
.karu-ficha .woocommerce-product-gallery .ct-media-container { border-radius: 24px; overflow: hidden; }
.karu-ficha .woocommerce-product-gallery .flexy-pills img,
.karu-ficha .woocommerce-product-gallery .flexy-pills .ct-media-container { border-radius: 12px; }
.karu-ficha .onsale { border-radius: 999px; background: #B8E0FF; color: #243D5B; font-weight: 800; letter-spacing: .06em; padding: 6px 14px; }
.karu-ficha .summary .product_title { font-family: Nunito, sans-serif; font-weight: 900; color: #243D5B; line-height: 1.15; }
.karu-ficha .summary > .price,
.karu-ficha .summary .woocommerce-variation-price .price { font-family: Nunito, sans-serif; font-weight: 900; color: #243D5B; font-size: 30px; line-height: 1.1; }
.karu-ficha .summary .price del { font-family: Figtree, sans-serif; font-size: 17px; font-weight: 500; color: #5B6C82; opacity: 1; }
.karu-ficha .summary .price ins { text-decoration: none; }
.karu-ficha .summary .karu-desde { font-family: Figtree, sans-serif; font-size: 15px; font-weight: 600; color: #5B6C82; margin-right: 4px; }
.karu-ficha .summary .woocommerce-product-details__short-description { color: #5B6C82; }
.karu-ficha .variations th.label label { font-family: Figtree, sans-serif; font-size: 12px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: #5B6C82; }
.karu-ficha .variations td.value { display: block; }
.karu-ficha .karu-select-oculto { position: absolute !important; width: 1px !important; height: 1px !important; opacity: 0 !important; pointer-events: none !important; }
.karu-ficha .reset_variations { display: none !important; }
.karu-formatos { display: flex; flex-wrap: wrap; gap: 10px; }
.karu-ficha .karu-formatos .karu-formato { display: inline-flex; align-items: center; min-height: 0; height: auto; margin: 0; border: 2px solid #E4ECF4; background: #FFFFFF; color: #243D5B; border-radius: 999px; padding: 10px 18px; font-family: Figtree, sans-serif; font-size: 15px; font-weight: 700; line-height: 1.2; text-transform: none; letter-spacing: 0; box-shadow: none; cursor: pointer; transition: border-color .2s, background-color .2s; }
.karu-ficha .karu-formatos .karu-formato:hover { border-color: #B8E0FF; background: #EDF6FF; color: #243D5B; }
.karu-ficha .karu-formatos .karu-formato.is-activo { border-color: #4A90E2; background: #EDF6FF; color: #243D5B; }
.karu-formato:focus-visible { outline: 3px solid #B8E0FF; outline-offset: 2px; }
.karu-ficha .single_variation:not(:empty) { display: flex !important; flex-direction: column; gap: 10px; margin-bottom: 20px; }
.karu-ficha .single_variation .woocommerce-variation-price { order: 1; }
.karu-ficha .single_variation .woocommerce-variation-description { order: 2; }
.karu-ficha .single_variation .woocommerce-variation-availability { order: 3; }
.karu-ficha .woocommerce-variation-description:empty { display: none; }
.karu-ficha .woocommerce-variation-description { margin: 0; padding: 10px 14px; border-radius: 12px; background: #EDF6FF; color: #243D5B; font-size: 14px; }
.karu-ficha .woocommerce-variation-description > * { margin: 0 !important; }
.karu-ficha .woocommerce-product-gallery .flexy-pills[data-type="thumbs"] ol { gap: 10px; }
.karu-ficha .woocommerce-product-gallery .flexy-pills[data-type="thumbs"] ol li { width: calc((100% - 30px) / 4) !important; flex: 0 0 auto !important; margin: 0 !important; }
.karu-ficha .single_add_to_cart_button { font-weight: 700; box-shadow: 0 6px 18px rgba(74,144,226,.28); }
.karu-ficha-wa { display: inline-flex; align-items: center; gap: 8px; margin-top: 16px; color: #4A90E2; font-weight: 700; text-decoration: none; }
.karu-ficha-wa:hover { color: #3A7DCB; }
.karu-confianza { list-style: none; margin: 18px 0 0; padding: 16px 18px; border-radius: 16px; background: #FAF8F4; color: #5B6C82; font-size: 14px; }
.karu-confianza li { position: relative; padding-left: 26px; margin: 0; }
.karu-confianza li + li { margin-top: 8px; }
.karu-confianza li::before { content: ""; position: absolute; left: 2px; top: .3em; width: 14px; height: 8px; border-left: 2.5px solid #4A90E2; border-bottom: 2.5px solid #4A90E2; transform: rotate(-45deg); }
.karu-confianza strong { color: #243D5B; }
.karu-ficha-guia { display: inline-flex; gap: 6px; margin-top: 14px; color: #4A90E2; font-weight: 700; text-decoration: none; }
.karu-ficha-guia:hover { color: #3A7DCB; }
/* Cocina: detalles en blanco cálido (crema); botones y enlaces siguen en azul Karu */
.karu-cocina dl.karu-datos > div { background: #FAF8F4; border: 1px solid #EFE7DA; }
.karu-cocina .karu-cafeteria { background: #FAF8F4; border-color: #EFE7DA; }
.karu-cocina .karu-ahorro__nota--destacada { background: #F3EADB; }
.karu-cocina .onsale { background: #F3EADB; }
.karu-ficha .product_meta .sku_wrapper { display: none !important; }
.karu-ficha .woocommerce-tabs .tabs li a { font-family: Nunito, sans-serif; font-size: 16px; font-weight: 800; text-transform: none; letter-spacing: 0; }
/* Descripción */
.karu-desc { max-width: 980px; margin: 0 auto; }
.karu-desc h3 { font-family: Nunito, sans-serif; font-weight: 900; font-size: 28px; color: #243D5B; margin-bottom: 10px; }
.karu-desc__lead { font-size: 17px; color: #5B6C82; }
.karu-desc h4 { margin-top: 36px; margin-bottom: 14px; font-family: Figtree, sans-serif; font-size: 13px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: #4A90E2; }
dl.karu-datos { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; margin: 0; }
dl.karu-datos > div { padding: 14px 18px; border-radius: 16px; background: #EDF6FF; }
dl.karu-datos > div:last-child:nth-child(odd) { grid-column: 1 / -1; }
dl.karu-datos dt { font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #5B6C82; }
dl.karu-datos dd { margin: 2px 0 0; font-weight: 600; color: #243D5B; }
.karu-tecnica { margin-top: 16px; border: 1px solid #E4ECF4; border-radius: 16px; background: #FFFFFF; }
.karu-tecnica summary { cursor: pointer; padding: 14px 18px; font-weight: 700; color: #4A90E2; list-style: none; }
.karu-tecnica summary::-webkit-details-marker { display: none; }
.karu-tecnica summary::after { content: "+"; float: right; font-size: 20px; line-height: 1; color: #4A90E2; }
.karu-tecnica[open] summary::after { content: "−"; }
.karu-tecnica__grupos { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px; padding: 4px 18px 18px; }
.karu-tecnica h5 { margin: 0 0 8px; font-family: Nunito, sans-serif; font-weight: 800; font-size: 16px; color: #243D5B; }
.karu-tecnica table { width: 100%; border-collapse: collapse; margin: 0; border: 0; font-size: 14px; }
.karu-tecnica th, .karu-tecnica td { padding: 7px 0; border: 0; border-bottom: 1px solid #E4ECF4; background: none; vertical-align: top; }
.karu-tecnica th { text-align: left; font-weight: 600; color: #243D5B; padding-right: 10px; }
.karu-tecnica td { text-align: right; color: #5B6C82; }
.karu-cocina .karu-tecnica { border-color: #EFE7DA; }
.karu-cocina .karu-tecnica th, .karu-cocina .karu-tecnica td { border-bottom-color: #EFE7DA; }
.karu-ahorro { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; }
.karu-ahorro__item { display: flex; flex-direction: column; gap: 6px; padding: 20px; border: 1px solid #E4ECF4; border-radius: 20px; background: #FFFFFF; box-shadow: 0 4px 16px rgba(36,61,91,.05); }
.karu-ahorro__formato { font-size: 13px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #5B6C82; }
.karu-ahorro__precio { font-family: Nunito, sans-serif; font-weight: 900; font-size: 26px; color: #243D5B; line-height: 1.1; }
.karu-ahorro__precio small { font-family: Figtree, sans-serif; font-size: 13px; font-weight: 600; color: #5B6C82; }
.karu-ahorro__nota { font-size: 14px; color: #5B6C82; }
.karu-ahorro__nota--destacada { align-self: flex-start; padding: 4px 10px; border-radius: 999px; background: #B8E0FF; color: #243D5B; font-size: 12px; font-weight: 700; }
.karu-cafeteria { margin-top: 36px; padding: 24px 28px; border-radius: 24px; background: #EDF6FF; border: 1px solid #B8E0FF; display: flex; align-items: center; justify-content: space-between; gap: 18px; flex-wrap: wrap; }
.karu-cafeteria p { margin: 0; color: #243D5B; }
.karu-cafeteria__boton { display: inline-block; padding: 13px 24px; border-radius: 999px; background: #25D366; color: #FFFFFF !important; font-weight: 700; text-decoration: none; }
.karu-cafeteria__boton:hover { background: #1EBE5B; }
.karu-llamado { margin-top: 36px; padding: 24px 28px; border-radius: 24px; background: #EDF6FF; border: 1px solid #B8E0FF; display: flex; align-items: center; justify-content: space-between; gap: 18px; flex-wrap: wrap; }
.karu-llamado p { margin: 0; color: #243D5B; }
.karu-llamado__boton { display: inline-block; padding: 13px 24px; border-radius: 999px; background: #4A90E2; color: #FFFFFF !important; font-weight: 700; text-decoration: none; box-shadow: 0 6px 18px rgba(74,144,226,.28); }
.karu-llamado__boton:hover { background: #3A7DCB; }
@media (max-width: 767px) {
	.karu-ficha .summary > .price { font-size: 26px; }
	dl.karu-datos, .karu-ahorro, .karu-tecnica__grupos { grid-template-columns: 1fr; }
	.karu-desc h3 { font-size: 24px; }
	.karu-cafeteria { padding: 20px; }
	.karu-llamado { padding: 20px; }
}
</style>
	<?php
} );
