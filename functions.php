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

add_action('woocommerce_after_single_product_summary', function () {
    echo '<div class="custom-product-designer" style="width: 100%; margin-bottom: 1rem;">';
    do_action('fpd_product_designer');
    echo '</div>';
});

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

// ACF SYnc
add_filter('acf/json_directory', function ($path) {
    return get_template_directory() . '/acf-json';
});

add_filter('acf/settings/save_json', function ($path) {
    return apply_filters("acf/json_directory", NULL);

});

add_filter('acf/settings/load_json', function ($paths) {
    return [
        apply_filters("acf/json_directory", NULL)
    ];
});

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 8);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5);

add_action('woocommerce_before_add_to_cart_form', 'custom_product_desc');

function custom_product_desc()
{
    global $post;
    $fpd = get_post_meta($post->ID, 'fpd_product_settings');

    if (empty($fpd)) {
        return false;
    }
    ob_start();
    get_template_part('template-parts/content', 'fpd-product');
    $html = ob_get_contents();
    ob_end_clean();

    echo $html;
}
