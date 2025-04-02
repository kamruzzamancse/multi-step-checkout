<!-- Step 4: Supply Timeslot -->
<div class="step" id="step-4">
    <h2>Supply Timeslot</h2>
    <div class="pro_delivery">
        <div class="pro_delivery_warper">
            <div id="date_time_picker" class="pro_Delivery_col">
                <label for="supply_timeslot">Select a Supply Date:</label>
                <input type="text" id="supply_timeslot" name="supply_timeslot" readonly>
                <div class="prev_next_button">
                    <button class="next-step">Continue</button>
                </div> 
            </div>
            
            <div id="arrival_window" class="pro_col">
        
                <h6>Select an arrival window</h6>
        
                <!-- *****an conflict would be happening here, so I will just comment it out***** -->
                <div class="option" id="flexibleArrival">
                    <strong>Flexible Arrival</strong> <span class="calendar-price-1">Free</span>
                    <p>Receive a 3-hour arrival window the day before your appointment.
                    The earliest possible arrival is at 7 AM and the latest possible arrival is at 3 PM.</p>
                </div>
        
                <div class="option" id="scheduledArrival">
                    <strong>Scheduled Arrival</strong> <span class="calendar-price-1">$29</span>
                    <p>Select a set arrival window. Limited availability.</p>
                </div>
        
                <div class="time-slots-1" id="timeSlots_1">
                    <div class="time-slot-1" data-time="07:00-08:00">07:00-08:00</div>
                    <div class="time-slot-1" data-time="08:00-09:00">08:00-09:00</div>
                    <div class="time-slot-1" data-time="09:00-10:00">09:00-10:00</div>
                    <div class="time-slot-1" data-time="10:00-11:00">10:00-11:00</div>
                    <div class="time-slot-1" data-time="11:00-12:00">11:00-12:00</div>
                    <div class="time-slot-1" data-time="12:00-01:00">12:00-01:00</div>
                    <div class="time-slot-1" data-time="01:00-02:00">01:00-02:00</div>
                    <div class="time-slot-1" data-time="02:00-03:00">02:00-03:00</div>
                </div>
        
            </div>
            
        </div>
    </div>
</div>

<script>
    document.getElementById("flexibleArrival_1").addEventListener("click", function() {
        document.getElementById("timeSlots_1").style.display = "none";
        this.classList.add("selected");
        document.getElementById("scheduledArrival_1").classList.remove("selected");
    });

    document.getElementById("scheduledArrival_1").addEventListener("click", function() {
        document.getElementById("timeSlots_1").style.display = "block";
        this.classList.add("selected");
        document.getElementById("flexibleArrival_1").classList.remove("selected");
    });
</script>

<style>
    .pro_delivery{
        width:100%;
        padding: 0;
    }
    .pro_delivery_warper{
        width: 100%;
        display: flex;
        gap: 30px;
    }
    .pro_Delivery_col{
        width: 50%;
    }

.option_1 {
    border: 2px solid #ddd;
    padding: 15px 15px 0px 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    cursor: pointer;
    text-align: left;
    transition: 0.3s;
}

.option_1:hover {
    border-color: #04a799;
}

.selected {
    border-color: #04a799;
    background-color: #e6f9f9;
}

.time-slots-1 {
    display: none;
    margin-top: 15px;
}

.time-slot-1 {
    display: inline-block;
    background: #04a799;
    color: #fff;
    padding: 10px;
    margin: 5px;
    border-radius: 5px;
    cursor: pointer;
}

.time-slot-1:hover {
    background: #005f5f;
}

.time-slot-1.selected {
    background-color: #007bff;
    color: #fff;
    border-color: #0056b3;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
}

.calendar-price-1 {
    position: absolute;
    top: 10px;
    right: 15px;
    font-weight: bold;
    color: #04a799;
    font-size: 16px;
}

#pickup_date {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

#pickup_date span:first-child {
    flex-grow: 1;
}

</style>
