<!-- Step 6: Checkout -->

<div class="step" id="step-6">
    <div class="pro_container">
        <div class="pro_row checkout_wraper">
            <div class="pro_col_60 left-section">
                <h2>Your Booking Summary</h2>
                <p>Enter your email and payment information to secure your appointment.</p>

                <!-- Booking Summary Table -->
                <table class="booking-summary-table">
                    <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>QUANTITY</th>
                            <th>PRICE</th>
                        </tr>
                    </thead>
                    <tbody id="price_table_body">
                        <!-- Dynamic items from session will load here -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="last_line" colspan="3" style="text-align:right; font-weight:bold; border-top: 2px solid #ccc;"></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Charges + Notice Layout -->
                <div class="charges-section">   
                    <!-- ⚠️ Left Notice -->
                    <div class="charges-note">
                        <div class="warning-icon">⚠️</div>
                        <p>You can change your booking by emailing us as soon as possible, at least 72 hours before your first appointment, or fees will apply.</p>
                    </div>

                    <!-- 📊 Right Summary Table -->
                    <div class="charges-box">
                        <table class="summary-table">
                            <thead>
                                <tr>
                                    <th>Charges</th>
                                    <th>One-Time</th>
                                    <th>Monthly</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td id="oneTimeSubtotal">€0.00</td>
                                    <td id="monthlySubtotal">€0.00</td>
                                </tr>
                                <tr>
                                    <td>HST</td>
                                    <td id="oneTimeHST">€0.00</td>
                                    <td id="monthlyHST">€0.00</td>
                                </tr>
                                <tr class="total-row">
                                    <td><strong>Total</strong></td>
                                    <td id="oneTimeTotal"><strong>€0.00</strong></td>
                                    <td id="monthlyTotal"><strong>€0.00</strong></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="last_line" colspan="3" style="text-align:right; font-weight:bold; border-top: 2px solid #ccc;"></td>
                                </tr>
                            </tfoot>
                        </table>
                        <p class="delivery-note">Delivery Fee applies at delivery <span title="This will be added later.">❔</span></p>
                    </div>
                    
                </div>
            </div>

            <div class="pro_col_40 right-section">
                <!-- ✅ Right Side: Booking Info + Payment -->
                <div class="right-side-panel">
                    <!-- Booking Info -->
                    <div class="booking-info-box">
                        
                        <div class="booking-row left-align">
                            <div><strong>School:</strong> <br> <span id="school_info"></span></div>
                            <a href="#" class="edit-link-school">Edit</a>
                        </div> 

                        <div class="booking-row right-align">
                            <div><strong>Supply Date:</strong> <br> <span id="supply_date_info"></span></div>
                            <a href="#" class="edit-link-supply-date">Edit</a>
                        </div>

                        <div class="booking-row left-align">
                            <div><strong>Address:</strong> <br> <span id="address_info"></span></div>
                            <a href="#" class="edit-link-address">Edit</a>
                        </div>

                        <div class="booking-row right-align">
                            <div><strong>Pickup Date:</strong> <br> <span id="pickup_date_info"></span></div>
                            <a href="#" class="edit-link-pickup-date">Edit</a>
                        </div>
                    </div>


                    <!-- Payment Box -->
                    <div class="payment-box">
                        <h3>Email & Payment</h3>
                        <form id="checkout-form">
                            <label>Email *</label>
                            <input type="email" id="client_email" required>

                            <label>Contact Number *</label>
                            <input type="tel" id="client_phone" name="client_phone" pattern="^\+?[0-9\s\-]{7,15}$" required placeholder="+44 7123 456 789">

                            <label>Card number</label>
                            <div class="card-input">
                                <input type="text" id="client_card" placeholder="Card number" required>
                                <button type="button" class="autofill-btn">Autofill link</button>
                            </div>

                            <div class="secure-label">
                                <img src="https://img.icons8.com/ios-glyphs/30/lock--v1.png" alt="Secure"> Secure & encrypted
                                <span class="stripe-icons">
                                    <img src="https://img.icons8.com/color/32/visa.png" alt="Visa">
                                    <img src="https://img.icons8.com/color/32/mastercard-logo.png" alt="MC">
                                    <img src="https://img.icons8.com/color/32/amex.png" alt="AMEX">
                                    <img src="https://img.icons8.com/color/32/stripe.png" alt="Stripe">
                                </span>
                            </div>

                            <p class="tos">By clicking Reserve Smart Storage, you are agreeing to Clutter’s <a href="#">Terms of Use</a> and to receive SMS messages related to your appointment.</p>

                            <button type="submit" id="submit_booking" class="submit-booking" disabled>Submit Booking</button>
                            <p class="note">You won’t be charged until your Pickup appointment</p>
                        </form>

                        <div class="bottom-note-icons">
                            <div>📉 We’ll lower your monthly rate<br>if you end up having less items.</div>
                            <div>💬 No-risk booking: you can<br>cancel your free reservation online.</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- ✅ JavaScript -->

