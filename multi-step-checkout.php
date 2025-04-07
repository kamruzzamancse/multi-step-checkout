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

    // Enqueue custom script
    wp_enqueue_script('msc-script', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery', 'jquery-ui-datepicker'), null, true);
}
add_action('wp_enqueue_scripts', 'msc_enqueue_scripts');


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
?>

<style>
    /* #multi-step-checkout *{
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    } */
    #multi-step-checkout {
    width: 100%;
    max-width: 1440px;
    padding: 0 10px;
    margin: 0 auto;
    margin-top: -90px;
    font-family: var(--JosefinSlab) !important;
    font-weight: 500!important;
    }
    #multi-step-checkout p{
        font-size:18px;
        font-weight: 500;
    }
    #nav-bar-wrapper{
        width: 100%;
        height: fit-content;
        position: sticky;
        background-color: #fff;
        top: 20px;
        left: 0;
        z-index: 999;
    }
    #mainWarpper{
        width: 100% !important;
        display: flex !important;
        flex-wrap: nowrap !important;
        gap: 70px;
    }
    .pro_col_70{
        width:70% !important;
        padding: 0 !important;
    }
    .pro_col_30{
        width:30% !important;
    }
    
    #price-summary-wrapper.pro_col_30{
        position: sticky;
        top: 170px;
        padding: 0 ;
    }
    @media (max-width: 576px) {
        #mainWarpper{
        width: 100% !important;
        display: flex !important;
        flex-wrap: wrap !important;
        }
        .pro_col_70{
        width:100% !important;
        }
        .pro_col_30{
            display: none !important;
        }
    }
    @media (min-width: 576px) and (max-width: 992px) {
        #mainWarpper{
        width: 100% !important;
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 20px;
        }
        .pro_col_70{
        width:100% !important;
        }
        .pro_col_30{
            display: none !important;
        }
    } 

</style>