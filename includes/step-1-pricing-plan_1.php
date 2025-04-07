<!-- Step 1: Pricing Plan -->

<div class="step" id="step-1">

    <div class="pro_col">
        <section class="buildPlan">
            <h2 class="buildPlan_title">Build Your Storage Plan</h2>
            <p>Book now, pay later. You will not be charged until your Pickup appointment.</p>
            <div class="note">
                <p><b> 💵 LIMITED-TIME PROMO: </b>: Get 2 Months of FREE Storage for a Storagehotel Large Box!</p>
            </div>
        </section>
    </div>

    <div class="pro_col mt-4">
        <h3><b>Boxes</b></h3>
        <p>
            We provide <b>FREE</b> storage boxes with tape, delivered to you at your Supply Appointment.
        </p>
        <div >
                <div>
                    <p class="pragraph mt-3">
                        <img src="https://app.storagehotel.ca/assets/item-icons/notes-icon.svg" alt="png" width="20" height="20">
                        <b>You won't be charged for boxes you don't use. Simply return any unused boxes during Pickup</b>. We recommend you order more boxes than you think you need. The typical student uses at least 7 Storagehotel Large Boxes.
                        
                        <span class="tooltipContainer">
                            <img class="tooltipIcon" src="https://app.storagehotel.ca/assets/item-icons/help-icon.svg" alt="png" width="20" height="20">
                            <span class="tooltipBox">18” x 18” x 16” each. 50 lb weight limit each. Boxes are free, provided they are stored in your storage plan.</span>
                        </span>
                    </p>
                </div>   
        </div>
    </div>
    <!-- Dynamic Product Selection -->
    <div class="pro_row">
        <div id="product_list">
            <?php
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => -1, 
                'post_status'    => 'publish'
            );
    
            $products = new WP_Query($args);
            $categorized_products = array(
                'box'       => array(),
                'common'    => array(),
                'mattresses'=> array()
            );
    
            if ($products->have_posts()) :
                while ($products->have_posts()) : $products->the_post();
                    $product = wc_get_product(get_the_ID());
    
                    // Get product categories
                    $categories = wp_get_post_terms(get_the_ID(), 'product_cat', array('fields' => 'slugs'));
    
                    // Skip "Packing Material" category
                    if (in_array('packing-material', $categories)) {
                        continue;
                    }
    
                    // Categorize products
                    if (in_array('box', $categories)) {
                        $categorized_products['box'][] = $product;
                    } elseif (in_array('common', $categories)) {
                        $categorized_products['common'][] = $product;
                    } elseif (in_array('mattresses', $categories)) {
                        $categorized_products['mattresses'][] = $product;
                    }
                endwhile;
                wp_reset_postdata();
            endif;

            // Display products in order: Box (1 column), Common (2 columns), Mattresses (2 columns)
            foreach (['box', 'common', 'mattresses'] as $category) {
                if (!empty($categorized_products[$category])) {
                    echo '<h4 class="pro_heading2">' . ucfirst($category) . '</h4>';
                    echo '<div class="pro_text p-0"><p><b>Note:</b> The prices shown are estimates and may vary based on the actual size and weight of your items.</p></div>';
    
                    // Set grid layout based on category
                    $grid_class = ($category == 'common' || $category == 'mattresses') ? 'product-grid-two' : 'product-grid-one';
                    echo '<div class="'.$grid_class.'">';
    
                    foreach ($categorized_products[$category] as $product) {
                        ?>
                        <div class="storage-item">
                            <div class="product-container">
                                <!-- Product Image -->
                                <div class="product-image">
                                    <?php echo $product->get_image(); ?>
                                </div>
                                <!-- Product Info -->
                                <div class="product-info">
                                    <strong><?php echo esc_html($product->get_name()); ?></strong>
                                    <p><?php echo $product->get_short_description(); ?></p>
                                    <p class="price">€<?php echo esc_html($product->get_price()); ?> /month</p>
                                </div>
                                <!-- Quantity Selector -->
                                <div class="product-quantity">
                                    <button class="qty-btn minus" onclick="updateQuantity(this, -1)">-</button>
                                    <input type="number" id="product_<?php echo esc_attr($product->get_id()); ?>" min="0" value="0" 
                                        data-price="<?php echo esc_attr($product->get_price()); ?>" oninput="updateTotal()">
                                    <button class="qty-btn plus" onclick="updateQuantity(this, 1)">+</button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo '</div> </br>'; // Close grid container
                }
            }
            ?>
        </div>
    </div>
    <!-- ======custom items====== -->
    <div class="pro_row">
        <div class="pro_col ">
            <section id="CustomItems">
                <div class="pro_row">
                    <div class=" CustomItem">
                        <h2 class="p-0 m-0 mb-3 pt-3" >Custom Items</h2>
                        <p class="m-0 mb-4">Don't see your item above? Enter the dimensions of your item below to create a custom item! <b>from $5/month!</b> </p>
                        <p class="m-0 mb-4">
                            Please review our <a href="#">FAQ page</a> to know what you can store.
                            <b>Mattress toppers</b> are required to be in a <b>sealed bag</b> for hygienic reasons.
                        </p>
                        <div class="form col-12 m-0 p-0">
                            <form class="d-flex flex-column p-0 gap-3">
                                <div class="pro_inputBox">
                                    <label for="itemLength">name of item</label>
                                    <input type="text" id="itemName" name="itemName" >
                                </div>
            
                                <div class="input_warpper d-flex gap-2">
                                    <div class="pro_inputBox">
                                        <label for="itemLength">Length(inches)</label>
                                        <input type="number" id="itemLength" name="itemLength" oninput="handleInput(event)">
                                    </div>
                                    <div class="pro_inputBox">
                                        <label for="itemWidth">Width(inches)</label>
                                        <input type="number" id="itemWidth" name="itemWidth" oninput="handleInput(event)">
                                    </div>
                                    <div class="pro_inputBox">
                                        <label for="itemHeight">Height(inches)</label>
                                        <input type="number" id="itemHeight" name="itemHeight" oninput="handleInput(event)">
                                    </div>
                                </div>
                            </form>
                            <div class="desc d-flex justify-content-between align-items-center my-3">
                                <p class="m-0">Total Cubic Feet : <span id="TotalCubicFeet" ></span> </p> <span>€ <b id="PricePer" ></b> /month</span>
                            </div>
                            <button type="button" id="customItemBtn" class="customItemBtn py-2 rounded" style="background-color: #00A899;">Add custom item </button>
                        </div>
                    </div>
                </div>
        
            </section>
        </div>
    </div>

    <div class="prev_next_button">
        <button class="next-step">Continue</button>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {
        // Function to calculate cubic feet and price, and update the fields
        function calculateCubicFeet() {
            let length = parseFloat($("#itemLength").val()) || 0;
            let width = parseFloat($("#itemWidth").val()) || 0;
            let height = parseFloat($("#itemHeight").val()) || 0;
            let itemName = $("#itemName").val().trim();

            // Validate the input fields (make sure dimensions are positive)
            if (length <= 0 || width <= 0 || height <= 0 || !itemName) {
                $("#TotalCubicFeet").text("0");
                $("#PricePer").text("0.00");
                return;
            }

            // Calculate cubic feet
            let cubicFeet = (length * width * height) / 1728;  // Cubic feet = length * width * height / 1728
            let roundedCubicFeet = Math.ceil(cubicFeet); // Round up to the nearest integer

            // Update the Total Cubic Feet and Price per month
            $("#TotalCubicFeet").text(roundedCubicFeet);
            let pricePerCubicFoot = 5;  // Price per cubic foot (example: €5 per month)
            let totalPrice = (roundedCubicFeet * pricePerCubicFoot).toFixed(2);
            $("#PricePer").text(totalPrice);
        }

        // Event binding to update cubic feet and price when the user inputs data into any of the fields
        $(document).on("input", "#itemLength, #itemWidth, #itemHeight", function () {
            calculateCubicFeet();  // Recalculate when any of the inputs change
        });

        // Event binding for the "Add Custom Item" button to save the item and update the price summary
        $(document).on("click", "#customItemBtn", function () {

            let itemName = $("#itemName").val().trim();
            let cubicFeet = parseFloat($("#TotalCubicFeet").text()) || 0;
            let price = parseFloat($("#PricePer").text().replace(/[^\d.-]/g, "")) || 0;

            // Validate item before adding
            if (!itemName || cubicFeet <= 0 || price <= 0) {
                alert("Please provide valid item information.");
                return;
            }

            // Create the custom item object
            let customItem = {
                name: itemName,
                cubicFeet: cubicFeet,
                price: price
            };

            // Retrieve any existing custom items from sessionStorage
            let customItems = JSON.parse(sessionStorage.getItem("custom_items")) || [];

            // Add the new custom item to the array
            customItems.push(customItem);

            // Save the updated array back to sessionStorage
            sessionStorage.setItem("custom_items", JSON.stringify(customItems));

            // Update the price summary section
            updateSummary();
        });

        // Function to update the price summary with all custom items
        function updateSummary() {
            let totalPrice = 0;

            // Collect custom items from session storage
            let customItems = JSON.parse(sessionStorage.getItem("custom_items")) || [];

            // Clear previous custom items from the summary section
            $("#custom_items_summary").empty();

            // Loop through custom items and display them
            customItems.forEach((item, index) => {
                let customItemHTML = `
                    <div id="custom-item-${index}" class="custom-item" style="font-size: 14px; font-weight: 400; display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                        <span class="remove-item" data-index="${index}" style="cursor: pointer; color: red; padding-left: 0;">x</span>
                        <span style="flex-grow: 1; padding-left: 10px;">${item.name} (${item.cubicFeet} cu.ft.)</span>
                        <span style="text-align: right; padding-left: 10px;">€${item.price} /mo</span>
                    </div>
                `;
                $("#custom_items_summary").append(customItemHTML);
                totalPrice += item.price;  // Add the price of each custom item to the total
            });

            // adding only custom item(s) total
            let totalPriceCustom = totalPrice;

            //To retrieve the subtotal value from sessionStorage
            let storedSubtotal = parseFloat(sessionStorage.getItem("subtotal_pre") || "0");
            let storedSubtotalPickup = parseFloat(sessionStorage.getItem("subtotal_pickup") || "0");
            let storedSubtotalDelivery = parseFloat(sessionStorage.getItem("subtotal_delivery") || "0");
            totalPrice += storedSubtotal + storedSubtotalPickup + storedSubtotalDelivery;

            // Update the total price in the summary
            $("#subtotal").text(`€${totalPrice.toFixed(2)}`);
            $("#total_due").text(`€${totalPrice.toFixed(2)}`);

            // Save the updated subtotal_custom in sessionStorage
            sessionStorage.setItem("subtotal_custom", totalPriceCustom.toFixed(2));
        }

        // Function to handle the removal of a custom item from the summary
        $(document).on('click', '.remove-item', function () {
            let itemIndex = $(this).data('index');
            
            // Remove the item from sessionStorage
            let customItems = JSON.parse(sessionStorage.getItem("custom_items")) || [];
            customItems.splice(itemIndex, 1);
            sessionStorage.setItem("custom_items", JSON.stringify(customItems));
        
            // Remove the item from the DOM
            $(`#custom-item-${itemIndex}`).remove();
        
            // Update the price summary
            updateSummary();
        });
        
    });
