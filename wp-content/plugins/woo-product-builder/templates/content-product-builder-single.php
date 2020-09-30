<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

do_action( 'woocommerce_product_builder_single_top', $products, $max_page );
?>

<?php do_action( 'woocommerce_product_builder_single_bottom', $products, $max_page ); ?>
