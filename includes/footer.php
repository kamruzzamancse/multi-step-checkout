<div id="checkout-footer" class="pro_footer">
    <button id="continue-button" class="pro_button">Continue</button>
</div>

<style>
    #checkout-footer {
        text-align: center;
        padding: 15px;
        background-color: #f8f8f8;
        border-top: 1px solid #ddd;
    }
    .pro_button {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .pro_button:hover {
        background-color: #0056b3;
    }
</style>

<script>
    document.getElementById("continue-button").addEventListener("click", function() {
        alert("Continue button clicked!");
    });
</script>
