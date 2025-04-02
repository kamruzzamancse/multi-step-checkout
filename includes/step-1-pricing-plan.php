<!-- Step 1: Pricing Plan -->

<div class="step" id="step-1">

    <div class="pro_col">
        <section class="buildPlan">
            <h2>Build Your Storage Plan</h2>
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
                    echo '<div class="pro_text"><p><b>Note:</b> The prices shown are estimates and may vary based on the actual size and weight of your items.</p></div>';
    
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
                                    <p class="price">£<?php echo esc_html($product->get_price()); ?> /month</p>
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
                    echo '</div>'; // Close grid container
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
                    <div class=" CustomItem mt-4">
                        <h2 class="p-0 m-0 mb-3" >Custom Items</h2>
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
                                <p class="m-0">Total Cubic Feet : <span id="TotalCubicFeet" ></span> </p> <span>$ <b id="PricePer" ></b> /month</span>
                            </div>
                            <button 
                                type="button"
                                class="customItemBtn py-2 rounded" 
                                onclick = "calculateCubicFeet()"
                                style="background-color: #00A899;">Add custom item
                            </button>
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

<!-- JavaScript for Quantity Buttons -->
<script>
function updateQuantity(button, change) {
    var inputField = button.parentElement.querySelector("input");
    var currentValue = parseInt(inputField.value);
    var newValue = currentValue + change;
    if (newValue < 0) newValue = 0;
    inputField.value = newValue;
    updateTotal(); // Update price summary
}
// &&&&&&&&&&&&&custom items&&&&&&&&&&&&

function handleInput (event){
console.log(event.target);
calculateCubicFeet()
}

// ===calculate ==
        function calculateCubicFeet() {
            let itemLength = parseFloat(document.getElementById("itemLength").value);
            let itemWidth = parseFloat(document.getElementById("itemWidth").value);
            let itemHeight = parseFloat(document.getElementById("itemHeight").value);
            let TotalCubicFeet = document.getElementById("TotalCubicFeet")
            console.log("hi",itemLength * itemWidth * itemHeight);
            let cubicInches = itemLength * itemWidth * itemHeight;
            let cubicFeet = cubicInches / 1728;
            let pricePerMonth = cubicFeet * 8;

            TotalCubicFeet.innerHTML = cubicFeet.toFixed(1);
            
            if(isNaN(cubicFeet)){
                TotalCubicFeet.innerHTML = "0";
                
            }else{
                TotalCubicFeet.innerHTML = cubicFeet.toFixed(1);
                let pricePerMonth = cubicFeet * 8;
                document.getElementById("PricePer").innerHTML = pricePerMonth.toFixed(1);
            }
        }
</script>

<!-- CSS for Styling -->
<style>
    
.buildPlan h2 {
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
  background: rgb(0, 43, 40);
  background: linear-gradient(90deg, rgb(0, 43, 40) 54%, rgb(0, 98, 89) 100%);
  color: #fff;
}
.buildPlan .note p{
  padding: 0;
  margin: 0;
}

.pragraph {
    width: 100%;
    position: relative;
}

/* Tooltip container for positioning */
.tooltipContainer {
    position: relative;
    display: inline-block;
}

/* Hidden tooltip with transition effect */
.tooltipBox {
    position: absolute;
    width: 250px; 
    height: auto;
    padding: 8px !important;
    background-color:#202020;
    color: white;
    border-radius: 3px;
    top: 25px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 12px;
    z-index: 1000;
    
    /* Hide tooltip by default */
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
}

/* Show tooltip on hover */
.tooltipContainer:hover .tooltipBox {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(-5px); /* Slight movement effect */
}
/* Grid layout for single-column category (Box) */
.product-grid-one {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

/* Grid layout for two-column categories (Common & Mattresses) */
.product-grid-two {
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}
#product_list{
    width:100%;
}

    


    @media (min-width: 1200px) {
    /* Styles for large desktops */
    }

/* Product container */
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

/* Product image */
.product-image{
    flex-shrink: 0;
    padding: 0;
}
.product-image img {
    width: 100px !important;
    height: 100px !important;
    flex-shrink: 0;
}

/* Product info */
.product-info {
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    flex-grow: 1;
}

.product-info strong {
    font-size: 16px;
    display: inline-block;
    width: 100%;
    max-width: 210px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-clamp: 1;
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

/* Quantity selector */
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
    padding: 0 5px 0 5px;
    font-size: 16px;
    margin: 0;
}

/* Quantity buttons */
.qty-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 0 7px 0 7px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.qty-btn:hover {
    background-color: #c0392b;
}
#CustomItems{
    width: 100%;
    max-width: 600px;
}



@media (max-width: 576px) {
    .product-grid-two {
        grid-template-columns: 1fr;
    }
}
    @media (min-width: 576px) {
        .product-grid-two {
        grid-template-columns: 1fr 1fr;
        }
    } 
    @media (min-width: 768px) {
        .product-grid-two {
        grid-template-columns: 1fr 1fr;
        }
        .product-container {
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 10px;
        }
    } 
    @media (min-width: 992px) {
        .product-container {
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 10px;
        }
    }
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .product-container {
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-between;
            align-items: center;
            gap: 5px;
            padding: 10px;
        }
        .product-image{
            flex-shrink: 0;
            padding: 0;
        }
        .product-image img {
            width: 100px !important;
            height: 100px !important;
            flex-shrink: 0;
        }
        .product-info {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            padding: 0;
        }
        
    }

</style>
