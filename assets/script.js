jQuery(document).ready(function ($) {

    // ========================== Global State ==========================
    let currentStep = 1; // Start from Step 1


    // ========================== STEP MANAGEMENT ==========================
    function showStep(step) {
        $(".step").hide(); // Hide all steps
        $("#step-" + step).show(); // Show current step

        // Hide price-summary for Step 6 only
        if (step === 6) {
            $("#price-summary-wrapper").hide();
        } else {
            $("#price-summary-wrapper").show();
        }
    }

    
    // ================= STORAGE PLAN VALIDATION (STEP-1) ===================


    // ==================== ADDRESS VALIDATION (STEP-2) =====================
    function validateAddressForm() {
        const requiredFields = ['#first_name', '#last_name', '#building_name', '#address_line1', '#town', '#postcode'];
        let isValid = true;

        requiredFields.forEach(function (fieldId) {
            const field = $(fieldId);
            if (!field.val().trim()) {
                isValid = false;
                field.addClass('is-invalid');
            } else {
                field.removeClass('is-invalid');
            }
        });

        return isValid;
    }

    // ==================== PICKUPDATE VALIDATION (STEP-3) ==================
    // ==================== MATERIALS VALIDATION (STEP-4) ===================
    // ==================== PROTECTION VALIDATION (STEP-5) ==================
    // ==================== CHECKOUT VALIDATION (STEP-6) ====================


    // ========================== NEXT BUTTON ==========================
    $('.next-step').click(function () {

        if (currentStep === 1) {
             // Validation check before proceeding
            let subtotalPre = parseFloat(sessionStorage.getItem("subtotal_pre")) || 0;
            let subtotalCustom = parseFloat(sessionStorage.getItem("subtotal_custom")) || 0;

            if (subtotalPre <= 0 && subtotalCustom <= 0) {
                alert("Please add at least one item before continuing.");
                return false;
            }
        }

        if (currentStep === 2) {
            if (!validateAddressForm()) {
                return; // Stop progression if address is invalid
            }
            saveAddressToSession();
        }

        if (currentStep === 3) {
            savePickupDetails(); // Save pickup info before moving forward
        }

        if (currentStep === 4) {
            saveDeliveryDetails(); // Save Delivery info before moving forward
        }

        currentStep++;
        showStep(currentStep);
        updateSummary();
    });


    // ========================== PREVIOUS BUTTON ==========================
    $('.prev-step').click(function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });


    // ========================== Edit link handlers ==========================
    $(document).on("click", ".edit-link-address", function(e) {
        e.preventDefault();
        currentStep = 2;
        showStep(currentStep);
    });

    $(document).on("click", ".edit-link-pickup-date", function(e) {
        e.preventDefault();
        currentStep = 3;
        showStep(currentStep);
    });

    $(document).on("click", ".edit-link-supply-date", function(e) {
        e.preventDefault();
        currentStep = 4;
        showStep(currentStep);
    });

    // ========================== nav link handlers ==========================
    $(document).on("click", "#boxOne", function(e) {
        e.preventDefault();
        currentStep = 1;
        showStep(currentStep);
    });
    
    $(document).on("click", "#boxTwo", function(e) {
        e.preventDefault();
        currentStep = 2;
        showStep(currentStep);
    });
    
    $(document).on("click", "#boxThree", function(e) {
        e.preventDefault();
        currentStep = 3;
        showStep(currentStep);
    });
    
    $(document).on("click", "#boxFour", function(e) {
        e.preventDefault();
        currentStep = 4;
        showStep(currentStep);
    });
    
    $(document).on("click", "#boxFive", function(e) {
        e.preventDefault();
        currentStep = 5;
        showStep(currentStep);
    });
    
    $(document).on("click", "#boxLast", function(e) {
        e.preventDefault();
        currentStep = 6;
        showStep(currentStep);
    });
    

    // ========================== UPDATE SUMMARY DISPLAY ==========================
    /* function updateSummary() {
        let totalPrice = 0;
    
        // Load all base subtotals
        let storedSubtotal = parseFloat(sessionStorage.getItem("subtotal_pre") || "0");
        let storedSubtotalCustom = parseFloat(sessionStorage.getItem("subtotal_custom") || "0");
    
        let pickupPrice = 0;
        let deliveryPrice = 0;
    
        // Handle Pickup
        let pickupDetails = sessionStorage.getItem("pickup_date");
        if (pickupDetails && pickupDetails !== "null") {
            let pickupData = JSON.parse(pickupDetails);
            pickupPrice = parseFloat(pickupData.price?.replace(/[^\d.]/g, "") || "0");
    
            // Save individual pickup price
            sessionStorage.setItem("subtotal_pickup", pickupPrice.toFixed(2));
    
            // Display Pickup Info
            $("#pickup_label").show();
            $("#pickup_date").html(`
                <span>${pickupData.date}, ${pickupData.time}</span>
                <span>€${pickupPrice.toFixed(2)}</span>
            `).css({
                "display": "flex", 
                "justify-content": "space-between", 
                "align-items": "center",
                "width": "100%"
            }).show();
        }


        // Handle Delivery (Only if packing_yes is selected)
        const packingSelected = document.getElementById("packing_yes").classList.contains("selected");

        let deliveryDetails = sessionStorage.getItem("delivery_date");

        if (packingSelected && deliveryDetails && deliveryDetails !== "null") {
            let deliveryData = JSON.parse(deliveryDetails);
            deliveryPrice = parseFloat(deliveryData.price?.replace(/[^\d.]/g, "") || "0");

            // Save individual delivery price
            sessionStorage.setItem("subtotal_delivery", deliveryPrice.toFixed(2));

            // Display Delivery Info
            $("#delivery_label").show();
            $("#delivery_date").html(`
                <span>${deliveryData.date}, ${deliveryData.time}</span>
                <span>€${deliveryPrice.toFixed(2)}</span>
            `).css({
                "display": "flex", 
                "justify-content": "space-between", 
                "align-items": "center",
                "width": "100%"
            }).show();

        } else {
            // If not selected or no delivery data, hide section and set subtotal to 0
            $("#delivery_label, #delivery_date").hide();
            sessionStorage.setItem("subtotal_delivery", "0");
        }
    
        // Handle Delivery
        let deliveryDetails = sessionStorage.getItem("delivery_date");
        if (deliveryDetails && deliveryDetails !== "null") {
            let deliveryData = JSON.parse(deliveryDetails);
            deliveryPrice = parseFloat(deliveryData.price?.replace(/[^\d.]/g, "") || "0");
    
            // Save individual delivery price
            sessionStorage.setItem("subtotal_delivery", deliveryPrice.toFixed(2));
    
            // Display Delivery Info
            $("#delivery_label").show();
            $("#delivery_date").html(`
                <span>${deliveryData.date}, ${deliveryData.time}</span>
                <span>€${deliveryPrice.toFixed(2)}</span>
            `).css({
                "display": "flex", 
                "justify-content": "space-between", 
                "align-items": "center",
                "width": "100%"
            }).show();
        }
    
        // Final Total Calculation
        totalPrice = storedSubtotal + storedSubtotalCustom + pickupPrice + deliveryPrice;
    
        // Update UI and session
        $("#subtotal, #total_due").text(`€${totalPrice.toFixed(2)}`);
        sessionStorage.setItem("subtotal", totalPrice.toFixed(2));
        sessionStorage.setItem("total_due", totalPrice.toFixed(2));
    
        // Collection Address
        let savedAddress = sessionStorage.getItem("collection_address");
        if (savedAddress && savedAddress.trim() !== "") {
            $("#collection_address").text(savedAddress).show();
            $("#collection_label").show();
        } else {
            $("#collection_address, #collection_label").hide();
        }
    } */

        function updateSummary() {
            let totalPrice = 0;
        
            // Load all base subtotals
            let storedSubtotal = parseFloat(sessionStorage.getItem("subtotal_pre") || "0");
            let storedSubtotalCustom = parseFloat(sessionStorage.getItem("subtotal_custom") || "0");
        
            let pickupPrice = 0;
            let deliveryPrice = 0;
        
            // Handle Pickup
            let pickupDetails = sessionStorage.getItem("pickup_date");
            if (pickupDetails && pickupDetails !== "null") {
                let pickupData = JSON.parse(pickupDetails);
                pickupPrice = parseFloat(pickupData.price?.replace(/[^\d.]/g, "") || "0");
        
                // Save individual pickup price
                sessionStorage.setItem("subtotal_pickup", pickupPrice.toFixed(2));
        
                // Display Pickup Info
                $("#pickup_label").show();
                $("#pickup_date").html(`
                    <span>${pickupData.date}, ${pickupData.time}</span>
                    <span>€${pickupPrice.toFixed(2)}</span>
                `).css({
                    "display": "flex", 
                    "justify-content": "space-between", 
                    "align-items": "center",
                    "width": "100%"
                }).show();
            } else {
                $("#pickup_label").show();
                $("#pickup_date").html(`<span>No Pickup</span>`).css({
                    "display": "flex", 
                    "justify-content": "space-between", 
                    "align-items": "center",
                    "width": "100%"
                }).show();
            }
        
            // Handle Delivery (Only if packing_yes is selected)
            const packingSelected = sessionStorage.getItem("packing_selected") === "true"; // Check session storage for packing selection
        
            let deliveryDetails = sessionStorage.getItem("delivery_date");
        
            if (packingSelected && deliveryDetails && deliveryDetails !== "null") {
                let deliveryData = JSON.parse(deliveryDetails);
                deliveryPrice = parseFloat(deliveryData.price?.replace(/[^\d.]/g, "") || "0");
        
                // Save individual delivery price
                sessionStorage.setItem("subtotal_delivery", deliveryPrice.toFixed(2));
        
                // Display Delivery Info
                $("#delivery_label").show();
                $("#delivery_date").html(`
                    <span>${deliveryData.date}, ${deliveryData.time}</span>
                    <span>€${deliveryPrice.toFixed(2)}</span>
                `).css({
                    "display": "flex", 
                    "justify-content": "space-between", 
                    "align-items": "center",
                    "width": "100%"
                }).show();
            } else {
                // If not selected or no delivery data, hide section and set subtotal to 0
                $("#delivery_label, #delivery_date").hide();
                sessionStorage.setItem("subtotal_delivery", "0");
            }
        
            // Final Total Calculation
            totalPrice = storedSubtotal + storedSubtotalCustom + pickupPrice + deliveryPrice;
        
            // Update UI and session
            $("#subtotal, #total_due").text(`€${totalPrice.toFixed(2)}`);
            sessionStorage.setItem("subtotal", totalPrice.toFixed(2));
            sessionStorage.setItem("total_due", totalPrice.toFixed(2));
        
            // Collection Address
            let savedAddress = sessionStorage.getItem("collection_address");
            if (savedAddress && savedAddress.trim() !== "") {
                $("#collection_address").text(savedAddress).show();
                $("#collection_label").show();
            } else {
                $("#collection_address, #collection_label").hide();
            }
        }               

    // ========================== ON PAGE LOAD ==========================
    showStep(1);                  // Start from step 1
    updateSummary();              // Load stored data
    $(document).ready(updateSummary); // Also call on ready (redundant, safe)


    // ========================== PICKUP DATE & TIMESLOT ==========================

    // Function to save the pickup details
    function savePickupDetails() {
        // Get the selected date and arrival type
        let selectedDateC = $("#collection_timeslot").val();
        let arrivalType = $(".option.selected").attr("id");
        let selectedTimeslot = "";
        let pickupPrice = "";

        // Prevent saving if no date is selected
        if (!selectedDateC) return;

        // Determine the arrival type and selected timeslot
        if (arrivalType === "flexibleArrival") {
            selectedTimeslot = "07:00-03:00";
            pickupPrice = "€0.00";
        } else if (arrivalType === "scheduledArrival") {
            // Check if a time slot is selected
            if ($(".time-slot.selected").length > 0) {
                selectedTimeslot = $(".time-slot.selected").text() || "Not Selected";
            } else {
                selectedTimeslot = "Not Selected";
            }
            pickupPrice = "€29.00";
        }

        // Store the selected date, time, and price in an object
        let pickupData = {
            date: selectedDateC,
            time: selectedTimeslot,
            price: pickupPrice
        };

        // Store the pickup data in sessionStorage
        sessionStorage.setItem("pickup_date", JSON.stringify(pickupData));

        // Call the updateSummary function to reflect changes (ensure this function is defined elsewhere in your code)
        updateSummary();
    }

    // Ensure time slot selection is properly handled
    $(".time-slot").click(function () {
        // Remove 'selected' class from all time slots
        $(".time-slot").removeClass("selected");

        // Add 'selected' class to the clicked time slot
        $(this).addClass("selected");
    });

    // Datepicker setup
    $("#collection_timeslot").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0,
        onSelect: function (selectedDateC) {
            // Save the details when a date is selected
            savePickupDetails();
        }
    });

    // Arrival Option Selection
    $(document).on("click", ".option", function () {
        $(".option").removeClass("selected");
        $(this).addClass("selected");
        savePickupDetails();
    });


    // ========================== DELIVERY DATE & TIMESLOT ==========================

    // Function to save the pickup details
    function saveDeliveryDetails() {
        // Get the selected date and arrival type
        let selectedDate = $("#supply_timeslot").val();
        let arrivalType = $(".option_1.selected").attr("id");
        let selectedTimeslot = "";

        // Prevent saving if no date is selected
        if (!selectedDate) return;

        // Determine the arrival type and selected timeslot
        if (arrivalType === "flexibleArrival_1") {
            selectedTimeslot = "07:00-03:00";
            deliveryPrice = "€0.00";
        } else if (arrivalType === "scheduledArrival_1") {
            // Check if a time slot is selected
            if ($(".time-slot-1.selected").length > 0) {
                selectedTimeslot = $(".time-slot-1.selected").text() || "Not Selected";
            } else {
                selectedTimeslot = "Not Selected";
            }
            deliveryPrice = "€29.00";
        }

        // Store the selected date, time, and price in an object
        let deliveryData = {
            date: selectedDate,
            time: selectedTimeslot,
            price: deliveryPrice
        };

        // Store the pickup data in sessionStorage
        sessionStorage.setItem("delivery_date", JSON.stringify(deliveryData));

        // Call the updateSummary function to reflect changes (ensure this function is defined elsewhere in your code)
        updateSummary();
    }

    // Ensure time slot selection is properly handled
    $(".time-slot-1").click(function () {
        // Remove 'selected' class from all time slots
        $(".time-slot-1").removeClass("selected");

        // Add 'selected' class to the clicked time slot
        $(this).addClass("selected");
    });

    // Datepicker setup
    $("#supply_timeslot").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0,
        onSelect: function (selectedDate) {
            // Save the details when a date is selected
            saveDeliveryDetails();
        }
    });

    // Arrival Option Selection
    $(document).on("click", ".option_1", function () {
        $(".option_1").removeClass("selected");
        $(this).addClass("selected");
        saveDeliveryDetails();
    });


    // ========================== CALCULATE TOTAL PRICE ==========================
    // Called when quantity changes
    function updateTotal() {
        let totalPrice = 0;
        let details = "";
    
        document.querySelectorAll(".storage-item input[type='number']").forEach(input => {
            let pricePerItem = parseFloat(input.dataset.price || "0");
            let quantity = parseInt(input.value) || 0;
            let productName = input.closest('.storage-item').querySelector('.product-info strong').innerText;
    
            if (quantity > 0 && pricePerItem > 0) {
                let itemTotal = quantity * pricePerItem;
                totalPrice += itemTotal;
    
                details += `
                    <div class="storage-item-row" 
                        style="font-size: 14px; font-weight: 400; display: flex; align-items: center; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                        <div style="display: flex; align-items: center; gap: 10px; flex-grow: 1;">
                            <span>${quantity} x ${productName}</span>
                        </div>
                        <span style="text-align: right; min-width: 60px;">€${itemTotal.toFixed(2)}/mo</span>
                    </div>
                `;
            }
        });
    
        // Save predefined item subtotal before adding custom/pickup/delivery
        let totalPricePre = totalPrice;
    
        let subtotalCustom = parseFloat(sessionStorage.getItem("subtotal_custom") || "0");
        let storedSubtotalPickup = parseFloat(sessionStorage.getItem("subtotal_pickup") || "0");
        let storedSubtotalDelivery = parseFloat(sessionStorage.getItem("subtotal_delivery") || "0");
    
        totalPrice += subtotalCustom + storedSubtotalPickup + storedSubtotalDelivery;
    
        // Display updated details
        document.getElementById("price_details").innerHTML = details;
        document.getElementById("subtotal").innerText = `€${totalPrice.toFixed(2)}`;
        document.getElementById("total_due").innerText = `€${totalPrice.toFixed(2)}`;
    
        // Save in sessionStorage
        sessionStorage.setItem("price_details", details);
        sessionStorage.setItem("subtotal", totalPrice.toFixed(2));
        sessionStorage.setItem("total_due", totalPrice.toFixed(2));
        sessionStorage.setItem("subtotal_pre", totalPricePre.toFixed(2));
    }

    
    // ========================== RESTORE ALL STEPS DATA ON REFRESH ==========================
    jQuery(document).ready(function ($) {
        // Check if price details exist in sessionStorage
        if (sessionStorage.getItem("price_details")) {
            // Restore price details
            $("#price_details").html(sessionStorage.getItem("price_details"));
        }
    
        // Check if there are custom items in sessionStorage
        let customItems = JSON.parse(sessionStorage.getItem("custom_items")) || [];
        console.log("Custom Items from SessionStorage:", sessionStorage.getItem("custom_items"));
        console.log("Debugging Message: Hire larka");
    
        // Only proceed if there are custom items in sessionStorage
        if (customItems.length > 0) {
            // Clear previous custom items from the summary section
            $("#custom_items_summary").empty();
    
            // Initialize a variable to keep track of the total price of custom items
            let totalPrice = 0;
    
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
    
            // Save subtotal_custom to sessionStorage
            sessionStorage.setItem("subtotal_custom", totalPrice.toFixed(2));
        }
    
        // Calculate and display the total price by adding subtotal_pre and subtotal_custom
        let subtotalPre = parseFloat(sessionStorage.getItem("subtotal_pre")) || 0;
        let subtotalCustom = parseFloat(sessionStorage.getItem("subtotal_custom")) || 0;
        let storedSubtotalPickup = parseFloat(sessionStorage.getItem("subtotal_pickup") || "0");
        let storedSubtotalDelivery = parseFloat(sessionStorage.getItem("subtotal_delivery") || "0");
        let total = subtotalPre + subtotalCustom + storedSubtotalPickup + storedSubtotalDelivery;
    
        $("#subtotal").text(`€${total.toFixed(2)}`);
        $("#total_due").text(`€${total.toFixed(2)}`);
    
        // If a collection address is saved, display it
        let savedAddress = sessionStorage.getItem("collection_address");
        let addressLabel = $("#collection_label");
    
        if (savedAddress && savedAddress.trim() !== "") {
            $("#collection_address").text(savedAddress);
            addressLabel.show();
        } else {
            $("#collection_address").hide();
            addressLabel.hide();
        }
    });

    
    // ========================== QUANTITY CHANGE BUTTONS ==========================
    window.updateQuantity = function (button, change) {
        var inputField = button.parentElement.querySelector("input");
        var currentValue = parseInt(inputField.value);
        var newValue = currentValue + change;
        if (newValue < 0) newValue = 0;
        inputField.value = newValue;
        updateTotal();
    };

    /* function updateQuantity(button, change) {
        const input = $(button).siblings('input[type="number"]');
        let value = parseInt(input.val()) || 0;
        value = Math.max(0, value + change);
        input.val(value);
    
        // Save to sessionStorage
        const productId = input.attr('id');
        saveQuantityToSession(productId, value);
    
        updateTotal();
    }
    
    function saveQuantityToSession(productId, quantity) {
        let quantities = JSON.parse(sessionStorage.getItem('product_quantities') || '{}');
        quantities[productId] = quantity;
        sessionStorage.setItem('product_quantities', JSON.stringify(quantities));
    } */    


    // ========================== SAVE ADDRESS TO SESSION ==========================
    function saveAddressToSession() {
        let addressDetails = {
            building_name: document.getElementById("building_name").value.trim(),
            address_line1: document.getElementById("address_line1").value.trim(),
            address_line2: document.getElementById("address_line2").value.trim(),
            town: document.getElementById("town").value.trim(),
            postcode: document.getElementById("postcode").value.trim(),
        };

        let formattedAddress = Object.values(addressDetails).filter(value => value !== "").join(', ');
        sessionStorage.setItem("collection_address", formattedAddress);
    }


    // ========================== FINAL SAVE ON NEXT CLICK ==========================
    /* document.querySelector(".next-step").addEventListener("click", function () {
        saveAddressToSession();
        updateSummary();
    }); */

});

// ================== AUTO-UPDATE LABEL STATE FOR INPUT FIELDS ==================
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".pro_inputBox input").forEach((input) => {
        let label = input.closest(".pro_inputBox")?.querySelector("label");

        if (!label) return;

        // Initialize the label state
        if (input.value.trim()) label.classList.add("filled");

        // Add event listeners for focus, click, and blur
        input.addEventListener("focus", () => label.classList.add("filled"));
        input.addEventListener("click", () => label.classList.add("filled"));
        input.addEventListener("blur", () => {
            if (!input.value.trim()) label.classList.remove("filled");
        });
    });
});
