<?php
// Register shortcode
function custom_checkout_shortcode() {
    ob_start();
    ?>
    <button id="custom-checkout-button">Place Test Order</button>
    <div id="checkout-result"></div>

    <script>
    document.getElementById('custom-checkout-button').addEventListener('click', function() {

        // Retrieve stored address from sessionStorage
        let storedAddress = sessionStorage.getItem("collection_address_db");
        let billingDetails = {};
        let shippingDetails = {};

        if (storedAddress) {
            storedAddress = JSON.parse(storedAddress);

            // Map session data to billing & shipping format
            billingDetails = {
                first_name: storedAddress.first_name || "Anisur",
                last_name: storedAddress.last_name || "Rahman",
                email: storedAddress.email || "kamruzzamancv@gmail.com", // Ensure email is stored or fetch dynamically
                phone: storedAddress.phone || "01716589980", // Ensure phone is stored or fetch dynamically
                address_1: storedAddress.address_line1 || "address_1",
                address_2: storedAddress.address_line2 || "address_2",
                city: storedAddress.town || "city",
                state: storedAddress.state || "state", // Ensure state is stored
                postcode: storedAddress.postcode || "1234",
                country: storedAddress.country || "US" // Default to US or fetch dynamically
            };

            // Shipping details (assuming shipping = billing)
            shippingDetails = { ...billingDetails };
        }

        // Define products dynamically (replace with actual product selection logic)
        let selectedProducts = [
            { product_id: 105, quantity: 2 },
            { product_id: 106, quantity: 3 }
        ];

        // Create order data
        let orderData = {
            billing: billingDetails,
            shipping: shippingDetails,
            products: selectedProducts,
            payment_method: "cod" // Default to Cash on Delivery
        };

        fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=custom_checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.text())
        .then(data => document.getElementById('checkout-result').innerHTML = data)
        .catch(error => console.error('Error:', error));
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_checkout_button', 'custom_checkout_shortcode');

// Checkout function (Only for registered users)
function process_custom_checkout() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'You must be logged in to place an order!']);
        wp_die();
    }

    if (!class_exists('WooCommerce')) {
        wp_send_json_error(['message' => 'WooCommerce is not active!']);
        wp_die();
    }

    global $woocommerce;
    $user_id = get_current_user_id(); // Get current user ID

    // Fetch JSON input data from the AJAX request
    $input_data = json_decode(file_get_contents("php://input"), true);
    
    if (!$input_data) {
        wp_send_json_error(['message' => 'Invalid order data!']);
        wp_die();
    }

    // Create a new order
    $order = wc_create_order(['customer_id' => $user_id]);

    // Set billing and shipping address dynamically
    if (!empty($input_data['billing'])) {
        $order->set_address($input_data['billing'], 'billing');
    }
    if (!empty($input_data['shipping'])) {
        $order->set_address($input_data['shipping'], 'shipping');
    }

    // Add products dynamically
    if (!empty($input_data['products'])) {
        foreach ($input_data['products'] as $product) {
            $product_id = intval($product['product_id']);
            $quantity = intval($product['quantity']);
            if ($product_id > 0 && $quantity > 0) {
                $order->add_product(wc_get_product($product_id), $quantity);
            }
        }
    }

    // Set payment method
    $payment_method = !empty($input_data['payment_method']) ? $input_data['payment_method'] : 'cod';
    $order->set_payment_method($payment_method);
    $order->set_payment_method_title(ucwords(str_replace('_', ' ', $payment_method)));

    // Add order note
    $order->add_order_note('Dynamic checkout order for registered user.');

    // Calculate totals and update status
    $order->calculate_totals();
    $order->update_status('processing');

    wp_send_json_success(['message' => 'Checkout successful! Order ID: ' . $order->get_id()]);
    wp_die();
}
add_action('wp_ajax_custom_checkout', 'process_custom_checkout'); // Only for registered users
