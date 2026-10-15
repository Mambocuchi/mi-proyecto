<?php
/**
 * Plugin Name: Karu Esencial - Precio por volumen del café
 * Description: Las bolsas sueltas de 250 g del café Carlos Roldi toman el precio por bolsa del formato de 1 kg desde 4 unidades y el del formato de 2 kg desde 8 unidades.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const KARU_CAFE_BOLSA_250 = 204; // Variación "250 g".

/**
 * Precio por bolsa según la cantidad de bolsas de 250 g en el carrito.
 * 4 bolsas = precio del formato 1 kg ($31.400); 8 bolsas = precio del formato 2 kg ($59.600).
 */
function karu_cafe_precio_volumen( $bolsas ) {
	$tramos = array(
		8 => 59600 / 8, // $7.450 por bolsa.
		4 => 31400 / 4, // $7.850 por bolsa.
	);
	foreach ( $tramos as $minimo => $precio ) {
		if ( $bolsas >= $minimo ) {
			return $precio;
		}
	}
	return null;
}

function karu_cafe_bolsas_en_carrito( $cart ) {
	$total = 0;
	foreach ( $cart->get_cart() as $item ) {
		if ( (int) $item['variation_id'] === KARU_CAFE_BOLSA_250 ) {
			$total += (int) $item['quantity'];
		}
	}
	return $total;
}

add_action( 'woocommerce_before_calculate_totals', function ( $cart ) {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return;
	}
	$precio = karu_cafe_precio_volumen( karu_cafe_bolsas_en_carrito( $cart ) );
	foreach ( $cart->get_cart() as $item ) {
		if ( (int) $item['variation_id'] !== KARU_CAFE_BOLSA_250 ) {
			continue;
		}
		$normal = (float) wc_get_product( KARU_CAFE_BOLSA_250 )->get_price( 'edit' );
		$item['data']->set_price( $precio !== null ? $precio : $normal );
	}
}, 20 );

// Aviso bajo el nombre del producto en el carrito y en el pago.
add_filter( 'woocommerce_get_item_data', function ( $datos, $item ) {
	if ( (int) ( $item['variation_id'] ?? 0 ) !== KARU_CAFE_BOLSA_250 || ! WC()->cart ) {
		return $datos;
	}
	$bolsas = karu_cafe_bolsas_en_carrito( WC()->cart );
	$precio = karu_cafe_precio_volumen( $bolsas );
	if ( $precio !== null ) {
		$datos[] = array(
			'key'   => 'Precio por volumen',
			'value' => wc_price( $precio ) . ' por bolsa (' . ( $bolsas >= 8 ? '8 o más bolsas' : '4 o más bolsas' ) . ')',
		);
	} else {
		$faltan = 4 - $bolsas;
		$datos[] = array(
			'key'   => 'Ahorra',
			'value' => 'Agrega ' . $faltan . ' ' . ( $faltan === 1 ? 'bolsa' : 'bolsas' ) . ' más y pagas ' . wc_price( 31400 / 4 ) . ' por bolsa',
		);
	}
	return $datos;
}, 10, 2 );