<script>

function loadPriceDetailsIntoTable() {

    const tbody = document.getElementById("price_table_body");
    if (!tbody) return;
    tbody.innerHTML = "";

    // =================== Showing Predefined Items ===================
    const prePriceHTML = sessionStorage.getItem("price_details");
    if (prePriceHTML?.trim()) {
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = prePriceHTML;

        const rows = tempDiv.querySelectorAll(".storage-item-row");
        rows.forEach(row => {
            const leftText = row.querySelector("div span")?.textContent.trim();
            const priceText = row.querySelector("span[style*='min-width']")?.textContent.trim();

            if (!leftText || !priceText) return;

            const match = leftText.match(/^(\d+)\s*x\s*(.+)$/);
            if (!match) return;

            const quantity = match[1];
            const itemName = match[2];

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td><strong>${itemName}</strong></td>
                <td>${quantity}</td>
                <td>${priceText}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    // =================== Showing Custom Items ===================
    const customPriceHTML = sessionStorage.getItem("custom_items");
    if (customPriceHTML?.trim()) {
        try {
            const customItems = JSON.parse(customPriceHTML);
            if (Array.isArray(customItems) && customItems.length) {
                customItems.forEach(({ name, cubicFeet, price }) => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td><strong>${name}</strong></td>
                        <td>${cubicFeet} cu. ft.</td>
                        <td>€${price.toFixed(2)}/mo</td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        } catch (e) {
            console.error("Invalid JSON in custom_items", e);
        }
    }

    // =================== Showing Pickup Details ===================
    const pickupPriceHTML = sessionStorage.getItem("subtotal_pickup");
    if (pickupPriceHTML?.trim()) {
        const cleanedPickup = pickupPriceHTML.replace(/[^\d.-]/g, '');
        const pickupPrice = parseFloat(cleanedPickup);

        if (!isNaN(pickupPrice) && pickupPrice > 0) {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td><strong>Pickup (Scheduled Arrival)</strong></td>
                <td></td>
                <td>€${pickupPrice.toFixed(2)}</td>
            `;
            tbody.appendChild(tr);
        }
    }

    // =================== Showing Supply Details ===================
    const deliveryPriceHTML = sessionStorage.getItem("subtotal_delivery");
    if (deliveryPriceHTML?.trim()) {
        const cleanedPrice = deliveryPriceHTML.replace(/[^\d.-]/g, '');
        const deliveryPrice = parseFloat(cleanedPrice);

        if (!isNaN(deliveryPrice) && deliveryPrice > 0) {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td><strong>Supply (Scheduled Arrival)</strong></td>
                <td></td>
                <td>€${deliveryPrice.toFixed(2)}</td>
            `;
            tbody.appendChild(tr);
        }
    }

    // =================== Showing Disposal Details ===================
    const disposalPriceHTML = sessionStorage.getItem("disposal_price");
    if (disposalPriceHTML?.trim()) {
        const cleanedDisposal = disposalPriceHTML.replace(/[^\d.-]/g, '');
        const disposalPrice = parseFloat(cleanedDisposal);

        if (!isNaN(disposalPrice) && disposalPrice > 0) {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td><strong>Disposal Fee</strong></td>
                <td></td>
                <td>€${disposalPrice.toFixed(2)}</td>
            `;
            tbody.appendChild(tr);
        }
    }

    // =================== Showing Protection Plan ===================
    // const protectionPriceHTML = sessionStorage.getItem("protection_plan");
    // if (protectionPriceHTML?.trim()) {
    //     const cleanedProtection = protectionPriceHTML.replace(/[^\d.-]/g, '');
    //     const protectionPrice = parseFloat(cleanedProtection);

    //     let title = "";
    //     if (protectionPrice === 25) {
    //         title = "Protection Plan - Premium";
    //     } else if (protectionPrice === 15) {
    //         title = "Protection Plan - Standard";
    //     }

    //     if (title) {
    //         const tr = document.createElement("tr");
    //         tr.innerHTML = `
    //             <td><strong>${title}</strong></td>
    //             <td></td>
    //             <td>€${protectionPrice.toFixed(2)}/mo</td>
    //         `;
    //         tbody.appendChild(tr);
    //     }
    // }

    // =================== Showing Protection Plan ===================
    const protectionPlanData = sessionStorage.getItem("protection_plan");
    if (protectionPlanData) {
        try {
            const plan = JSON.parse(protectionPlanData);

            if (plan && plan.price > 0) {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td><strong>Protection Plan - ${plan.title}</strong></td>
                    <td></td>
                    <td>€${plan.price.toFixed(2)}/mo</td>
                `;
                tbody.appendChild(tr);
            }
        } catch (e) {
            console.error("Invalid protection plan JSON:", e);
        }
    }

}

// Update charges summary based on subtotal
function updateStyledChargesSummary() {
    let oneTimeSubtotal = 0;
    let monthlySubtotal = 0;

    // Helper: Safely parse numeric values from strings like "€25.00"
    const parseValue = val => parseFloat(val?.toString().replace(/[^\d.-]/g, '')) || 0;

    // One-Time Charges
    oneTimeSubtotal += parseValue(sessionStorage.getItem("subtotal_pickup"));
    oneTimeSubtotal += parseValue(sessionStorage.getItem("subtotal_delivery"));
    oneTimeSubtotal += parseValue(sessionStorage.getItem("disposal_price"));

    // Protection Plan (monthly)
    //monthlySubtotal += parseValue(sessionStorage.getItem("protection_plan"));
    const storedPlan = sessionStorage.getItem("protection_plan");
    if (storedPlan) {
        try {
            const plan = JSON.parse(storedPlan);
            if (plan && plan.price) {
                monthlySubtotal += parseFloat(plan.price);
            }
        } catch (e) {
            console.error("Invalid protection plan format:", e);
        }
    }

    // Predefined Monthly Items
    const predefinedHTML = sessionStorage.getItem("price_details");
    if (predefinedHTML?.trim()) {
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = predefinedHTML;

        const priceSpans = tempDiv.querySelectorAll("span[style*='min-width']");
        priceSpans.forEach(span => {
            const price = parseValue(span.textContent);
            if (price > 0) {
                monthlySubtotal += price;
            }
        });
    }

    // Custom Items
    const customItemsJSON = sessionStorage.getItem("custom_items");
    if (customItemsJSON?.trim()) {
        try {
            const customItems = JSON.parse(customItemsJSON);
            if (Array.isArray(customItems)) {
                customItems.forEach(item => {
                    if (!isNaN(item.price)) {
                        monthlySubtotal += parseFloat(item.price);
                    }
                });
            }
        } catch (err) {
            console.error("Invalid JSON in custom_items:", err);
        }
    }

    // HST Calculations
    const oneTimeHST = +(oneTimeSubtotal * 0.13).toFixed(2);
    const monthlyHST = +(monthlySubtotal * 0.13).toFixed(2);

    const oneTimeTotal = oneTimeSubtotal + oneTimeHST;
    const monthlyTotal = monthlySubtotal + monthlyHST;

    // DOM Updates
    document.getElementById("oneTimeSubtotal").innerText = `€${oneTimeSubtotal.toFixed(2)}`;
    document.getElementById("monthlySubtotal").innerText = `€${monthlySubtotal.toFixed(2)}`;
    document.getElementById("oneTimeHST").innerText = `€${oneTimeHST.toFixed(2)}`;
    document.getElementById("monthlyHST").innerText = `€${monthlyHST.toFixed(2)}`;
    document.getElementById("oneTimeTotal").innerText = `€${oneTimeTotal.toFixed(2)}`;
    document.getElementById("monthlyTotal").innerText = `€${monthlyTotal.toFixed(2)}`;

    // Store for later use (like payment processing)
    sessionStorage.setItem("hst", (oneTimeHST + monthlyHST).toFixed(2));
    sessionStorage.setItem("total_due", (oneTimeTotal + monthlyTotal).toFixed(2));
}


// ✅ Right-side panel render
function renderBookingDetailsRightSide() {
    const school = sessionStorage.getItem("school_name") || "Not selected";
    const address = sessionStorage.getItem("collection_address") || "No address saved";
    const supplyData = JSON.parse(sessionStorage.getItem("delivery_date") || "{}");
    const supplyDate = supplyData.date || "Not selected";
    const pickupData = JSON.parse(sessionStorage.getItem("pickup_date") || "{}");
    const pickupDate = pickupData.date || "Not selected";

    document.getElementById("school_info").innerText = school;
    document.getElementById("address_info").innerText = address;
    document.getElementById("supply_date_info").innerText = supplyDate;
    document.getElementById("pickup_date_info").innerText = pickupDate;
}

// Existing function calls
document.addEventListener("DOMContentLoaded", () => {
    loadPriceDetailsIntoTable();
    updateStyledChargesSummary();
    renderBookingDetailsRightSide(); // ✅ Right-side content rendering
});

// Validation for Email, Card, and Phone
document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("client_email");
    const cardInput = document.getElementById("client_card");
    const phoneInput = document.getElementById("client_phone");
    const submitButton = document.getElementById("submit_booking");
    const form = document.getElementById("checkout-form");

    function validateFields() {
        const email = emailInput.value.trim();
        const card = cardInput.value.trim();
        const phone = phoneInput.value.trim();

        const isEmailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        const isCardValid = card.length >= 12; // Simplified check
        const isPhoneValid = /^\+?[0-9\s\-()]{7,}$/.test(phone); // Basic phone number check

        submitButton.disabled = !(isEmailValid && isCardValid && isPhoneValid);
    }

    emailInput.addEventListener("input", validateFields);
    cardInput.addEventListener("input", validateFields);
    phoneInput.addEventListener("input", validateFields);

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const email = emailInput.value.trim();
        const card = cardInput.value.trim();
        const phone = phoneInput.value.trim();

        if (!email || !card || !phone) {
            alert("Please fill in all required fields.");
            return;
        }

        // Simulate form submission
        console.log("Booking submitted with:");
        console.log("Email:", email);
        console.log("Card:", card);
        console.log("Phone:", phone);

        alert("✅ Booking submitted successfully!");
    });
});

</script>

<!-- ✅ CSS -->
<style>
    #step-6 .pro_container{
       width: 145%; 
    }
    .checkout_wraper{
        width: 100%;
        display: flex;
        align-items: start;
        justify-content: space-between;
    }
    .pro_col_60{
        width: 60%;
    }
    .pro_col_40{
        width: 40%;
    }
/* Booking Summary Table */
.booking-summary-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-family: Arial, sans-serif;
}
.booking-summary-table th,
.booking-summary-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    text-align: left;
}

/* Charges Summary Layout */
.charges-section {
    display: flex;
    justify-content: space-between;
    gap: 40px;
    align-items: flex-start;
    margin-top: 40px;
    font-family: Arial, sans-serif;
}
.charges-note {
    flex: 1;
    display: flex;
    gap: 10px;
    font-size: 14px;
    line-height: 1.6;
}
.warning-icon {
    font-size: 20px;
    margin-top: 3px;
}
.charges-box {
    flex: 1;
    max-width: 400px;
}
.summary-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.summary-table th,
.summary-table td {
    text-align: right;
    padding: 10px;
    border-bottom: 1px solid #e0e0e0;
}
.summary-table th:first-child,
.summary-table td:first-child {
    text-align: left;
    font-weight: bold;
}
.summary-table .total-row td {
    font-weight: bold;
    border-top: 2px solid #ccc;
    background-color: #fafafa;
}
.delivery-note {
    font-size: 13px;
    color: #555;
    margin-top: 8px;
    text-align: right;
}

/* right side layout css */

.right-side-panel {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    font-family: Arial, sans-serif;
    margin-top: 40px;
    max-width: 450px;
    margin-left: auto;
    padding: 20px;
    background: #f8f8f8;
    border-radius: 8px;
}
.edit-link {
    font-size: 12px;
    color: #007bff;
    text-decoration: underline;
    cursor: pointer;
}
.payment-box {
    width: 100%;
    background: white;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
.payment-box h3 {
    margin-top: 0;
}
.payment-box input[type="email"],
.payment-box input[type="text"],
.payment-box input[type="tel"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.card-input {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.card-input input {
    flex: 1;
}
.autofill-btn {
    background: #e7f3ff;
    color: #007bff;
    border: none;
    padding: 6px 12px;
    margin-left: 10px;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
}
.secure-label {
    font-size: 13px;
    color: #555;
    display: flex;
    align-items: center;
    gap: 10px;
}
.secure-label img {
    height: 16px;
}
.stripe-icons img {
    height: 20px;
    margin-left: 5px;
}
.tos {
    font-size: 12px;
    color: #666;
    margin-top: 10px;
}
.tos a {
    color: #007bff;
    text-decoration: underline;
}
.submit-booking {
    width: 100%;
    padding: 12px;
    background: #ccc;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: not-allowed;
    margin-top: 15px;
}
.note {
    font-size: 13px;
    color: #333;
    text-align: center;
    margin-top: 8px;
}
.bottom-note-icons {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    margin-top: 20px;
    color: #333;
    gap: 15px;
}
.booking-info-box {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    max-width: 100%;
}
.booking-row {
    display: flex;
    justify-content: space-between;
    width: 48%; /* Adjust width as needed */
    margin-bottom: 10px;
}
.left-align {
    text-align: left;
}
.right-align {
    text-align: right;
    margin-left: auto; /* Push to the right */
}
@media (max-width: 768px) {
    #step-6 .pro_container{
       width: 100%;
       max-width: 100vw; 
    }
    .checkout_wraper{
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: start;
        justify-content: space-between;
    }
    .pro_col_60{
        width: 100%;
    }
    .pro_col_40{
        width: 100%;
    }
    .charges-section{
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }
    
    
}

.last_line {
    border-left: none;
    border-right: none;
}

#submit_booking {
    color: #000000 !important;
}

#submit_booking:hover {
    color: #FFFFFF !important;
}

</style>

