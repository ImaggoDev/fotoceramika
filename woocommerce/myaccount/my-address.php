<?php
/**
 * My Addresses
 *
 * @version     2.6.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

$porto_woo_version = porto_get_woo_version_number();


if ( version_compare( $porto_woo_version, '2.6', '>=' ) ) {
	$shipping_enabled = wc_shipping_enabled();
} else {
	$shipping_enabled = get_option( 'woocommerce_calc_shipping' ) !== 'no';
}

if ( ! wc_ship_to_billing_address_only() && $shipping_enabled ) {
	$page_title    = apply_filters( 'woocommerce_my_account_my_address_title', __( 'My Addresses', 'porto' ) );
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$page_title    = apply_filters( 'woocommerce_my_account_my_address_title', __( 'My Address', 'porto' ) );
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;
?>

<?php if ( version_compare( $porto_woo_version, '2.6', '<' ) ) : ?>
<div class="featured-box align-left">
	<div class="box-content">
		<h2 class="page-title m-b"><?php echo esc_html( $page_title ); ?></h2>
<?php endif; ?>

<div class="my__address">
<?php
if ( ! wc_ship_to_billing_address_only() && $shipping_enabled ) {
	echo '<div class="u-columns woocommerce-Addresses col2-set addresses">';}
?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
	<?php
		$address = wc_get_account_formatted_address( $name );
		$col     = $col * -1;
		$oldcol  = $oldcol * -1;
	?>

	<div class="u-column<?php echo 0 > $col ? 1 : 2; ?> col-<?php echo 0 > $oldcol ? 1 : 2; ?> woocommerce-Address address">
		<header class="woocommerce-Address-title title">
			<h3 class="account-sub-title"><?php echo esc_html( $address_title ); ?></h3>
		</header>

		<address>
		<?php
        $address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
			'first_name'  => get_user_meta( $customer_id, $name . '_first_name', true ),
			'last_name'   => get_user_meta( $customer_id, $name . '_last_name', true ),
			'company'     => get_user_meta( $customer_id, $name . '_company', true ),
			'address_1'   => get_user_meta( $customer_id, $name . '_address_1', true ),
			'address_2'   => get_user_meta( $customer_id, $name . '_address_2', true ),
			'city'        => get_user_meta( $customer_id, $name . '_city', true ),
			'state'       => get_user_meta( $customer_id, $name . '_state', true ),
			'postcode'    => get_user_meta( $customer_id, $name . '_postcode', true ),
			'country'     => get_user_meta( $customer_id, $name . '_country', true )
		), $customer_id, $name );
	
		$formatted_address = WC()->countries->get_formatted_address( $address );
	
		if ( ! $formatted_address )
			_e( 'You have not set up this type of address yet.', 'woocommerce' );
		else
			$pattern = "/<br\/>/";
			$replacements= '<p>';
			$formatted_address = WC()->countries->get_formatted_address( $address );
			$output = preg_replace($pattern, $replacements, $formatted_address);
			echo "<p>" . $output . "</p>";
    ?>
		</address>
		<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit button wc-action-btn mt-3"><?php echo ! $address ? esc_html__( 'Edytuj dane', 'porto' ) : esc_html__( 'Edytuj dane', 'porto' ); ?><i class="icon icon_btn_arrow"></i></a>
	</div>

<?php endforeach; ?>

<?php
if ( ! wc_ship_to_billing_address_only() && $shipping_enabled ) {
	echo '</div>';}
?>

<?php if ( version_compare( $porto_woo_version, '2.6', '<' ) ) : ?>
	</div>
</div>
</div>
	<?php
endif;
