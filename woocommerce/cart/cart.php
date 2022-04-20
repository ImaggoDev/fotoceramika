<?php
/**
 * Cart Page
 *
 * @version     4.4.0
 */

defined( 'ABSPATH' ) || exit;
echo "<div class='container'>";
wc_print_notices();

do_action( 'woocommerce_before_cart' );

get_template_part( 'woocommerce/cart/cart', porto_cart_version() );

do_action( 'woocommerce_after_cart' );

echo "</div>";