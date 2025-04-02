<!-- Sticky Footer -->
<div id="checkout-footer" class="pro_footer">
    <button id="continue-button" class="pro_button next-step">Continue</button>
</div>

<style>
    /* Sticky Footer */
    #checkout-footer {
        display: flex; /* Centers button horizontally */
        justify-content: center;
        align-items: center; /* Centers button vertically */
        padding: 15px;
        background-color: #f8f8f8;
        border-top: 1px solid #ddd;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 80px; /* Ensure enough space */
        transition: transform 0.5s ease-in-out;
        z-index: 1000; /* Keep footer above other elements */
        overflow: visible; /* Ensure button is not clipped */
    }

    /* Button Styles */
    .pro_button {
        background: #23aca5;
        border: none;
        color: white;
        padding: 5px 25px;
        font-size: 18px;
        cursor: pointer;
        border-radius: 5px;
        display: block; /* Ensure visibility */
        margin-top: 0 !important;
    }

    .pro_button:hover {
        background-color: #1d958f;
    }

    /* Hide Footer Initially */
    .hidden {
        transform: translateY(100%); /* Moves footer below screen */
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let lastScrollY = window.scrollY;
        const footer = document.getElementById("checkout-footer");

        window.addEventListener("scroll", function () {
            if (window.scrollY < lastScrollY) {
                // Scrolling Up → Show Footer
                footer.classList.remove("hidden");
            } else {
                // Scrolling Down → Hide Footer
                footer.classList.add("hidden");
            }
            lastScrollY = window.scrollY;
        });

        document.getElementById("continue-button").addEventListener("click", function () {
            alert("Continue button clicked!");
        });
    });

</script>
