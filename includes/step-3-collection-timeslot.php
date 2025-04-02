<!-- Step 3: Collection Timeslot -->
<div class="step" id="step-3">
    <h2>Pickup Timeslot</h2>
    <div class="pro_pickup">
        <div class=" pro_picup_warper">
            <div id="date_time_picker" class="pro_picup_col">
                <label for="collection_timeslot">Select a Collection Date:</label>
                <input type="text" id="collection_timeslot" name="collection_timeslot" readonly>
                
                <div class="prev_next_button">
                    <button class="prev-step">Previous</button>
                    <button class="next-step">Next</button>
                </div> 
            </div>
            
            <div id="arrival_window" class="pro_col">
                <h6>Select an arrival window</h6>
        
                <div class="option" id="flexibleArrival">
                    <strong>Flexible Arrival</strong> <span class="calendar-price">Free</span>
                    <p>Receive a 3-hour arrival window the day before your appointment.
                    The earliest possible arrival is at 7 AM and the latest possible arrival is at 3 PM.</p>
                </div>
        
                <div class="option" id="scheduledArrival">
                    <strong>Scheduled Arrival</strong> <span class="calendar-price">$29</span>
                    <p>Select a set arrival window. Limited availability.</p>
                </div>
        
                <div class="time-slots" id="timeSlots">
                    <div class="time-slot" data-time="07:00-08:00">07:00-08:00</div>
                    <div class="time-slot" data-time="08:00-09:00">08:00-09:00</div>
                    <div class="time-slot" data-time="09:00-10:00">09:00-10:00</div>
                    <div class="time-slot" data-time="10:00-11:00">10:00-11:00</div>
                    <div class="time-slot" data-time="11:00-12:00">11:00-12:00</div>
                    <div class="time-slot" data-time="12:00-01:00">12:00-01:00</div>
                    <div class="time-slot" data-time="01:00-02:00">01:00-02:00</div>
                    <div class="time-slot" data-time="02:00-03:00">02:00-03:00</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("flexibleArrival").addEventListener("click", function() {
        document.getElementById("timeSlots").style.display = "none";
        this.classList.add("selected");
        document.getElementById("scheduledArrival").classList.remove("selected");
    });

    document.getElementById("scheduledArrival").addEventListener("click", function() {
        document.getElementById("timeSlots").style.display = "block";
        this.classList.add("selected");
        document.getElementById("flexibleArrival").classList.remove("selected");
    });
</script>

<style>
    .pro_pickup{
        width: 100%;
        padding: 0;
    }
    .pro_pickup .pro_picup_warper{
        width: 100%;
        display: flex;
        gap:30px;
    }
/* Calendar Container */
.ui-datepicker {
    background: #ffffff;
    border: none;
    padding: 10px;
    font-size: 16px;
    width: auto !important; 
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    position: relative;
    border-radius: 10px;
}

/* Header (Month & Year) */
.ui-datepicker-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    background: none;
    border: none;
    position: relative;
}

/* Title (Centered Month & Year) */
.ui-datepicker-title {
    flex-grow: 1;
    text-align: center;
    font-size: 22px;
    font-weight: bold;
    color: #29a399;
    text-transform: capitalize;
    position: relative;
}

/* Navigation Arrows */
.ui-datepicker-prev,
.ui-datepicker-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 22px;
    font-weight: bold;
    color: #29a399;
}

/* Left Arrow (Previous) */
.ui-datepicker-prev {
    left: 10px;
}

/* Right Arrow (Next) */
.ui-datepicker-next {
    right: 10px;
}

/* Navigation Arrows */
.ui-datepicker-prev,
.ui-datepicker-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 22px;
    font-weight: bold;
    color: #29a399;
    z-index: 10;  /* Ensures it's above other elements */
    pointer-events: auto;  /* Ensures click is detected */
}

/* Left Arrow (Previous) */
.ui-datepicker-prev {
    left: 10px;
}

/* Right Arrow (Next) */
.ui-datepicker-next {
    right: 10px;
}

/* Ensure no unwanted text is displayed */
.ui-datepicker-prev span,
.ui-datepicker-next span {
    display: none;
}

/* Arrow Symbols */
.ui-datepicker-prev::before {
    content: "❮"; /* Unicode for left arrow */
    font-size: 22px;
}

.ui-datepicker-next::before {
    content: "❯"; /* Unicode for right arrow */
    font-size: 22px;
}

/* Hover Effect for Arrows */
.ui-datepicker-prev:hover,
.ui-datepicker-next:hover {
    color: #1d7a74;
}

/* Calendar Table */
.ui-datepicker-calendar {
    width: 100%;
    border-spacing: 5px;
    text-align: center;
}

/* Table Header (Days of the Week) */
.ui-datepicker-calendar th {
    font-size: 16px;
    color: #555;
    padding: 10px;
    font-weight: bold;
    text-transform: uppercase;
}

/* Date Cells */
.ui-datepicker-calendar td {
    text-align: center;
    vertical-align: middle;
    height: 50px; 
    width: 50px; 
    font-size: 16px;
    border-radius: 8px;
    background: #f7f7f7;
    border: 1px solid transparent;
    transition: all 0.3s ease;
    position: relative;
}

/* Hover Effect for Dates */
.ui-datepicker-calendar td:hover {
    background: #e0f2f1 !important;
    cursor: pointer;
}

/* Selected Date */
.ui-state-active {
    background: #29a399 !important;
    color: white !important;
    font-weight: bold;
    border-radius: 8px;
}

/* Unavailable Dates */
.ui-state-disabled {
    background: #e0e0e0 !important;
    color: #bdbdbd !important;
    cursor: not-allowed;
}

/* Price Labels */
.price-label {
    display: block;
    font-size: 12px;
    color: #777;
    margin-top: 4px;
}

/* Styling for "FREE" and Prices */
.price-label:contains("FREE") {
    color: #29a399;
    font-weight: bold;
}

.price-label:not(:contains("FREE")) {
    color: #333;
}


</style>

<style>
.option {
    position: relative;
    border: 2px solid #ddd;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    cursor: pointer;
    text-align: left;
    transition: 0.3s;
}

.option:hover {
    border-color: #04a799;
}

.selected {
    border-color: #04a799;
    background-color: #e6f9f9;
}

.calendar-price {
    position: absolute;
    top: 10px;
    right: 15px;
    font-weight: bold;
    color: #04a799;
    font-size: 16px;
}

.time-slots {
    display: none;
    margin-top: 15px;
}

.time-slot {
    display: inline-block;
    background: #04a799;
    color: #fff;
    padding: 10px;
    margin: 5px;
    border-radius: 5px;
    cursor: pointer;
}

.time-slot:hover {
    background: #005f5f;
}

.time-slot.selected {
    background-color: #007bff;
    color: #fff;
    border-color: #0056b3;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
}

</style>
