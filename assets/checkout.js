document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("client_email");
    const phoneInput = document.getElementById("client_phone");
    const cardInput = document.getElementById("client_card");
    const submitBtn = document.getElementById("submit_booking");

    // Assume this value is passed from PHP to JS (e.g., via wp_localize_script or inline script)
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

        // 🔒 User must be logged in to continue
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
                collectionAddress: JSON.stringify(formattedAddress)
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
