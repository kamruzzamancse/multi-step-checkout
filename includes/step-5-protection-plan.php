<!-- Step 5: Protection Plan -->
<div class="step" id="step-5">
    <h2>Do you have any items to dispose of?</h2>
    <p>Use our disposal service and check one more thing off of your to-do list.</p>
    
    <!-- Disposal Options -->
    <div id="disposal-options" class="product-grid">
        <?php
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => 'disposal'
                )
            )
        );
        
        $products = new WP_Query($args);
        if ($products->have_posts()) :
            while ($products->have_posts()) : $products->the_post();
                $product = wc_get_product(get_the_ID());
                ?>
                <div class="option-container disposal-option" 
                     data-name="<?php echo esc_html($product->get_name()); ?>" 
                     data-price="<?php echo esc_html($product->get_price()); ?>">
                    <div class="product-image">
                        <?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
                    </div>
                    <div class="product-info">
                        <strong><?php echo esc_html($product->get_name()); ?></strong>
                        <p><?php echo esc_html($product->get_short_description()); ?></p>
                    </div>
                    <?php if ($product->get_name() !== 'Not now') : ?>
                        <span class="price">$<?php echo esc_html($product->get_price()); ?>+</span>
                    <?php endif; ?>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

    <br><br>

    <!-- Protection Plan Selection -->
    <h2>Add a protection plan?</h2>
    <p>Choose how much coverage you need.</p>
    
    <div id="protection-plans" class="product-grid">
        <?php
        $args['tax_query'][0]['terms'] = 'protection-plan';
        $products = new WP_Query($args);
        if ($products->have_posts()) :
            while ($products->have_posts()) : $products->the_post();
                $product = wc_get_product(get_the_ID());
                ?>
                <div class="option-container protection-option" 
                     data-name="<?php echo esc_html($product->get_name()); ?>" 
                     data-price="<?php echo esc_html($product->get_price()); ?>">
                    <div class="product-image">
                        <?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
                    </div>
                    <div class="product-info">
                        <strong><?php echo esc_html($product->get_name()); ?></strong>
                        <p><?php echo esc_html($product->get_short_description()); ?></p>
                        <span class="price">$<?php echo esc_html($product->get_price()); ?>/mo</span>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

    <br>

    <!-- Skip Protection Plan Option -->
    <div class="skip-option">
        <input type="radio" id="skip-protection" name="protection-plan" value="none">
        <label for="skip-protection">Skip, I don’t need a protection plan</label>
    </div>

    <br>

    <!-- Navigation Buttons -->
    <div class="prev_next_button">
        <button class="prev-step">Previous</button>
        <button class="next-step">Next</button>
    </div>
</div>

