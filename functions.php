<?php

add_action('wp_enqueue_scripts', 'porto_child_css', 1001);

// Load CSS
function porto_child_css()
{
    // porto child theme styles
    wp_deregister_style('styles-child');
    wp_register_style('styles-child', esc_url(get_stylesheet_directory_uri()) . '/style.css');
    wp_register_style('styles-child-custom', esc_url(get_stylesheet_directory_uri()) . '/assets/styles/custom.min.css');
    wp_enqueue_style('styles-child');
    wp_enqueue_style('styles-child-custom');

    wp_register_script('scripts-child', esc_url(get_stylesheet_directory_uri()) . '/assets/scripts/custom.js', null, null, true);
    wp_enqueue_script('scripts-child');

    if (is_rtl()) {
        wp_deregister_style('styles-child-rtl');
        wp_register_style('styles-child-rtl', esc_url(get_stylesheet_directory_uri()) . '/style_rtl.css');
        wp_enqueue_style('styles-child-rtl');
    }
}

// Load JS
function register_scripts()
{
    //  wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/assets/scripts/custom.js', array(), '1', true );
}

add_action('wp_enqueue_scripts', 'register_scripts');
// Woo
add_filter('wc_product_sku_enabled', '__return_false');


/**
 *
 * Show only lowest prices in WooCommerce variable products
 *
 */

add_filter('woocommerce_variable_sale_price_html', function ($price, $product) {
    // Sale Price
    $prices = array($product->get_variation_regular_price('min', true), $product->get_variation_regular_price('max', true));
    sort($prices);
    $saleprice = $prices[0] !== $prices[1] ? sprintf(__('od %1$s', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);

    if ($price !== $saleprice) {
        $price = '<del>' . $saleprice . $product->get_price_suffix() . '</del> <ins>' . $price . $product->get_price_suffix() . '</ins>';
    }
    return $price;
}, 10, 2);

add_filter('woocommerce_variable_price_html', function ($price, $product) {
    // Main Price
    if (!is_product()) {
        $prices = array($product->get_variation_price('min', true), $product->get_variation_price('max', true));
        $price = $prices[0] !== $prices[1] ? sprintf(__('od %1$s', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);
    }
    return $price;
}, 10, 2);

/**
 *
 * Woocommerce ordering select change default name
 *
 */

add_filter('woocommerce_catalog_orderby', 'rename_default_sorting_options');

function rename_default_sorting_options($options)
{

    $options['menu_order'] = 'Podstawowe sortowanie';

    return $options;

}

/**
 *
 * Woocommerce product tab change name
 *
 */
add_filter('woocommerce_product_tabs', 'rename_additional_info_tab');

function rename_additional_info_tab($tabs)
{

    $tabs['additional_information']['title'] = 'Dodatkowe informacje';
    $tabs['description']['title'] = 'Opis produktu';
    return $tabs;

}

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 8);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5);

add_action('woocommerce_single_product_summary', 'custom_product_desc', 20);

function custom_product_desc()
{
    global $post;
    $fpd = get_post_meta($post->ID, 'fpd_product_settings');

    if (empty($fpd)) {
        return false;
    }

    ob_start();
    get_template_part('template-parts/content', 'fpd-product', array('id' => $post->ID));
    $html = ob_get_contents();
    ob_end_clean();

    echo $html;
}

add_action('wp', 'check_product_type');

function check_product_type() {
    global $post;
    $fpd = get_post_meta($post->ID, 'fpd_product_settings');

    if (empty($fpd)) {
        return false;
    }

    // remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
    // remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);

    remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
}


add_action('custom_product_designer_variations', 'custom_product_designer_variations');

function custom_product_designer_variations() {
    global $post;
    ob_start();
    get_template_part('template-parts/content', 'fpd-product-checkout-form', array('id' => $post->ID));
    $html = ob_get_contents();
    ob_end_clean();
    echo $html;
}


add_action('woocommerce_after_single_product_summary', function () {
    echo '<div class="custom-product-designer" style="width: 100%; margin-bottom: 1rem;">';
    do_action('fpd_product_designer');
    do_action('custom_product_designer_variations');
    add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 50 );
        echo '<div class="custom-product-designer-form">';
            do_action( 'woocommerce_variable_add_to_cart');
        echo '</div>';
    echo '</div>';
});


add_action('init', function(){

    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page(array(
            'page_title' 	=> 'Opcje motywu',
            'menu_title'	=> 'Opcje motywu',
            'menu_slug' 	=> 'theme-general-settings',
            'capability'	=> 'edit_posts',
            'redirect'		=> false
        ));
    }

});



