<?php
function woocommerce_price_by_id_wps( $atts ) {
	global $product;
	$q = array();
	$d = array();
	$quantity = 0;
	$discount = 0;
	$id = $product->id;
	$atts = shortcode_atts( array(
		'id' => $id,
	), $atts, 'bartag' );

	$html = 'Add product id';

	if( intval( $atts['id'] ) > 0 && function_exists( 'wc_get_product' ) ){
		$_product = wc_get_product( $atts['id'] );
		if (isset($_product) && !empty($_product)) {
			$html = "price = " . $_product->get_price_html() . " " . $id;
		} else {
			return  "Wrong product id";
		}
		$html = '<div class="quantityDiscountDiv">';
		$html = $html . '<span>Buy more and save money</span>';
		$html = $html . '<table class="quantityDiscountTable">';
		$html = $html . '<tr>';
		$html = $html . '<th>Minimum Qty</th>';
		$html = $html . '<th>Discount</th> ';
		$html = $html . '</tr>';
		for ( $i = 1; $i <= 5; $i++ ) {
			$quantity = get_post_meta( $id, "_bulkdiscount_quantity_$i", true );
			$discount = get_post_meta( $id, "_bulkdiscount_discount_$i", true );
			if($quantity != "" && $discount != ""){
				$html = $html . '<tr>';
				$html = $html . '<th class="quantityTableRow">' . $quantity . '+</th> ';
				$html = $html . '<th class="discountTableRow">' . $discount . '% off</th> ';
				$html = $html . '</tr>';
			}
		}
		$html = $html . '</table></div>';
	}
	return $html;
}
add_shortcode( 'woocommerce_price', 'woocommerce_price_by_id_wps' );
?>