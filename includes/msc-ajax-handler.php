<?php
if (!defined('ABSPATH')) exit;

function msc_handle_ajax_checkout() {
    check_ajax_referer('msc_nonce', 'nonce');

    // Sanitize inputs
    $email            = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone            = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $card             = isset($_POST['card']) ? sanitize_text_field($_POST['card']) : '';
    $custom_items     = isset($_POST['customItems']) ? json_decode(stripslashes($_POST['customItems']), true) : [];
    $pickup           = isset($_POST['pickup']) ? floatval($_POST['pickup']) : 0;
    $delivery         = isset($_POST['delivery']) ? floatval($_POST['delivery']) : 0;
    $collection_address = isset($_POST['collectionAddress']) ? json_decode(stripslashes($_POST['collectionAddress']), true) : [];
    $product_items    = isset($_POST['productItems']) ? json_decode(stripslashes($_POST['productItems']), true) : [];

    // Validate essential fields
    if (empty($email) || empty($phone) || empty($card) || empty($collection_address)) {
        wp_send_json_error(['message' => 'Email, card number, and address are required.']);
    }

    // Make sure WooCommerce is ready
    if (!function_exists('WC') || !WC()->cart) {
        wp_send_json_error(['message' => 'WooCommerce cart not available.']);
    }

    // Empty the cart first
    WC()->cart->empty_cart();

    // Add custom items to cart (if any)
    if (!empty($custom_items)) {
        foreach ($custom_items as $item) {
            WC()->cart->add_to_cart(66, 1, 0, [], [
                'custom_name'  => $item['name'] ?? '',
                'custom_price' => $item['price'] ?? 0,
            ]);
        }
    }

    // Add product items to cart (from the `product_items` array)
    if (!empty($product_items)) {
        foreach ($product_items as $product) {
            $product_id = $product['id'] ?? 0;
            $quantity   = $product['quantity'] ?? 1;

            if ($product_id > 0) {
                $added_product = wc_get_product($product_id);

                if ($added_product) {
                    WC()->cart->add_to_cart($product_id, $quantity);
                } else {
                    wp_send_json_error(['message' => "Product with ID $product_id not found."]);
                    return;
                }
            }
        }
    }

    // Add pickup & delivery fees
    if ($pickup > 0) {
        WC()->cart->add_fee('Pickup Charge', $pickup);
    }

    if ($delivery > 0) {
        WC()->cart->add_fee('Supply Charge', $delivery);
    }

    // Create new order
    $order = wc_create_order();

    // Add products to order
    foreach (WC()->cart->get_cart() as $cart_item) {
        $order->add_product($cart_item['data'], $cart_item['quantity'], ['subtotal' => $cart_item['line_subtotal']]);
    }

    // Set billing address
    if (isset($collection_address['billing'])) {
        $billing_address = $collection_address['billing'];

        $order->set_address([
            'first_name' => $billing_address['first_name'],
            'last_name'  => $billing_address['last_name'],
            'email'      => $email,
            'phone'      => $phone,
            'address_1'  => $billing_address['address_line1'],
            'address_2'  => $billing_address['address_line2'] ?? '',
            'city'       => $billing_address['town'] ?? '',
            'postcode'   => $billing_address['postcode'] ?? '',
            'country'    => 'US',
            'state'      => 'CA'
        ], 'billing');
    } else {
        wp_send_json_error(['message' => 'Missing billing address information.']);
    }

    // Set shipping address
    if (isset($collection_address['shipping'])) {
        $shipping_address = $collection_address['shipping'];
        $order->set_address([
            'first_name' => $shipping_address['first_name'],
            'last_name'  => $shipping_address['last_name'],
            'address_1'  => $shipping_address['address_line1'],
            'address_2'  => $shipping_address['address_line2'] ?? '',
            'city'       => $shipping_address['town'] ?? '',
            'postcode'   => $shipping_address['postcode'] ?? '',
            'country'    => 'US',
            'state'      => 'CA'
        ], 'shipping');
    }

    // ✅ Save order now to persist address
    $order->save();

    // Calculate totals & update status
    $order->calculate_totals();
    $order->update_status('processing');

    // Clear cart again
    WC()->cart->empty_cart();

    // Success response
    wp_send_json_success([
        'message' => 'Order placed successfully!',
        'redirect_url' => wc_get_endpoint_url('order-received', $order->get_id(), wc_get_checkout_url())
    ]);
}

add_action('wp_ajax_msc_place_order', 'msc_handle_ajax_checkout');
add_action('wp_ajax_nopriv_msc_place_order', 'msc_handle_ajax_checkout');
