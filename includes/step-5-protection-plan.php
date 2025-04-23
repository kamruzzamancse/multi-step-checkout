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
                     data-id="<?php echo esc_attr($product->get_id()); ?>"
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
                     data-id="<?php echo esc_attr($product->get_id()); ?>"
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
    <div class="prev_next_button prev_next_button_wrapper">
        <button class="next-step pro_protection_contimue">Continue</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ======== Restore Disposal Selection ========
    const storedDisposal = sessionStorage.getItem("disposal_selection");

    if (storedDisposal) {
        try {
            const disposalData = JSON.parse(storedDisposal);
            const disposalPrice = disposalData.price;

            // Remove "selected" class from all first
            document.querySelectorAll(".disposal-option").forEach(option => option.classList.remove("selected"));

            let selector = "";

            if (parseFloat(disposalPrice) === 50) {
                selector = '.disposal-option[data-name="Yes Please!"]';
            } else {
                selector = '.disposal-option[data-name="Not now"]';
            }

            const selectedOption = document.querySelector(selector);
            if (selectedOption) {
                selectedOption.classList.add("selected");
                selectedOption.dispatchEvent(new Event("click"));
            }
        } catch (err) {
            console.warn("❌ Invalid disposal_selection session data:", err);
        }
    }

    // ======== Restore Protection Plan Selection ========
    const storedPlan = sessionStorage.getItem("protection_plan");

    if (storedPlan) {
        try {
            const planData = JSON.parse(storedPlan);
            const planId = planData.id;

            // Deselect all protection options
            document.querySelectorAll(".protection-option").forEach(option => option.classList.remove("selected"));

            const selectedPlan = document.querySelector(`.protection-option[data-id="${planId}"]`);
            if (selectedPlan) {
                selectedPlan.classList.add("selected");
                selectedPlan.dispatchEvent(new Event("click"));
            } else {
                // If not matched, maybe skip option was chosen
                document.getElementById("skip-protection").checked = true;
            }
        } catch (err) {
            console.warn("❌ Invalid protection_plan session data:", err);
        }
    }
});
</script>



<!-- CSS for Styling -->
<style>
#disposal-options, #protection-plans {
    display: flex;
    flex-wrap: nowrap;
    gap: 20px;
    margin-bottom: 20px;
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
#disposal-options .option-container{
    width: 100%;
}
#protection-plans .option-container{
    width: 100%;
}
.option-container:hover, .option-container.selected {
    border-color: #007bff;
    background-color: #e6f0ff;
}

#disposal-options .option-container .product-image {
    width: 80px !important;
    height: 80px !important;
    flex-shrink: 0;
}
#disposal-options .option-container .product-image img {
    display: block !important;
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    height: 100% !important;
    object-fit:fill;
}
#protection-plans .option-container .product-image {
    width: 80px !important;
    height: 80px !important;
    flex-shrink: 0;
}
#protection-plans .option-container .product-image img {
    display: block !important;
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    height: 100% !important;
    object-fit:fill;
}

.skip-option {
    margin-top: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.prev_next_button_wrapper{
    display: flex;
    justify-content: center;
}
.prev_next_button_wrapper .pro_protection_contimue{
    width: 100% !important;
}
@media (max-width: 576px) {
    #disposal-options, #protection-plans {
        flex-direction: column;
    }
    .option-container {
        width: 100%;
    }
    .option-container .product-image {
        width: 80px;
        height: 80px;
    }
    .option-container .product-image img {
        width: 100%;
        height: 100%;
        object-fit:contain;
    }
    
}
</style>
