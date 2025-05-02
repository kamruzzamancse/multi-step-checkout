<?php
/**
 * Plugin Name: Multi-Step Checkout for WooCommerce
 * Plugin URI:  https://sparktech.agency/
 * Description: A custom WooCommerce multi-step checkout system with dynamic pricing and collection features.
 * Version:     1.2
 * Author:      Md. Kamruzzaman
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Check if WooCommerce is active
function msc_check_woocommerce() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( esc_html__( 'This plugin requires WooCommerce to be installed!', 'msc' ) );
    }
}
register_activation_hook( __FILE__, 'msc_check_woocommerce' );

// Load CSS & JS
function msc_enqueue_scripts() {
    // Preconnect to Google Fonts and Fonts Static
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
     // Enqueue Google Font Montserrat
    //  wp_enqueue_style('google-font-montserrat', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap', array(), null);
     wp_enqueue_style('google-font-montserrat', 'https://fonts.googleapis.com/css2?family=Cardo:ital,wght@0,400;0,700;1,400&family=Cormorant:ital,wght@0,300..700;1,300..700&family=Josefin+Slab:ital,wght@0,100..700;1,100..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap', array(), null);
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');

    // Enqueue plugin styles
    wp_enqueue_style('msc-style', plugin_dir_url(__FILE__) . 'assets/style.css');

    // Enqueue jQuery (included in WordPress) and Bootstrap JS
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);

    // Google Maps Places API
    wp_enqueue_script(
        'google-maps-places-api',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyC04K-m61wAas4_hdriMdiIeSR5PP3ux3c&libraries=places&callback=initMap',
        [],
        null,
        true
    );

    // Flatpickr (modern vanilla JS date picker)
    wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
    wp_enqueue_script('flatpickr-js', 'https://cdn.jsdelivr.net/npm/flatpickr', [], null, true);

    // Enqueue custom script
    wp_enqueue_script('msc-script', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery', 'jquery-ui-datepicker'), null, true);

    wp_enqueue_script('msc-checkout', plugin_dir_url(__FILE__) . 'assets/checkout.js', [], null, true);

    wp_localize_script('msc-checkout', 'msc_ajax_obj', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('msc_nonce'),
        'is_user_logged_in' => is_user_logged_in() ? '1' : '0',
    ]);       
}
add_action('wp_enqueue_scripts', 'msc_enqueue_scripts');


// ========================== Custom Shortcode for Navigation ==========================
/* function custom_navigation_shortcode() {
    ob_start();
    ?>
    <!-- Include Navigation HTML -->
    <?php include( plugin_dir_path(__FILE__) . 'includes/nav-bar.php'); ?>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_navigation', 'custom_navigation_shortcode'); */


// Load Multi-Step Checkout Form
function msc_custom_checkout_form() {
    ?>
    <div id="multi-step-checkout">
        <div id="nav-bar-wrapper">
            <?php include( plugin_dir_path(__FILE__) . 'includes/nav-bar.php'); ?>
        </div>
        
        <div id="mainWarpper" class="pro_row">
            <!-- Left Content (Checkout Steps) -->
            <div class="pro_col pro_col_70">
                <?php include( plugin_dir_path(__FILE__) . 'includes/step-1-pricing-plan.php'); ?>
                <?php include( plugin_dir_path(__FILE__) . 'includes/step-2-collection-address.php'); ?>
                <?php include( plugin_dir_path(__FILE__) . 'includes/step-3-collection-timeslot.php'); ?>
                <?php include( plugin_dir_path(__FILE__) . 'includes/step-4-delivery-timeslot.php'); ?>
                <?php include( plugin_dir_path(__FILE__) . 'includes/step-5-protection-plan.php'); ?>
                <?php include( plugin_dir_path(__FILE__) . 'includes/step-6-checkout.php'); ?>
            </div>
            <!-- Price Summary (Right Sidebar) -->
            <div id="price-summary-wrapper" class="pro_col pro_col_30 ">
                <?php include( plugin_dir_path(__FILE__) . 'includes/price-summary.php'); ?>
            </div>
        </div>

        <div id="pro_checkout">
            <?php include( plugin_dir_path(__FILE__) . 'includes/step-6-checkout.php'); ?>
        </div>
        <!-- Footer Section -->
        <div id="checkout-footer" class="pro_footer">
            <?php include( plugin_dir_path(__FILE__) . 'includes/footer.php'); ?>
        </div>
    </div>
    <?php
}

add_shortcode( 'multi_step_checkout', 'msc_custom_checkout_form' );

// Load Ajax Checkout Handler
include_once plugin_dir_path(__FILE__) . 'includes/msc-ajax-handler.php';

?>