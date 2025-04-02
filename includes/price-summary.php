<div class="price-summary" class="position-absolute top-0 end-0">
    <h3>Due now - upfront payment</h3>
    <!-- =====storage per month===== -->
    <div class="storagePerMonth">
        <div class="categoryHeading mt-2">
            <h5 class="categoryName">Storage per month:</h5>
            <!-- <span class="remo"><b><u>Remove</u></b></span> -->
        </div>
        <!-- <div class="storageDetails mt-3 mb-2">
            <div class="perProduct">
                <div class="countProduct d-flex">
                    <span class="productQuantity">10</span>	<span>&nbsp;</span>
                    <span>X</span> 	
                    <span>&nbsp;</span>
                    <span class="productName">Product name</span>
                </div>
                <span>$<b>242</b></span>
            </div>
            <div class="productPriceWarper">
                <span>$</span><span class="actualprice">21.50</span> <span>Pre box</span>
            </div>
        </div> -->
    </div>
    <!-- ====collection=== -->
    <div class="collectionSetails"></div>
    <!-- =====pickup==== -->
     <div class="pickupDetails"></div>
    <!-- ===delivery== -->
     <div class="deliveryDetails"></div>
     <!-- ===protection Plan==== -->
      <div class="protectionDetails"></div>


    <!-- $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->
    <p id="price_details"></p>    
    <p id="collection_label"><strong>Collection Address:</strong></p>
    <p id="collection_address" style="display: none;"></p>
    <p id="pickup_label" style="display: none;"><strong>Pickup Date:</strong></p>
    <p id="pickup_date" style="display: none;"></p>

    <p id="delivery_label" style="display: none;"><strong>Delivery Date:</strong></p>
    <p id="delivery_date" style="display: none;"></p>

    <!-- Protection Plan -->
    <p id="protection_label" style="display: none;"><strong>Protection Plan:</strong> <span id="protection_title"></span> - <span id="protection_price">£0.00</span></p>
    <!-- ==sub total== -->
    <div class="Sub_total">
        <p><strong>Subtotal:</strong> <span id="subtotal">£0.00</span></p>
    </div>
    <!-- ===total due=== -->
    <div class="totalDue">
        <p><strong>Total due today:</strong> <span id="total_due">£0.00</span></p>
    </div>
    <p>
    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#1f1f1f"><path d="M480-344 240-584l47.33-47.33L480-438.67l192.67-192.66L720-584 480-344Z"/></svg> Return charges apply
    </p>
    <br>
    <p>
        Delivery fees are charged when you order your suff back, <a href="#" class="findOutMoreLink">find out more here</a>
    </p>

    <div class="footNote">
        <p>
            FREE to cancel or amend your order if you let us know before 11 am one working day prior to your collection or delivery.
        </p>
    </div>

    <!-- $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->
</div>

<style>
    
    .price-summary{
        width: 100%;
        max-width: 400px;
        position: sticky;
        top: 145px;
        left: 0;
        padding:20px 10px;
        margin:0;
    }
    .storagePerMonth{
        width: 100%;
        padding: 5px 0;
    }
    .categoryHeading{
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .categoryName{
        font-size: 16px;
        font-weight: 700;
    }
    .storageDetails{
        width: 100%;
        height: 80px;
    }
    .storageDetails p{
        font-size: 16px;
    }
    /* .countProduct{
        height: fit-content;
        margin: 0 !important;
        padding: 0;
    } */
    .perProduct{
        width: 100%;
        display: flex;
        justify-content: space-between;
        font-weight: 500;
    }
    .productPriceWarper{
        width: 100%;
        display: flex;
    }
    .Sub_total{
        width: 100%;
        padding: 5px 0;
        border: none;
        border-top: 2px solid black;
        border-bottom: 2px solid black;
    }
    .totalDue{
        width: 100%;
        padding: 5px 0;
        margin-top: 15px;
        border: none;
        border-top: 3px solid black;
        border-bottom: 3px solid black;
    }
    .footNote{
        width: 100%;
        padding: 10px;
        background-color: #00a89a48;
        border-radius: 3px;
        margin-top: 15px;
    }
</style>
