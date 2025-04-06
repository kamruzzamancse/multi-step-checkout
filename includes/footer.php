<!-- Sticky Footer -->
<div id="checkout-footer" class="pro_footer">
    <span id="pro_footer_price"><b>999$</b></span>
    <button id="continue-button" class="pro_button next-step">Continue</button>
    <!-- ====arrow icon==== -->
    <div id="pro_pullDown_arrow">
        <svg id="pro_pullDown_arrow_down" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
        <svg id="pro_pullDown_arrow_Up" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M480-528 296-344l-56-56 240-240 240 240-56 56-184-184Z"/></svg>
    </div>
    <!-- =======hidden pull down===== -->
     <div id="pro_pullDown_window" >
        <!-- ====footer_price_summary==== -->
         <div class="footer_price_summary_wrapper">
             <div id="footer_price_summary">
                 <?php include( plugin_dir_path(__FILE__) . 'price-summary.php'); ?>
             </div>
         </div>
     </div>
</div>

<style>
    /* Sticky Footer */
    #checkout-footer {
        display: flex; /* Centers button horizontally */
        justify-content: space-between;
        align-items: center; /* Centers button vertically */
        padding: 15px;
        background-color: #1d958f;
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
    .pro_button.active{
        background-color: #1d958f;
    }
    #pro_pullDown_arrow{
        width: fit-content;
        padding: 5px 30px;
        background-color: #1d958f;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: -15px;
        left: 50%;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        transform: translateX(-50%);
        z-index: 9991;
    }
    #pro_pullDown_arrow.active_btn{
        background-color: #00776d5e;
    }
    #pro_pullDown_arrow_down{
        display: none;
    }
    #pro_pullDown_arrow_Up{
        display: block;
    }
    #pro_pullDown_window{
        width: 100%;
        height: 100%;
        min-height: 100vh;
        background-color: #1d958f;
        position: absolute;
        bottom: 79px !important;
        left: 0;
        z-index: 9990;
        /* display: none;  */
        transform: translateY(130%);
        transition: transform 0.3s ease-in-out;
        z-index: -1;
    }
    .footer_price_summary_wrapper{
        width: 100%;
        height: 100%;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .footer_price_summary_wrapper #footer_price_summary{
        width: fit-content;
        max-width: 320px;
        height: calc(100vh - 80px);
        overflow-y: scroll;
    }
    .pro-pulldown-window_active {
         transform: translateY(0%) !important;
         z-index: 9990 !important;
    }

    @media(min-width: 1024px) {
        #checkout-footer {
            display: none;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let lastScrollY = window.scrollY;
        const footer = document.getElementById("checkout-footer");
        let pro_pullDown_window = document.getElementById("pro_pullDown_window");

        // window.addEventListener("scroll", function () {
        //     if (window.scrollY < lastScrollY) {
                
        //         footer.classList.remove("hidden");
        //     } else {
               
        //         footer.classList.add("hidden");
        //     }
        //     lastScrollY = window.scrollY;
        // });

        document.getElementById("continue-button").addEventListener("click", function () {
            alert("Continue button clicked!");
        });
        // Add event listener to the arrow to toggle its visibility
        document.getElementById("pro_pullDown_arrow").addEventListener("click", function () {

            const arrowDown = document.getElementById("pro_pullDown_arrow_down");
            const arrowUp = document.getElementById("pro_pullDown_arrow_Up");
            document.getElementById("pro_pullDown_arrow").classList.toggle("active_btn");
            // Toggle the visibility of the arrows
            const isArrowUpVisible = window.getComputedStyle(arrowUp).display !== "none";
            if (isArrowUpVisible) {
                arrowDown.style.display = "block";
                arrowUp.style.display = "none";
            } else {
                arrowDown.style.display = "none";
                arrowUp.style.display = "block";
            }
            // Toggle the visibility of the pull-down window
            pro_pullDown_window.classList.toggle("pro-pulldown-window_active");

        });
    });

</script>
