document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("client_email");
    const phoneInput = document.getElementById("client_phone");
    const cardInput = document.getElementById("client_card");
    const submitBtn = document.getElementById("submit_booking");

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

        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();
        const card = cardInput.value.trim();

        if (!email || !phone || !card || !isValidEmail(email)) {
            alert("Please enter a valid email, phone and card number.");
            return;
        }

        let customItems = [];
        let productItems = [];

        try {
            const storedCustomItems = sessionStorage.getItem("custom_items");
            if (storedCustomItems) {
                customItems = JSON.parse(storedCustomItems);
            }

            const storedProductItems = sessionStorage.getItem("product_items");
            if (storedProductItems) {
                productItems = JSON.parse(storedProductItems);
            }
        } catch (err) {
            console.error("❌ Session parsing error:", err);
        }

        const pickup = parseFloat(sessionStorage.getItem("subtotal_pickup")) || 0;
        const delivery = parseFloat(sessionStorage.getItem("subtotal_delivery")) || 0;

        let collectionAddress = {};
        try {
            const rawAddress = sessionStorage.getItem("collection_address_checkout");
            if (rawAddress) {
                collectionAddress = JSON.parse(rawAddress); // Parse the structured address
            }
        } catch (err) {
            console.error("❌ Address parsing error:", err);
            alert("Invalid address format.");
            return; // Stop further execution if there's an error parsing the address
        }

        console.log("Parsed Address: ", collectionAddress); // Verify the parsed object


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
                pickup,
                delivery,
                collectionAddress: JSON.stringify(collectionAddress)
            })
        })
        .then(res => res.text()) // Get raw text
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
        })
    });
});
