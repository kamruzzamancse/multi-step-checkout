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

    // ========================== NEXT BUTTON ==========================
    $('.next-step').click(function (e) {
        // Function to set the active box color and miniBox
        function setActiveBox(boxId) {
            $(".box").removeClass("active").find(".miniBox").remove(); // Remove active from all boxes
            $("#" + boxId).addClass("active"); // Add active to clicked box
        
            // Add miniBox to the active box (if not already present)
            if (!$("#" + boxId + " .miniBox").length) {
                $("#" + boxId).append('<div class="miniBox"></div>');
            }
        }

        const storedCustomItems = sessionStorage.getItem("custom_items");
        const storedProductItems = sessionStorage.getItem("product_items");
        const rawAddress = sessionStorage.getItem("collection_address_checkout");
        const pickupDataRaw = sessionStorage.getItem("pickup_date");
        const deliveryDetails = sessionStorage.getItem("delivery_date");
    
        // Check the current step and process the steps accordingly
        if (currentStep === 1) {
            // Retrieve subtotal values
            let subtotalPre = parseFloat(sessionStorage.getItem("subtotal_pre")) || 0;
            let subtotalCustom = parseFloat(sessionStorage.getItem("subtotal_custom")) || 0;

            // Validation check before proceeding
            if (subtotalPre <= 0 && subtotalCustom <= 0) {
                alert("Please add at least one item before continuing.");
                return false;
            } else {

                // If either custom items or product items exist, mark the Storage box as filled
                if ((storedCustomItems && JSON.parse(storedCustomItems).length > 0) || 
                    (storedProductItems && JSON.parse(storedProductItems).length > 0)) {
                    $("#boxTwo").addClass("filled");
                }

                // If the subtotal is valid (greater than 0), proceed to the next step
                setActiveBox("boxTwo"); // Activate the color and miniBox for step 2
                currentStep = 2; // Set the current step
                showStep(currentStep); // Show the next step
            }
        }

        else if (currentStep === 2) {
            if (!validateAddressForm()) {
                return; // Stop progression if address is invalid
            } else {
                if (rawAddress && rawAddress.trim() !== "") {
                    $("#boxThree").addClass("filled");
                }
                setActiveBox("boxThree"); // Activate the color and miniBox for step 3
                saveAddressToSession();
                currentStep = 3; // Set the current step
                showStep(currentStep); // Show the next step
            }     
        }
    
        else if (currentStep === 3) {
            var dateInputCollection = $("#collection_timeslot").val();
            
            if (!dateInputCollection) {
                alert("❌ Please select a collection date before continuing.");
                e.preventDefault();
                return;
            } else {
                if (pickupDataRaw && pickupDataRaw !== "null" && JSON.parse(pickupDataRaw).date) {
                    $("#boxFour").addClass("filled");
                }
                setActiveBox("boxFour"); // Activate the color and miniBox for step 4
                savePickupDetails();
                currentStep = 4; // Set the current step
                showStep(currentStep); // Show the next step
            }
        }
    
        else if (currentStep === 4) {
            setActiveBox("boxFive"); // Activate the color and miniBox for step 5
            saveDeliveryDetails();
            currentStep = 5; // Set the current step
            showStep(currentStep); // Show the next step
        }

        else if (currentStep === 5) {
            if (deliveryDetails && deliveryDetails !== "null") {
                $("#boxFive").addClass("filled");
            }
            setActiveBox("boxLast"); // Activate the color and miniBox for step 6
            currentStep = 6; // Set the current step
            showStep(currentStep); // Show the next step
        }
    
        updateSummary();
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
    /* $(document).ready(function () {

        $(document).on("click", "#boxOne", function(e) {
            e.preventDefault();
            
            // Mark the box as active
            $("#boxOne").addClass("active");
        
            // Add miniBox to the active box (if not already present)
            if (!$("#boxOne .miniBox").length) {
                $("#boxOne").append('<div class="miniBox"></div>');
            }
        
            // Remove active color from other boxes
            $(".box").not("#boxOne").removeClass("active").find(".miniBox").remove();
        
            // Proceed to show the next step
            currentStep = 1;
            showStep(currentStep);
        });
        

        $(document).on("click", "#boxTwo", function(e) {
            e.preventDefault();
        
            const storedCustomItems = sessionStorage.getItem("custom_items");
            const storedProductItems = sessionStorage.getItem("product_items");
        
            // Check if at least one has a non-null, non-empty value
            if ((storedCustomItems && storedCustomItems !== "[]") || (storedProductItems && storedProductItems !== "[]")) {
                // Set the session for step-2
                sessionStorage.setItem("step-2", "true");
        
                // Mark the box as active
                $("#boxTwo").addClass("active");
        
                // Add miniBox to the active box (if not already present)
                if (!$("#boxTwo .miniBox").length) {
                    $("#boxTwo").append('<div class="miniBox"></div>');
                }
        
                // Remove active color from other boxes
                $(".box").not("#boxTwo").removeClass("active").find(".miniBox").remove();
        
                // Proceed to show the next step
                currentStep = 2;
                showStep(currentStep);
            } else {
                alert("Please add a product before proceeding.");
            }
        });

        $(document).on("click", "#boxThree", function (e) {
            e.preventDefault();
        
            const rawAddress = sessionStorage.getItem("collection_address_checkout");
        
            // Check if the collection address is valid
            if (rawAddress && rawAddress.trim() !== "") {
                // Set the session for step-3
                sessionStorage.setItem("step-3", "true");
        
                // Mark the box as active
                $("#boxThree").addClass("active");
        
                // Add miniBox to the active box (if not already present)
                if (!$("#boxThree .miniBox").length) {
                    $("#boxThree").append('<div class="miniBox"></div>');
                }
        
                // Remove active color from other boxes
                $(".box").not("#boxThree").removeClass("active").find(".miniBox").remove();
        
                // Proceed to show the next step
                currentStep = 3;
                showStep(currentStep);
            } else {
                alert("Please add a collection address before proceeding.");
            }
        });
        
        $(document).on("click", "#boxFour", function (e) {
            e.preventDefault();
        
            const pickupDataRaw = sessionStorage.getItem("pickup_date");
            const pickupData = pickupDataRaw ? JSON.parse(pickupDataRaw) : null;
        
            // Check if pickup date is valid
            if (pickupData && pickupData !== "") {
                // Set the session for step-4
                sessionStorage.setItem("step-4", "true");
        
                // Mark the box as active
                $("#boxFour").addClass("active");
        
                // Add miniBox to the active box (if not already present)
                if (!$("#boxFour .miniBox").length) {
                    $("#boxFour").append('<div class="miniBox"></div>');
                }
        
                // Remove active color from other boxes
                $(".box").not("#boxFour").removeClass("active").find(".miniBox").remove();
        
                // Proceed to show the next step
                currentStep = 4;
                showStep(currentStep);
            } else {
                alert("Please select a pickup date before proceeding.");
            }
        }); 

        $(document).on("click", "#boxFive", function(e) {
            e.preventDefault();
        
            const pickupDataRaw = sessionStorage.getItem("pickup_date");
            const pickupData = pickupDataRaw ? JSON.parse(pickupDataRaw) : null;
        
            // Check if pickup date is valid
            if (pickupData && pickupData !== "") {
                // Set the session for step-5
                sessionStorage.setItem("step-5", "true");
        
                // Mark the box as active
                $("#boxFive").addClass("active");
        
                // Add miniBox to the active box (if not already present)
                if (!$("#boxFive .miniBox").length) {
                    $("#boxFive").append('<div class="miniBox"></div>');
                }
        
                // Remove active color from other boxes
                $(".box").not("#boxFive").removeClass("active").find(".miniBox").remove();
        
                // Proceed to show the next step
                currentStep = 5;
                showStep(currentStep);
            } else {
                alert("Please select a pickup date before proceeding.");
            }
        });        
        
        $(document).on("click", "#boxLast", function (e) {
            e.preventDefault();
            //sessionStorage.removeItem("pickup_date");
            const pickupDataRaw = sessionStorage.getItem("pickup_date");
            const pickupData = pickupDataRaw ? JSON.parse(pickupDataRaw) : null;
        
            if (pickupData && pickupData !== "") {
                currentStep = 6;
                showStep(currentStep); // Show the correct section
            } else {
                alert("Please select a pickup date before proceeding.");
            }
        
            // Populate the Booking Summary table & totals
            loadPriceDetailsIntoTable();
            updateStyledChargesSummary();
            renderBookingDetailsRightSide();
        });

    }); */

    $(document).ready(function () {
        // Function to set the active box color and miniBox
        function setActiveBox(boxId) {
            $(".box").removeClass("active").find(".miniBox").remove(); // Remove active from all boxes
            $("#" + boxId).addClass("active"); // Add active to clicked box
    
            // Add miniBox to the active box (if not already present)
            if (!$("#" + boxId + " .miniBox").length) {
                $("#" + boxId).append('<div class="miniBox"></div>');
            }
        }
    
        // Function to fill boxes with color based on session data
        function fillBoxesBasedOnSession() {

            const storedCustomItems = sessionStorage.getItem("custom_items");
            const storedProductItems = sessionStorage.getItem("product_items");
            const rawAddress = sessionStorage.getItem("collection_address_checkout");
            const pickupDataRaw = sessionStorage.getItem("pickup_date");
            const deliveryDetails = sessionStorage.getItem("delivery_date");
            const disposalSelection = sessionStorage.getItem("disposal_selection");
            const protectionPlan = sessionStorage.getItem("protection_plan");

            // If step-1 is true, mark the Storage box as filled
            if ((storedCustomItems && storedCustomItems !== "[]") || (storedProductItems && storedProductItems !== "[]")) {
                $("#boxOne").addClass("filled");
            }

            // If step-2 is true, mark the Address box as filled
            if (rawAddress && rawAddress.trim() !== "") {
                $("#boxTwo").addClass("filled");
            }

            // If step-3 is true, mark the Pickup box as filled (check if pickup date exists in sessionStorage)
            if (pickupDataRaw && pickupDataRaw !== "null" && JSON.parse(pickupDataRaw).date) {
                $("#boxThree").addClass("filled");
            }

            // If step-4 is true, mark the Materials box as filled (check if delivery details exist)
            if (deliveryDetails && deliveryDetails !== "null") {
                $("#boxFour").addClass("filled");
            }

            // Parse protectionPlan and disposalSelection from sessionStorage if they are stored as JSON
            const parsedDisposalSelection = disposalSelection ? JSON.parse(disposalSelection) : null;
            const parsedProtectionPlan = protectionPlan ? JSON.parse(protectionPlan) : null;

            // Check if either the protection plan or disposal selection exists
            if ((parsedProtectionPlan && parsedProtectionPlan.id) || (parsedDisposalSelection && parsedDisposalSelection.id)) {
                $("#boxFive").addClass("filled");
            }

        }
    
        // Fill boxes based on session data when page loads
        fillBoxesBasedOnSession();
    
        // Step 1: Storage
        $(document).on("click", "#boxOne", function (e) {
            e.preventDefault();
            setActiveBox("boxOne"); // Set active color and miniBox
            currentStep = 1;
            showStep(currentStep);
        });
    
        // Step 2: Address
        $(document).on("click", "#boxTwo", function (e) {
            e.preventDefault();
            const storedCustomItems = sessionStorage.getItem("custom_items");
            const storedProductItems = sessionStorage.getItem("product_items");
    
            // Check if at least one has a non-null, non-empty value
            if ((storedCustomItems && storedCustomItems !== "[]") || (storedProductItems && storedProductItems !== "[]")) {
                sessionStorage.setItem("step-2", "true");
                setActiveBox("boxTwo"); // Set active color and miniBox
                currentStep = 2;
                showStep(currentStep);
            } else {
                alert("Please add a product before proceeding.");
            }
        });
    
        // Step 3: Pickup Address
        $(document).on("click", "#boxThree", function (e) {
            e.preventDefault();
        
            const storedCustomItems = sessionStorage.getItem("custom_items");
            const storedProductItems = sessionStorage.getItem("product_items");
            const rawAddress = sessionStorage.getItem("collection_address_checkout");
        
            // Check if either custom items or product items are present, and the collection address is valid
            if ((storedCustomItems && storedCustomItems !== "[]") || (storedProductItems && storedProductItems !== "[]")) {
                if (rawAddress && rawAddress.trim() !== "") {
                    // Set the session for step-3
                    sessionStorage.setItem("step-3", "true");
        
                    // Mark the box as active
                    setActiveBox("boxThree"); // Set active color and miniBox
        
                    // Proceed to show the next step
                    currentStep = 3;
                    showStep(currentStep);
                } else {
                    alert("Please add a collection address before proceeding.");
                }
            } else {
                alert("Please add a product before proceeding.");
            }
        });        
    
        // Step 4: Materials
        $(document).on("click", "#boxFour", function (e) {
            e.preventDefault();

            // Retrieve custom items and product items from sessionStorage
            const storedCustomItems = sessionStorage.getItem("custom_items");
            const storedProductItems = sessionStorage.getItem("product_items");
            
            // Retrieve pickup date from sessionStorage
            const pickupDataRaw = sessionStorage.getItem("pickup_date");
            const pickupData = pickupDataRaw ? JSON.parse(pickupDataRaw) : null;

            // Check if either custom items or product items exist, and the pickup date is valid
            if (
                ((storedCustomItems && storedCustomItems !== "[]") || (storedProductItems && storedProductItems !== "[]")) &&
                pickupData && pickupData !== ""
            ) {
                // Set the session for step-4
                sessionStorage.setItem("step-4", "true");

                // Mark the box as active
                setActiveBox("boxFour"); // Set active color and miniBox

                // Proceed to show the next step
                currentStep = 4;
                showStep(currentStep);
            } else {
                // Show alert if pickup date is missing or no items are added
                if (!(storedCustomItems && storedCustomItems !== "[]") && !(storedProductItems && storedProductItems !== "[]")) {
                    alert("Please add a product before proceeding.");
                } else {
                    alert("Please select a pickup date before proceeding.");
                }
            }
        });

    
       // Step 5: Protection
        $(document).on("click", "#boxFive", function (e) {
            e.preventDefault();

            // Retrieve custom items and product items from sessionStorage
            const storedCustomItems = sessionStorage.getItem("custom_items");
            const storedProductItems = sessionStorage.getItem("product_items");
            
            // Retrieve pickup date from sessionStorage
            const pickupDataRaw = sessionStorage.getItem("pickup_date");
            const pickupData = pickupDataRaw ? JSON.parse(pickupDataRaw) : null;

            // Check if either custom items or product items exist, and the pickup date is valid
            if (
                ((storedCustomItems && storedCustomItems !== "[]") || (storedProductItems && storedProductItems !== "[]")) &&
                pickupData && pickupData !== ""
            ) {
                // Set the session for step-5
                sessionStorage.setItem("step-5", "true");

                // Mark the box as active
                setActiveBox("boxFive"); // Set active color and miniBox

                // Proceed to show the next step
                currentStep = 5;
                showStep(currentStep);
            } else {
                // Show alert if no items or pickup date is missing
                if (!(storedCustomItems && storedCustomItems !== "[]") && !(storedProductItems && storedProductItems !== "[]")) {
                    alert("Please add a product before proceeding.");
                } else {
                    alert("Please select a pickup date before proceeding.");
                }
            }
        });

    
        // Step 6: Checkout
        $(document).on("click", "#boxLast", function (e) {
            e.preventDefault();

            // Retrieve custom items and product items from sessionStorage
            const storedCustomItems = sessionStorage.getItem("custom_items");
            const storedProductItems = sessionStorage.getItem("product_items");

            // Retrieve pickup date from sessionStorage
            const pickupDataRaw = sessionStorage.getItem("pickup_date");
            const pickupData = pickupDataRaw ? JSON.parse(pickupDataRaw) : null;

            // Check if either custom items or product items exist, and the pickup date is valid
            if (
                ((storedCustomItems && storedCustomItems !== "[]") || (storedProductItems && storedProductItems !== "[]")) &&
                pickupData && pickupData !== ""
            ) {
                // Set the session for step-6
                sessionStorage.setItem("step-6", "true");

                // Mark the box as active
                setActiveBox("boxLast"); // Set active color and miniBox

                // Proceed to show the next step
                currentStep = 6;
                showStep(currentStep); // Show the correct section
            } else {
                // Show alert if no items or pickup date is missing
                if (!(storedCustomItems && storedCustomItems !== "[]") && !(storedProductItems && storedProductItems !== "[]")) {
                    alert("Please add a product before proceeding.");
                } else {
                    alert("Please select a pickup date before proceeding.");
                }
            }

            // Populate the Booking Summary table & totals
            loadPriceDetailsIntoTable();
            updateStyledChargesSummary();
            renderBookingDetailsRightSide();
        });

    });
    
    

    // ==================== Disposal Selection Handling ========================
    $(".disposal-option").click(function () {
        $(".disposal-option").removeClass("selected");
        $(this).addClass("selected");

        let disposalId = $(this).data("id");
        let disposalName = ($(this).data("name") || "").trim();
        let disposalPrice = parseFloat($(this).data("price")) || 0;

        if (disposalName.toLowerCase() === "not now") {
            sessionStorage.removeItem("disposal_selection");
            sessionStorage.removeItem("disposal_price");
            disposalPriceStored = 0;
        } else {
            let disposalDetails = {
                id: disposalId,
                title: disposalName,
                price: disposalPrice,
                quantity: 1
            };
            sessionStorage.setItem("disposal_selection", JSON.stringify(disposalDetails));
            sessionStorage.setItem("disposal_price", disposalPrice);
            disposalPriceStored = disposalPrice;
        }

        updateSummary(); // Updates UI summary based on sessionStorage
    });

    // ================= Protection Plan Selection Handling ===================
    $(".protection-option").click(function () {
        $(".protection-option").removeClass("selected");
        $("#skip-protection").prop("checked", false);
        $(this).addClass("selected");
    
        let planDetails = {
            id: $(this).data("id"),
            title: $(this).data("name"),
            price: parseFloat($(this).data("price")) || 0,
            quantity: 1
        };
    
        sessionStorage.setItem("protection_plan", JSON.stringify(planDetails));
        updateSummary(); // Do not update subtotal and total due
    });    

    // ==================== Skip Protection Plan Handling =====================
    $("#skip-protection").change(function () {
        $(".protection-option").removeClass("selected");
        sessionStorage.removeItem("protection_plan");
        updateSummary();
    });

    // ==================== FlexibleArrival_1 Handling ========================
    $("#flexibleArrival_1").click(function () {
        $("#timeSlots_1").hide();
        $(this).addClass("selected");
        $("#scheduledArrival_1").removeClass("selected");
    });
    
    $("#scheduledArrival_1").click(function () {
        $("#timeSlots_1").show();
        $(this).addClass("selected");
        $("#flexibleArrival_1").removeClass("selected");
    });

    // ==================== Packing Handling =====================
    const $yesOption = $("#packing_yes");
    const $noOption = $("#packing_no");
    const $supplySection = $("#supply_timeslot_section");
    const $nextButton = $("#next_button");

    // Set default value
    if (sessionStorage.getItem("packing_selected") === null) {
        sessionStorage.setItem("packing_selected", "true");
    }

    // Yes option click
    $yesOption.click(function () {
        $yesOption.addClass("selected");
        $noOption.removeClass("selected");
        $supplySection.show();
        $nextButton.hide();
        sessionStorage.setItem("packing_selected", "true");
        updateSummary();
    });

    // No option click
    $noOption.click(function () {
        sessionStorage.removeItem("delivery_date");
        $noOption.addClass("selected");
        $yesOption.removeClass("selected");
        $supplySection.hide();
        $nextButton.show();
        sessionStorage.setItem("packing_selected", "false");
        updateSummary();
    });

    // ==================== Update Summary Function ===========================
    function updateSummary() {

        let totalPrice = 0;
    
        // Load all base subtotals ===========================
        let storedSubtotal = parseFloat(sessionStorage.getItem("subtotal_pre") || "0");
        let storedSubtotalCustom = parseFloat(sessionStorage.getItem("subtotal_custom") || "0");
    
        let pickupPrice = 0;
        let deliveryPrice = 0;
        let disposalPrice = parseFloat(sessionStorage.getItem("disposal_price")) || 0;
        let protectionPrice = 0;

        // Handle Disposal ===========================
        let disposalDetails = "";
        if (disposalPrice > 0) {
            disposalDetails += `
                <div style="margin-bottom: -18px; font-size: 14px; display: flex; justify-content: space-between; width: 100%;">
                    <span>Disposal:</span>
                    <span style="text-align: right;">€${disposalPrice.toFixed(2)}</span>
                </div><br>`;
            $("#disposal_label").show().html(disposalDetails);
        } else {
            $("#disposal_label").hide();
        }

        // Handle Protection Plan ===========================
        let protectionDetails = "";
        let protectionPlanData = sessionStorage.getItem("protection_plan");

        if (protectionPlanData) {
            let planDetails = JSON.parse(protectionPlanData);
            protectionDetails += `
                <div style="display: flex; justify-content: space-between; width: 100%; font-size: 14px">
                    <span>Protection Plan: ${planDetails.title}</span>
                    <span style="text-align: right;">€${planDetails.price.toFixed(2)}/mo</span>
                </div><br>`;
            protectionPrice = planDetails.price;
            $("#protection_plan_label").show().html(protectionDetails);
        } else {
            $("#protection_plan_label").hide();
        }
    
        // Handle Pickup ===========================
        let pickupDetails = sessionStorage.getItem("pickup_date");
        if (pickupDetails && pickupDetails !== "null") {
            let parsedPickup = JSON.parse(pickupDetails);
            let pickupPrice = parseFloat(parsedPickup.price?.replace(/[^\d.]/g, "") || "0");

            let pickupData = {
                date: parsedPickup.date || '',
                time: parsedPickup.time || '',
                price: pickupPrice
            };

            // Save structured pickup details
            sessionStorage.setItem("details_pickup", JSON.stringify(pickupData));

            // Save individual pickup price
            sessionStorage.setItem("subtotal_pickup", pickupPrice.toFixed(2));

            // Display Pickup Info
            $("#pickup_label").show();
            $("#pickup_date").html(`
                <span>${pickupData.date}, ${pickupData.time}</span>
                <span>€${pickupData.price.toFixed(2)}</span>
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
    
        // Handle Delivery (Only if packing_yes is selected) ===========================
        const packingSelected = sessionStorage.getItem("packing_selected") === "true"; // Check session storage for packing selection

        let deliveryDetails = sessionStorage.getItem("delivery_date");
        //console.log(packingSelected);

        if (packingSelected && deliveryDetails && deliveryDetails !== "null") {
            let parsedDelivery = JSON.parse(deliveryDetails);
            let deliveryPrice = parseFloat(parsedDelivery.price?.replace(/[^\d.]/g, "") || "0");

            let deliveryData = {
                date: parsedDelivery.date || '',
                time: parsedDelivery.time || '',
                price: deliveryPrice
            };
            //console.log(deliveryData);

            // Save structured delivery details
            sessionStorage.setItem("details_delivery", JSON.stringify(deliveryData));

            // Save individual delivery price
            sessionStorage.setItem("subtotal_delivery", deliveryPrice.toFixed(2));

            // Display Delivery Info
            $("#delivery_label").show();
            $("#delivery_date").html(`
                <span>${deliveryData.date}, ${deliveryData.time}</span>
                <span>€${deliveryData.price.toFixed(2)}</span>
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
        totalPrice = storedSubtotal + storedSubtotalCustom + pickupPrice + deliveryPrice + disposalPrice + protectionPrice;

        // Update UI and session ===========================
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
    //$(document).ready(updateSummary); // Also call on ready (redundant, safe)


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
            $("#arrival_window_inner").css("display", "block");
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
            $("#arrival_window_inner1").css("display", "block");
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
        let productItems = [];
    
        document.querySelectorAll(".storage-item input[type='number']").forEach(input => {
            let pricePerItem = parseFloat(input.dataset.price || "0");
            let quantity = parseInt(input.value) || 0;
            let productId = input.dataset.id;
            let productName = input.dataset.name;
    
            if (quantity > 0 && pricePerItem > 0) {
                let itemTotal = quantity * pricePerItem;
                totalPrice += itemTotal;
    
                // For price detail display
                details += `
                    <div class="storage-item-row" 
                        style="font-size: 14px; font-weight: 400; display: flex; align-items: center; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                        <div style="display: flex; align-items: center; gap: 10px; flex-grow: 1;">
                            <span>${quantity} x ${productName}</span>
                        </div>
                        <span style="text-align: right; min-width: 60px;">€${itemTotal.toFixed(2)}/mo</span>
                    </div>
                `;
    
                // Push product data for session
                productItems.push({
                    id: productId,
                    name: productName,
                    price: pricePerItem,
                    quantity: quantity
                });
            }
        });
    
        // Save predefined item subtotal before adding custom/pickup/delivery
        let totalPricePre = totalPrice;
    
        let subtotalCustom = parseFloat(sessionStorage.getItem("subtotal_custom") || "0");
        let storedSubtotalPickup = parseFloat(sessionStorage.getItem("subtotal_pickup") || "0");
        let storedSubtotalDelivery = parseFloat(sessionStorage.getItem("subtotal_delivery") || "0");
    
        totalPrice += subtotalCustom + storedSubtotalPickup + storedSubtotalDelivery;
    
        // Update UI with jQuery
        $("#price_details").html(details);
        $("#subtotal").text(`€${totalPrice.toFixed(2)}`);
        $("#total_due").text(`€${totalPrice.toFixed(2)}`);
    
        // Save values in sessionStorage
        sessionStorage.setItem("price_details", details);
        sessionStorage.setItem("subtotal", totalPrice.toFixed(2));
        sessionStorage.setItem("total_due", totalPrice.toFixed(2));
        sessionStorage.setItem("subtotal_pre", totalPricePre.toFixed(2));
        sessionStorage.setItem("product_items", JSON.stringify(productItems)); // NEW LINE
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

    // ========================== SAVE ADDRESS TO SESSION ==========================
    function saveAddressToSession() {
        let addressDetailsCheckout = {
            first_name: document.getElementById("first_name").value.trim(),
            last_name: document.getElementById("last_name").value.trim(),
            building_name: document.getElementById("building_name").value.trim(),
            address_line1: document.getElementById("address_line1").value.trim(),
            address_line2: document.getElementById("address_line2").value.trim(),
            town: document.getElementById("town").value.trim(),
            postcode: document.getElementById("postcode").value.trim(),
        };
    
        // Save the address as an object in sessionStorage, not as a comma-separated string
        sessionStorage.setItem("collection_address_checkout", JSON.stringify(addressDetailsCheckout));

        // Save special instructions to sessaion
        let specialInstructions = document.getElementById("special_instructions").value.trim();
        sessionStorage.setItem("special_instructions", specialInstructions);
    
        // If you need a simplified version for other purposes
        let addressDetails = {
            building_name: addressDetailsCheckout.building_name,
            address_line1: addressDetailsCheckout.address_line1,
            address_line2: addressDetailsCheckout.address_line2,
            town: addressDetailsCheckout.town,
            postcode: addressDetailsCheckout.postcode,
        };   
    
        let formattedAddress = Object.values(addressDetails).filter(value => value !== "").join(', ');
        sessionStorage.setItem("collection_address", formattedAddress);
    }

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

// ================== CLEAR SESSION FOR ALL STEPS ================================

/* document.getElementById("step1_clear").addEventListener("click", function(e) {
    e.preventDefault();
    sessionStorage.removeItem("price_details");
    sessionStorage.removeItem("product_items");
    sessionStorage.removeItem("custom_items");
    updateSummary();
}); */

// ====navigator steps====