<!-- JavaScript for Selection Handling -->
<script>
jQuery(document).ready(function ($) {
    // Track disposal price to avoid multiple additions
    let disposalPriceStored = parseFloat(sessionStorage.getItem("disposal_price")) || 0;

    // ✅ Disposal Selection Handling
    $(".disposal-option").click(function () {
        $(".disposal-option").removeClass("selected");
        $(this).addClass("selected");

        let disposalName = $(this).data("name");
        let disposalPrice = parseFloat($(this).data("price")) || 0;

        if (disposalName.toLowerCase() === "not now") {
            if (sessionStorage.getItem("disposal_price")) {
                sessionStorage.removeItem("disposal_price"); // Remove price from session
                disposalPriceStored = 0; // Reset disposal price
            }
        } else {
            if (disposalPriceStored === 0) {
                sessionStorage.setItem("disposal_price", disposalPrice);
                disposalPriceStored = disposalPrice; // Store new disposal price
            }
        }

        updateSummary(false); // Do not update subtotal and total due
    });

    // ✅ Protection Plan Selection Handling
    $(".protection-option").click(function () {
        $(".protection-option").removeClass("selected");
        $("#skip-protection").prop("checked", false);
        $(this).addClass("selected");

        let planDetails = {
            title: $(this).data("name"),
            price: parseFloat($(this).data("price")) || 0
        };

        sessionStorage.setItem("protection_plan", JSON.stringify(planDetails));
        updateSummary(false); // Do not update subtotal and total due
    });

    // ✅ Skip Protection Plan Handling
    $("#skip-protection").change(function () {
        $(".protection-option").removeClass("selected");
        sessionStorage.removeItem("protection_plan");
        updateSummary(false); // Do not update subtotal and total due
    });

    // ✅ Update Summary Function
    function updateSummary(updateTotals = true) {
        let subtotal = 0;
        let details = "";

        // ✅ Load and display storage price details
        if (sessionStorage.getItem("price_details")) {
            details += sessionStorage.getItem("price_details");
            subtotal += parseFloat(sessionStorage.getItem("subtotal")) || 0;
        }

        // ✅ Load and display disposal price if selected
        let disposalPrice = parseFloat(sessionStorage.getItem("disposal_price")) || 0;
        if (disposalPrice > 0) {
            details += `<strong>Disposal:</strong> £${disposalPrice.toFixed(2)} <br>`;
            subtotal += disposalPrice;
            $("#disposal_label").css("display", "block");  // Ensure it's visible
        } else {
            $("#disposal_label").css("display", "none");
        }

        // ✅ Load and display protection plan if selected
        let protectionPlanData = sessionStorage.getItem("protection_plan");
        if (protectionPlanData) {
            let planDetails = JSON.parse(protectionPlanData);
            details += `<strong>Protection Plan:</strong> ${planDetails.title} - £${planDetails.price.toFixed(2)}/mo <br>`;
            subtotal += planDetails.price;
            $("#protection_plan_label").css("display", "block");  // Ensure it's visible
        } else {
            $("#protection_plan_label").css("display", "none");
        }

        // ✅ Load and display collection address
        /* let savedAddress = sessionStorage.getItem("collection_address");
        if (savedAddress && savedAddress.trim() !== "") {
            $("#collection_address").text(savedAddress).css("display", "block");
            $("#collection_label").css("display", "block");
        } else {
            $("#collection_address, #collection_label").css("display", "none");
        } */

        // ✅ Load and display pickup details
       /*  let pickupDetails = sessionStorage.getItem("pickup_date");
        if (pickupDetails) {
            let pickupData = JSON.parse(pickupDetails);
            $("#pickup_label").css("display", "block");
            $("#pickup_date").text(`${pickupData.date} (${pickupData.time})`);
        } else {
            $("#pickup_label").css("display", "none");
        } */

        // ✅ Update price summary UI
        $("#price_details").html(details);

        // ✅ Update subtotal and total due only if updateTotals is true
        if (updateTotals) {
            $("#subtotal").text(`£${subtotal.toFixed(2)}`);
            $("#total_due").text(`£${subtotal.toFixed(2)}`);

            // Save updated values in session storage
            sessionStorage.setItem("subtotal", subtotal.toFixed(2));
            sessionStorage.setItem("total_due", subtotal.toFixed(2));
        }
    }

    // ✅ Ensure Summary Updates on Page Load
    updateSummary(false); // Do not update subtotal and total due on page load

    // ✅ Next Button Click Event
    $(".next-step").click(function () {
        updateSummary(true); // Update subtotal and total due on "Next" button click
    });
});
</script>

<!-- CSS for Styling -->
<style>
.product-grid {
    display: flex;
    gap: 15px;
}

.option-container {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 10px;
    border: 2px solid transparent;
    border-radius: 10px;
    background-color: #f9f9f9;
    cursor: pointer;
    position: relative;
}

.option-container:hover, .option-container.selected {
    border-color: #007bff;
    background-color: #e6f0ff;
}

.option-container .product-image {
    width: 100px;
    height: 100px;
    flex-shrink: 0;
}
.option-container .product-image img {
    width: 100%;
    height: 100%;
    object-fit:contain;
}

.product-info {
    /* flex-grow: 1; */
}

.skip-option {
    margin-top: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}
</style>