add_action('woocommerce_after_add_to_cart_button', 'add_baner_to_product');

function add_baner_to_product() {

    if(!function_exists('acf_add_options_page') ) {
        return false;
    }

    global $post;
    $id = $post->ID;
    $terms = get_the_terms($id, 'product_cat');

    // baners
    $baners = get_field('promo-banner', 'option');
    foreach($terms ?? [] as $term) {
        $term_id = $term->term_id;
        foreach($baners ?? [] as $baner) {
            if(isset($baner['product-category'][0]) && $term_id === $baner['product-category'][0]) {
                echo "<div class='promo-baner'>" . $baner['text'] . "</div>";
            }
        }
    }
}

// ACF SYnc


add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
    // return
    return $path;
}

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';

    // return
    return $paths;
}



/**
 * 
 * Woocommerce my account nav
 * 
 */

add_filter ( 'woocommerce_account_menu_items', 'custom_myaccount_nav' );

function custom_myaccount_nav( $menu_links ){
	
    unset( $menu_links['edit-address'] ); 
	unset( $menu_links['dashboard'] ); 
	unset( $menu_links['orders'] ); 
	unset( $menu_links['downloads'] ); 
	unset( $menu_links['edit-account'] ); 
	unset( $menu_links['customer-logout'] ); 

    $menu_links['dashboard'] = 'Kokpit';
	$menu_links['edit-account'] = 'Dane osobowe';
    $menu_links['orders'] = 'Zamówienia';
    $menu_links['edit-address'] = 'Adresy';
    $menu_links['customer-logout'] = 'Wyloguj się';

	return $menu_links;
}

/**
 * 
 * Woocommerce delete field display name user 
 * 
 */

add_filter('woocommerce_save_account_details_required_fields', 'account_details_required_fields' );
function account_details_required_fields( $required_fields ){
    unset( $required_fields['account_display_name'] );
    return $required_fields;
}

/**
 * 
 * Woocommerce orders column change name 
 * 
 */

function filter_woocommerce_account_orders_columns( $columns ) {    
    $columns['order-actions'] = __( 'Akcje', 'woocommerce' );
    return $columns;
}
add_filter( 'woocommerce_account_orders_columns', 'filter_woocommerce_account_orders_columns', 10, 1 );


/**
 * paczkomat usuniecie opcji za pobraniem 
 */
add_filter( 'woocommerce_available_payment_gateways', 'gateway_disable_paczkomat_cod' );
  
function gateway_disable_paczkomat_cod( $available_gateways ) {   
   if ( ! is_admin() ) {
        
      $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
      $chosen_shipping = $chosen_methods[0];
        
      if ( isset( $available_gateways['bacs'] ) && 0 === strpos( $chosen_shipping, 'flexible_shipping_single:1' ) ) {
        unset( $available_gateways['cod'] );
      }
   }
   return $available_gateways;   
}

/**
 * inpost kurier usuniecie opcji za pobraniem 
 */
add_filter( 'woocommerce_available_payment_gateways', 'gateway_disable_inpost_cod' );
  
function gateway_disable_inpost_cod( $available_gateways ) {   
   if ( ! is_admin() ) {
        
      $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
      $chosen_shipping = $chosen_methods[0];
        
      if ( isset( $available_gateways['bacs'] ) && 0 === strpos( $chosen_shipping, 'flexible_shipping_single:3' ) ) {
        unset( $available_gateways['cod'] );
      }
   }
   return $available_gateways;   
}

/**
 * inpost kurier pobranie  usuniecie opcji platnosci online
 */
add_filter( 'woocommerce_available_payment_gateways', 'gateway_disable_inpost_online_payment' );
  
function gateway_disable_inpost_online_payment( $available_gateways ) {   
   if ( ! is_admin() ) {
        
      $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
      $chosen_shipping = $chosen_methods[0];
        
      if ( isset( $available_gateways['bacs'] ) && 0 === strpos( $chosen_shipping, 'flexible_shipping_single:2' ) ) {
        unset( $available_gateways['bacs'] );
        unset( $available_gateways['pay_by_paynow_pl_google_pay'] );
        unset( $available_gateways['pay_by_paynow_pl_pbl'] );
        unset( $available_gateways['pay_by_paynow_pl_blik'] );
      }
   }
   return $available_gateways;   
}

add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Dodaj do koszyka', 'woocommerce' );
}