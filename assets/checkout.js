document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("client_email");
    const phoneInput = document.getElementById("client_phone");
    const cardInput = document.getElementById("client_card");
    const submitBtn = document.getElementById("submit_booking");

    const isUserLoggedIn = msc_ajax_obj.is_user_logged_in === '1';

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function checkEnable() {
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();
        const card = cardInput.value.trim();
        submitBtn.disabled = !(email && phone && card && isValidEmail(email));
    }

    emailInput.addEventListener("input", checkEnable);
    phoneInput.addEventListener("input", checkEnable);
    cardInput.addEventListener("input", checkEnable);

    submitBtn.addEventListener("click", function (e) {
        e.preventDefault();

        if (!isUserLoggedIn) {
            alert("❌ You must log in to complete the booking.");
            const currentUrl = window.location.href;
            const baseUrl = window.location.origin + "/leonardoemlh";
            window.location.href = baseUrl + "/login?redirect_to=" + encodeURIComponent(currentUrl);
            return;
        }

        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();
        const card = cardInput.value.trim();

        if (!email || !phone || !card || !isValidEmail(email)) {
            alert("Please enter a valid email, phone, and card number.");
            return;
        }

        let customItems = [];
        let productItems = [];
        let protectionPlan = null;
        let disposalSelection = null;

        try {
            const storedCustomItems = sessionStorage.getItem("custom_items");
            if (storedCustomItems) customItems = JSON.parse(storedCustomItems);

            const storedProductItems = sessionStorage.getItem("product_items");
            if (storedProductItems) productItems = JSON.parse(storedProductItems);

            const storedPlan = sessionStorage.getItem("protection_plan");
            if (storedPlan) protectionPlan = JSON.parse(storedPlan);

            const storedDisposal = sessionStorage.getItem("disposal_selection");
            if (storedDisposal) disposalSelection = JSON.parse(storedDisposal);
        } catch (err) {
            console.error("❌ Session parsing error:", err);
        }

        // for Pickup details
        let pickup = {
            date: '',
            time: '',
            price: 0
        };

        try {
            const pickupData = JSON.parse(sessionStorage.getItem("pickup_date"));
            if (pickupData && typeof pickupData === 'object') {
                pickup.date = pickupData.date || '';
                pickup.time = pickupData.time || '';
                const rawPrice = pickupData.price || '0';
                pickup.price = parseFloat(String(rawPrice).replace(/[^\d.]/g, '')) || 0;
            }
        } catch (err) {
            console.warn("❌ Invalid pickup data in sessionStorage", err);
        }

        // for Delivery details
        let delivery = {
            date: '',
            time: '',
            price: 0
        };

        try {
            const deliveryData = JSON.parse(sessionStorage.getItem("delivery_date"));
            if (deliveryData && typeof deliveryData === 'object') {
                delivery.date = deliveryData.date || '';
                delivery.time = deliveryData.time || '';
                const rawPrice = deliveryData.price || '0';
                delivery.price = parseFloat(String(rawPrice).replace(/[^\d.]/g, '')) || 0;
            }
        } catch (err) {
            console.warn("❌ Invalid delivery data in sessionStorage", err);
        }

        // Collection Address
        let collectionAddress = {};
        try {
            const rawAddress = sessionStorage.getItem("collection_address_checkout");
            if (rawAddress) {
                collectionAddress = JSON.parse(rawAddress);
            }
        } catch (err) {
            console.error("❌ Address parsing error:", err);
            alert("Invalid address format.");
            return;
        }

        const formattedAddress = {
            billing: collectionAddress,
            shipping: collectionAddress
        };

        // Special Instructions
        let specialInstructions = '';
        try {
            specialInstructions = sessionStorage.getItem("special_instructions") || '';
        } catch (err) {
            console.warn("❌ Could not read special instructions from sessionStorage", err);
        }

        fetch(msc_ajax_obj.ajax_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({
                action: "msc_place_order",
                nonce: msc_ajax_obj.nonce,
                email,
                phone,
                card,
                customItems: JSON.stringify(customItems),
                productItems: JSON.stringify(productItems),
                protectionPlan: JSON.stringify(protectionPlan),
                disposalSelection: JSON.stringify(disposalSelection),
                pickup: JSON.stringify(pickup),
                delivery: JSON.stringify(delivery),
                collectionAddress: JSON.stringify(formattedAddress),
                specialInstructions: specialInstructions
            })
        })
        .then(res => res.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    alert("✅ Order Placed Successfully!");
                    window.location.href = data.data.redirect_url;
                } else {
                    alert("❌ Order failed: " + (data.data?.message || "Unknown error"));
                }
            } catch (err) {
                console.error("❌ Response not valid JSON:", text);
                alert("❌ Server returned unexpected response. Check console.");
            }
        });
    });
});
