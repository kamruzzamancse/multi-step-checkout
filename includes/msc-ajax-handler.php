<?php
if (!defined('ABSPATH')) exit;

function msc_handle_ajax_checkout() {
    check_ajax_referer('msc_nonce', 'nonce');

    // Sanitize inputs
    $email              = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone              = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $card               = isset($_POST['card']) ? sanitize_text_field($_POST['card']) : '';
    $pickup             = isset($_POST['pickup']) ? json_decode(stripslashes($_POST['pickup']), true) : [];
    $delivery           = isset($_POST['delivery']) ? json_decode(stripslashes($_POST['delivery']), true) : [];
    $collection_address = isset($_POST['collectionAddress']) ? json_decode(stripslashes($_POST['collectionAddress']), true) : [];
    $custom_items       = isset($_POST['customItems']) ? json_decode(stripslashes($_POST['customItems']), true) : [];
    $product_items      = isset($_POST['productItems']) ? json_decode(stripslashes($_POST['productItems']), true) : [];
    $protection_plan    = isset($_POST['protectionPlan']) ? json_decode(stripslashes($_POST['protectionPlan']), true) : [];
    $disposal_selection = isset($_POST['disposalSelection']) ? json_decode(stripslashes($_POST['disposalSelection']), true) : [];
    $special_instructions = isset($_POST['specialInstructions']) ? sanitize_textarea_field($_POST['specialInstructions']) : '';


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

    // Add product items to cart
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

    // Add protection plan to cart
    if (!empty($protection_plan)) {
        $plan_id = $protection_plan['id'] ?? 0;
        $plan_qty = 1;

        if ($plan_id > 0) {
            $plan_product = wc_get_product($plan_id);
            if ($plan_product) {
                WC()->cart->add_to_cart($plan_id, $plan_qty);
            } else {
                wp_send_json_error(['message' => "Protection plan product with ID $plan_id not found."]);
                return;
            }
        }
    }

    // Create new order
    $order = wc_create_order();

    // Save custom items as meta
    if (!empty($custom_items)) {
        $formatted_custom_items = array_map(function ($item) {
            return [
                'name'       => $item['name'] ?? '',
                'price'      => floatval(preg_replace('/[^\d.]/', '', $item['price'] ?? '0')),
                'cubicFeet'  => intval($item['cubicFeet'] ?? 0),
            ];
        }, $custom_items);
    
        $order->update_meta_data('custom_items', json_encode($formatted_custom_items));
    }
    
    

    // Save special instruction directly
    if (!empty($special_instructions)) {
        $order->update_meta_data('special_instructions', $special_instructions);
    }    

    // Save pickup details directly
    if (!empty($pickup)) {
        $order->update_meta_data('pickup', json_encode($pickup));
    }

    // Save delivery details directly
    if (!empty($delivery)) {
        $order->update_meta_data('delivery', json_encode($delivery));
    }

    // Save disposal selection
    if (!empty($disposal_selection)) {
        $order->update_meta_data('disposal_selection', json_encode($disposal_selection));
    }

    // Add products to order
    foreach (WC()->cart->get_cart() as $cart_item) {
        $order->add_product($cart_item['data'], $cart_item['quantity'], ['subtotal' => $cart_item['line_subtotal']]);
    }

    // Set billing address
    if (isset($collection_address['billing'])) {
        $billing_address = $collection_address['billing'];
        $order->set_address([
            'first_name' => $billing_address['first_name'] ?? '',
            'last_name'  => $billing_address['last_name'] ?? '',
            'email'      => $email,
            'phone'      => $phone,
            'address_1'  => $billing_address['address_line1'] ?? '',
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
            'first_name' => $shipping_address['first_name'] ?? '',
            'last_name'  => $shipping_address['last_name'] ?? '',
            'address_1'  => $shipping_address['address_line1'] ?? '',
            'address_2'  => $shipping_address['address_line2'] ?? '',
            'city'       => $shipping_address['town'] ?? '',
            'postcode'   => $shipping_address['postcode'] ?? '',
            'country'    => 'US',
            'state'      => 'CA'
        ], 'shipping');
    }

    // Finalize and save order after setting all metadata
    $order->calculate_totals();
    $order->update_status('processing');
    $order->save(); // Save after all updates

    // Empty cart
    WC()->cart->empty_cart();



    // Build email content
$admin_email = get_option('admin_email');
$subject = 'NEW BOOKING - STORE YOUR DORM';

$billing = $order->get_address('billing');

$supply_date = isset($delivery['date']) ? date('F jS, Y', strtotime($delivery['date'])) . (!empty($delivery['time']) ? " ({$delivery['time']})" : '') : 'N/A';
$pickup_date = isset($pickup['date']) ? date('F jS, Y', strtotime($pickup['date'])) . (!empty($pickup['time']) ? " ({$pickup['time']})" : '') : 'N/A';

// Build items summary
$item_summary = [];
if (!empty($product_items)) {
    foreach ($product_items as $item) {
        $item_summary[] = $item['quantity'] . ' ' . strtolower($item['title']);
    }
}
if (!empty($custom_items)) {
    foreach ($custom_items as $custom) {
        $item_summary[] = '1 ' . strtolower($custom['name']);
    }
}
$items_string = implode(', ', $item_summary);

// Protection Plan
$protection_text = !empty($protection_plan) ? "{$protection_plan['title']} (${$protection_plan['price']}/month)" : 'None';

// Email body
$message = <<<EOD
Name: {$billing['first_name']} {$billing['last_name']}

Address: {$billing['address_1']}, {$billing['city']}

Email: {$billing['email']}
Phone Number: {$billing['phone']}

Supply Appointment: {$supply_date}
Pick-Up Appointment: {$pickup_date}

Items to Store: {$items_string}
Additional Services: {$protection_text}
EOD;

// Send the email
wp_mail($admin_email, $subject, $message);



    // Return success
    wp_send_json_success([
        'message' => 'Order placed successfully!',
        'redirect_url' => wc_get_endpoint_url('order-received', $order->get_id(), wc_get_checkout_url())
    ]);
}

add_action('wp_ajax_msc_place_order', 'msc_handle_ajax_checkout');
add_action('wp_ajax_nopriv_msc_place_order', 'msc_handle_ajax_checkout');
