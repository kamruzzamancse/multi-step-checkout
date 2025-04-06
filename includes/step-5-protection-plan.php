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
        <button class="next-step">Continue</button>
    </div>
</div>

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

.skip-option {
    margin-top: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
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
