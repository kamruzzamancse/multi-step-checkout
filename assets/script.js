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


    // ========================== ADDRESS VALIDATION ==========================
    function validateAddressForm() {
        const requiredFields = ['#building_name', '#address_line1', '#town', '#postcode'];
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


    // ========================== NEXT BUTTON ==========================
    $('.next-step').click(function () {
        if (currentStep === 2) {
            if (!validateAddressForm()) {
                //return; // Stop progression if address is invalid
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
        // Price Summary
        if (sessionStorage.getItem("price_details")) {
            $("#price_details").html(sessionStorage.getItem("price_details"));
            $("#subtotal").text(`£${sessionStorage.getItem("subtotal")}`);
            $("#total_due").text(`£${sessionStorage.getItem("total_due")}`);
        }

        // Collection Address
        let savedAddress = sessionStorage.getItem("collection_address");
        if (savedAddress && savedAddress.trim() !== "") {
            $("#collection_address").text(savedAddress).show();
            $("#collection_label").show();
        } else {
            $("#collection_address, #collection_label").hide();
        }

        // Pickup Date/Time
        let pickupDetails = sessionStorage.getItem("pickup_date");

        if (pickupDetails && pickupDetails !== "null") {  
            let pickupData = JSON.parse(pickupDetails);  

            if (pickupData.date && pickupData.time && pickupData.price !== undefined) {  
                $("#pickup_label").show();  

                // Convert price string to a number safely
                let pickupPrice = parseFloat(pickupData.price.replace(/[^\d.]/g, "")) || 0;

                // Create spans for alignment
                $("#pickup_date")
                    .html(`
                        <span>${pickupData.date}, ${pickupData.time}</span>
                        <span>£${pickupPrice.toFixed(2)}</span>
                    `)
                    .css({
                        "display": "flex", 
                        "justify-content": "space-between", 
                        "align-items": "center",
                        "width": "100%"
                    })
                    .show();
            }  
        }

        // Delivery Date/Time
        let deliveryDetails = sessionStorage.getItem("delivery_date");

        if (deliveryDetails && deliveryDetails !== "null") {  
            let deliveryData = JSON.parse(deliveryDetails);  

            if (deliveryData.date && deliveryData.time && deliveryData.price !== undefined) {  
                $("#delivery_label").show();

                // Convert price string to a number safely
                let deliveryPrice = parseFloat(deliveryData.price.replace(/[^\d.]/g, "")) || 0;

                // Create spans for alignment
                $("#delivery_date")
                    .html(`
                        <span>${deliveryData.date}, ${deliveryData.time}</span>
                        <span">£${deliveryPrice.toFixed(2)}</span>
                    `)
                    .css({
                        "display": "flex", 
                        "justify-content": "space-between", 
                        "align-items": "center",
                        "width": "100%"
                    })
                    .show();  
            }  
        }
        
    } */

    function updateSummary() {
        // Price Summary
        if (sessionStorage.getItem("price_details")) {
            $("#price_details").html(sessionStorage.getItem("price_details"));
        }
    
        // Initialize total price
        let totalPrice = 0;
    
        // Collect price for storage items
        document.querySelectorAll(".storage-item input[type='number']").forEach(input => {
            let pricePerItem = parseFloat(input.dataset.price);
            let quantity = parseInt(input.value);
            let productName = input.closest('.storage-item').querySelector('.product-info strong').innerText;
    
            if (isNaN(quantity) || quantity < 1) quantity = 0;
            if (isNaN(pricePerItem) || pricePerItem <= 0) pricePerItem = 0;
    
            if (quantity > 0 && pricePerItem > 0) {
                let itemTotal = quantity * pricePerItem;
                totalPrice += itemTotal;
            }
        });
    
        // Pickup Price
        let pickupDetails = sessionStorage.getItem("pickup_date");
        if (pickupDetails && pickupDetails !== "null") {  
            let pickupData = JSON.parse(pickupDetails);
            if (pickupData.price) {
                let pickupPrice = parseFloat(pickupData.price.replace(/[^\d.]/g, "")) || 0;
                totalPrice += pickupPrice;
    
                // Display Pickup Date/Time with price
                $("#pickup_label").show();
                $("#pickup_date")
                    .html(`
                        <span>${pickupData.date}, ${pickupData.time}</span>
                        <span>£${pickupPrice.toFixed(2)}</span>
                    `)
                    .css({
                        "display": "flex", 
                        "justify-content": "space-between", 
                        "align-items": "center",
                        "width": "100%"
                    })
                    .show();
            }  
        }
    
        // Delivery Price
        let deliveryDetails = sessionStorage.getItem("delivery_date");
        if (deliveryDetails && deliveryDetails !== "null") {  
            let deliveryData = JSON.parse(deliveryDetails);
            if (deliveryData.price) {
                let deliveryPrice = parseFloat(deliveryData.price.replace(/[^\d.]/g, "")) || 0;
                totalPrice += deliveryPrice;
    
                // Display Delivery Date/Time with price
                $("#delivery_label").show();
                $("#delivery_date")
                    .html(`
                        <span>${deliveryData.date}, ${deliveryData.time}</span>
                        <span>£${deliveryPrice.toFixed(2)}</span>
                    `)
                    .css({
                        "display": "flex", 
                        "justify-content": "space-between", 
                        "align-items": "center",
                        "width": "100%"
                    })
                    .show();
            }  
        }
    
        // Subtotal and Total Due
        $("#subtotal").text(`£${totalPrice.toFixed(2)}`);
        $("#total_due").text(`£${totalPrice.toFixed(2)}`);
    
        // Save in session
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
            pickupPrice = "£0.00";
        } else if (arrivalType === "scheduledArrival") {
            // Check if a time slot is selected
            if ($(".time-slot.selected").length > 0) {
                selectedTimeslot = $(".time-slot.selected").text() || "Not Selected";
            } else {
                selectedTimeslot = "Not Selected";
            }
            pickupPrice = "£29.00";
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
        let pickupPrice = "";

        // Prevent saving if no date is selected
        if (!selectedDate) return;

        // Determine the arrival type and selected timeslot
        if (arrivalType === "flexibleArrival_1") {
            selectedTimeslot = "07:00-03:00";
            deliveryPrice = "£0.00";
        } else if (arrivalType === "scheduledArrival_1") {
            // Check if a time slot is selected
            if ($(".time-slot-1.selected").length > 0) {
                selectedTimeslot = $(".time-slot-1.selected").text() || "Not Selected";
            } else {
                selectedTimeslot = "Not Selected";
            }
            deliveryPrice = "£29.00";
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
            let pricePerItem = parseFloat(input.dataset.price);
            let quantity = parseInt(input.value);
            let productName = input.closest('.storage-item').querySelector('.product-info strong').innerText;

            if (isNaN(quantity) || quantity < 1) quantity = 0;
            if (isNaN(pricePerItem) || pricePerItem <= 0) pricePerItem = 0;

            if (quantity > 0 && pricePerItem > 0) {
                let itemTotal = quantity * pricePerItem;
                totalPrice += itemTotal;
                details += `${quantity} x ${productName} = £${itemTotal.toFixed(2)} <br>`;
            }
        });

        // Display
        document.getElementById("price_details").innerHTML = details;
        document.getElementById("subtotal").innerText = `£${totalPrice.toFixed(2)}`;
        document.getElementById("total_due").innerText = `£${totalPrice.toFixed(2)}`;

        // Save in session
        sessionStorage.setItem("price_details", details);
        sessionStorage.setItem("subtotal", totalPrice.toFixed(2));
        sessionStorage.setItem("total_due", totalPrice.toFixed(2));
    }


    // ========================== RESTORE PRICE DETAILS ON REFRESH ==========================
    document.addEventListener("DOMContentLoaded", () => {
        if (sessionStorage.getItem("price_details")) {
            document.getElementById("price_details").innerHTML = sessionStorage.getItem("price_details");
            document.getElementById("subtotal").innerText = `£${sessionStorage.getItem("subtotal")}`;
            document.getElementById("total_due").innerText = `£${sessionStorage.getItem("total_due")}`;
        }

        let savedAddress = sessionStorage.getItem("collection_address");
        let addressLabel = document.getElementById("collection_label");

        if (savedAddress && savedAddress.trim() !== "") {
            document.getElementById("collection_address").innerText = savedAddress;
            addressLabel.style.display = "block";
        } else {
            document.getElementById("collection_address").style.display = "none";
            addressLabel.style.display = "none";
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
    document.querySelector(".next-step").addEventListener("click", function () {
        saveAddressToSession();
        updateSummary();
    });

});





// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// document.addEventListener("DOMContentLoaded", function () {
//     let inputs = document.querySelectorAll(".pro_inputBox input");

//     inputs.forEach((input) => {

//       if (input.value) {
//         input.previousElementSibling.classList.add("filled");
//       }
  
  
//       input.addEventListener("focus", () => {
//         input.previousElementSibling.classList.add("filled");
//       });
//       input.addEventListener("click", () => {
//         input.previousElementSibling.classList.add("filled");
//       });

//       input.addEventListener("blur", () => {
//         if (input.value === "") {
//           input.previousElementSibling.classList.remove("filled");
//         }
//       });
//     });
//   });
  document.addEventListener("DOMContentLoaded", function () {
    let inputs = document.querySelectorAll(".pro_inputBox input");

    inputs.forEach((input) => {
        let parentBox = input.closest(".pro_inputBox"); 
        let label = parentBox ? parentBox.querySelector("label") : null;

        if (!label) return; 

        
        if (input.value.trim()) {
            label.classList.add("filled");
        }

        input.addEventListener("focus", () => {
            label.classList.add("filled");
        });


        input.addEventListener("click", () => {
            label.classList.add("filled");
        });


        input.addEventListener("blur", () => {
            if (!input.value.trim()) {
                label.classList.remove("filled");
            }
        });
    });
});