</script>

<style>

.buildPlan h2.buildPlan_title {
    font-size: 28px;
    padding: 10px 0;
    font-weight: 700;
}

.buildPlan .note {
    width: 100%;
    padding: 15px;
    border-radius: 5px;
    margin-top: 20px;
    display: flex;
    align-items: center;
    background: linear-gradient(90deg, rgb(0, 43, 40) 54%, rgb(0, 98, 89) 100%);
}

#multi-step-checkout .buildPlan .note p {
    margin: 0;
    padding: 0;
    color: #fff !important;
}

.pragraph {
    width: 100%;
    position: relative;
}

/* Tooltip Styles */
.tooltipContainer {
    position: relative;
    display: inline-block;
}

.tooltipBox {
    position: absolute;
    width: 250px;
    padding: 8px;
    background-color: #202020;
    color: white;
    border-radius: 3px;
    top: 25px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 12px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
}

.tooltipContainer:hover .tooltipBox {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(-5px);
}

/* Product Grid Layouts */
.product-grid-one {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

.product-grid-two {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

#product_list {
    width: 100%;
}

/* Product Container */
.product-container {
    width: 100%;
    max-width: 600px;
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    padding: 0;
}

/* Product Image */
.product-image {
    flex-shrink: 0;
    padding: 0;
}

.product-image img {
    width: 100px !important;
    height: 100px !important;
}

/* Product Info */
.product-info {
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    flex-grow: 1;
}

.product-info strong {
    font-size: 16px;
    width: 100%;
    max-width: 210px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-info p {
    margin: 5px 0;
    font-size: 14px;
    color: #555;
}

/* Price */
.price {
    font-size: 14px;
    font-weight: bold;
}

/* Quantity Selector */
.product-quantity {
    display: flex;
    align-items: center;
    gap: 5px;
}

.product-quantity input {
    width: 25px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 0 5px;
    font-size: 16px;
    margin: 0;
}

/* Quantity Buttons */
.qty-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 0 7px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.qty-btn:hover {
    background-color: #c0392b;
}

#CustomItems {
    width: 100%;
    max-width: 600px;
    background-color: #00A899;
    display: block;
    padding: 20px;
}

/* Responsive Styles */
@media (max-width: 576px) {
    .product-grid-two {
        grid-template-columns: 1fr;
    }
}

@media (min-width: 576px) {
    .product-grid-two {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 768px) {
    .product-container {
        padding: 10px;
    }
}

@media (min-width: 992px) {
    .product-container {
        padding: 10px;
    }
}

@media (min-width: 992px) and (max-width: 1199.98px) {
    .product-container {
        gap: 5px;
        padding: 10px;
    }
}

</style>
