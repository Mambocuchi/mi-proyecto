<?php
/**
 * Plugin Name: Karu Esencial - Precio por volumen del café
 * Description: Todo el café Carlos Roldi se cuenta en bolsas de 250 g (250 g = 1, 1 kg = 4, 2 kg = 8). Según el total de bolsas del carrito se cobra $9.500, $7.850 (desde 4) o $7.450 (desde 8) por bolsa.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Variaciones del café y cuántas bolsas de 250 g trae cada una.
const KARU_CAFE_BOLSAS = array(
	204 => 1, // 250 g
	205 => 4, // 1 kg (4 bolsas)
	206 => 8, // 2 kg (8 bolsas)
);

/**
 * Precio por bolsa según el total de bolsas: 4 bolsas = precio del formato 1 kg ($31.400)
 * y 8 bolsas = precio del formato 2 kg ($59.600).
 */
function karu_cafe_precio_volumen( $bolsas ) {
	if ( $bolsas >= 8 ) {
		return 59600 / 8; // $7.450
	}
	if ( $bolsas >= 4 ) {
		return 31400 / 4; // $7.850
	}
	return (float) wc_get_product( 204 )->get_price( 'edit' ); // $9.500
}

function karu_cafe_bolsas_en_carrito( $cart ) {
	$total = 0;
	foreach ( $cart->get_cart() as $item ) {
		$vid = (int) ( $item['variation_id'] ?? 0 );
		if ( isset( KARU_CAFE_BOLSAS[ $vid ] ) ) {
			$total += KARU_CAFE_BOLSAS[ $vid ] * (int) $item['quantity'];
		}
	}
	return $total;
}

add_action( 'woocommerce_before_calculate_totals', function ( $cart ) {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return;
	}
	$bolsas = karu_cafe_bolsas_en_carrito( $cart );
	if ( ! $bolsas ) {
		return;
	}
	$precio = karu_cafe_precio_volumen( $bolsas );
	foreach ( $cart->get_cart() as $item ) {
		$vid = (int) ( $item['variation_id'] ?? 0 );
		if ( isset( KARU_CAFE_BOLSAS[ $vid ] ) ) {
			$item['data']->set_price( KARU_CAFE_BOLSAS[ $vid ] * $precio );
		}
	}
}, 20 );

// Aviso bajo el café en el carrito y en el pago.
add_filter( 'woocommerce_get_item_data', function ( $datos, $item ) {
	$vid = (int) ( $item['variation_id'] ?? 0 );
	if ( ! isset( KARU_CAFE_BOLSAS[ $vid ] ) || ! WC()->cart ) {
		return $datos;
	}
	$bolsas = karu_cafe_bolsas_en_carrito( WC()->cart );
	if ( $bolsas >= 4 ) {
		$datos[] = array(
			'key'   => 'Precio por volumen',
			'value' => wc_price( karu_cafe_precio_volumen( $bolsas ) ) . ' por bolsa de 250 g (' . $bolsas . ' bolsas en tu carrito)',
		);
	} else {
		$faltan  = 4 - $bolsas;
		$datos[] = array(
			'key'   => 'Ahorra',
			'value' => 'Agrega ' . $faltan . ' ' . ( $faltan === 1 ? 'bolsa' : 'bolsas' ) . ' más y pagas ' . wc_price( 31400 / 4 ) . ' por bolsa',
		);
	}
	return $datos;
}, 10, 2 );
