<!-- Step 6: Checkout -->

<div class="step" id="step-6">
    <div class="container">
        <div class="row">
            <div class="col-md-7 left-section">
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
                                    <td id="oneTimeSubtotal">£0.00</td>
                                    <td id="monthlySubtotal">£0.00</td>
                                </tr>
                                <tr>
                                    <td>HST</td>
                                    <td id="oneTimeHST">£0.00</td>
                                    <td id="monthlyHST">£0.00</td>
                                </tr>
                                <tr class="total-row">
                                    <td><strong>Total</strong></td>
                                    <td id="oneTimeTotal"><strong>£0.00</strong></td>
                                    <td id="monthlyTotal"><strong>£0.00</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="delivery-note">Delivery Fee applies at delivery <span title="This will be added later.">❔</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-5 right-section">
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
                            <input type="email" required>

                            <label>Card number</label>
                            <div class="card-input">
                                <input type="text" placeholder="Card number" required>
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

                            <button type="submit" class="submit-booking" disabled>Submit Booking</button>
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

// Load and render booking table
function loadPriceDetailsIntoTable() {
    const priceHTML = sessionStorage.getItem("price_details");
    const tbody = document.getElementById("price_table_body");
    tbody.innerHTML = "";

    if (!priceHTML) {
        console.warn("⚠️ No sessionStorage 'price_details' found.");
        tbody.innerHTML = `<tr><td colspan="3" style="padding: 12px;">No items in your booking.</td></tr>`;
        return;
    }

    const lines = priceHTML.split("<br>").filter(line => line.trim() !== "");

    lines.forEach(line => {
        const match = line.match(/(\d+)\s*x\s*(.*?)\s*=\s*[£$]?([\d.]+)/);
        if (match) {
            const quantity = match[1];
            const name = match[2].trim();
            const price = match[3];
            const isStorageBox = name.toLowerCase().includes("storagehotel large box");

            const row = `
                <tr style="border-bottom: 1px solid #eee; vertical-align: top;">
                    <td style="padding: 12px;">
                        <strong>${name}</strong><br>
                        ${isStorageBox
                            ? `<span style="color: green;">First 2 Months FREE for 1 Storagehotel Large Box</span><br>
                               <small>4-month minimum required</small>` : ""
                        }
                    </td>
                    <td style="padding: 12px;">${quantity}</td>
                    <td style="padding: 12px;">£${price}</td>
                </tr>
            `;
            tbody.innerHTML += row;
        }
    });
}

// Update charges summary based on subtotal
function updateStyledChargesSummary() {
    const subtotalStr = sessionStorage.getItem("subtotal");
    const subtotal = parseFloat(subtotalStr) || 0;

    const oneTimeSubtotal = subtotal * 0.3;
    const monthlySubtotal = subtotal * 0.7;

    const oneTimeHST = +(oneTimeSubtotal * 0.13).toFixed(2);
    const monthlyHST = +(monthlySubtotal * 0.13).toFixed(2);

    const oneTimeTotal = oneTimeSubtotal + oneTimeHST;
    const monthlyTotal = monthlySubtotal + monthlyHST;

    document.getElementById("oneTimeSubtotal").innerText = `£${oneTimeSubtotal.toFixed(2)}`;
    document.getElementById("monthlySubtotal").innerText = `£${monthlySubtotal.toFixed(2)}`;
    document.getElementById("oneTimeHST").innerText = `£${oneTimeHST.toFixed(2)}`;
    document.getElementById("monthlyHST").innerText = `£${monthlyHST.toFixed(2)}`;
    document.getElementById("oneTimeTotal").innerText = `£${oneTimeTotal.toFixed(2)}`;
    document.getElementById("monthlyTotal").innerText = `£${monthlyTotal.toFixed(2)}`;

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

</script>

<!-- ✅ CSS -->
<style>
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
.payment-box input[type="text"] {
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

</style>

<!-- <button onclick="resetBooking()">Reset Booking</button>

<script>
function resetBooking() {
    sessionStorage.clear();
    alert("Session cleared. Booking reset.");
    location.reload(); // Optional: reload to reflect changes
}
</script> -->
