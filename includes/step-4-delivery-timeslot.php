<!-- Step 4: Supply Timeslot -->
<div class="step" id="step-4">
  <!-- Packing Materials Section -->
  <div class="packing-materials-section">
    <h3>Would you like packing materials?</h3>
    <p>We’ll send you enough to pack everything you want to store.</p>

    <div class="packing-options">
      <div class="packing-option selected" id="packing_yes">
        <p><strong>Yes please!</strong></p>
        <img src="http://localhost/leonardoemlh/wp-content/uploads/2025/04/packing-yes-1.png" alt="Packing Yes" />
      </div>

      <div class="packing-option" id="packing_no">
        <p><strong>No thanks</strong></p>
        <img src="http://localhost/leonardoemlh/wp-content/uploads/2025/04/packing-no-1.png" alt="Packing No" />
      </div>
    </div>
  </div>

  <!-- Hidden by default, controlled via JS -->
  <div id="supply_timeslot_section" style="display: block;">
    <h2>Supply Appointment</h2>
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
          <h6><b>Select an arrival window</b></h6>

          <div class="option_1" id="flexibleArrival_1" style="position: relative;">
            <strong>Flexible Arrival</strong>
            <span class="calendar-price-1">Free</span>
            <p>Receive a 3-hour arrival window the day before your appointment.
              The earliest possible arrival is at 7 AM and the latest possible arrival is at 3 PM.
            </p>
          </div>

          <div class="option_1" id="scheduledArrival_1" style="position: relative;">
            <strong>Scheduled Arrival</strong>
            <span class="calendar-price-1">$29</span>
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
</div>

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
      padding: 0;
  }

  .option_1 {
    position: relative; /* <-- Add this */
    border: 2px solid #ddd;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    cursor: pointer;
    text-align: left;
    transition: 0.3s;
}

.option_1:hover {
    border-color: #04a799;
}

.pro_selected {
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

/* ================= */
.pro_calendar { 
  width: fit-content;
  max-width: 350px;
  background-color: white;
  border: 1px solid #ddd;
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.2);
  font-family: sans-serif;
  overflow: hidden;
}

.pro_calendar_header {
  background: #23aca5;
  color: white;
  padding: 12px;
  text-align: center;
  font-size: 18px;
  font-weight: bold;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.pro_calendar_header button {
  background: #23aca5;
  color: #23aca5;
  color: #04a799;
  border: none;
  outline: none;
  padding: 5px 10px;
  font-size: 18px;
  border-radius: 6px;
  cursor: pointer;
}

.calendar-days, .calendar-dates {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  text-align: center;
  padding: 10px;
  gap: 5px;
}

.calendar-days div {
  font-weight: bold;
  color: #333;
}

.calendar-dates div {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
  cursor: pointer;
  color: gray;
}

.calendar-dates div.today {
  border: 2px solid #23aca5;
  font-weight: bold;
}

.calendar-dates div.selectable {
  background-color: #e0f7f5;
  font-weight: 600;
  outline: 1px solid #ddd;
}

.calendar-dates div.selectable:hover {
  background-color: #c8f0ea;
}

.calendar-dates div.selected {
  background-color: #23aca5;
  color: white;
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

@media (max-width: 768px) {
    .pro_delivery .pro_delivery_warper {
        flex-direction: column;
        gap: 20px;
    }
    .pro_Delivery_col {
        width: 100%;
    }
    .pro_col {
        width: 100%;
    }
}

/* style for Packing Materials Section*/
.packing-options {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.packing-option {
    width: 48%; /* Make each box take half the row */
    text-align: center;
    border: 2px solid #ddd;
    padding: 20px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    background-color: #fff;
    box-sizing: border-box; /* Ensure padding/borders don't overflow */
}

.packing-option.selected {
    background-color: #009a94;
    color: #fff;
    border-color: #007b76;
}

.packing-option.selected p {
    color: #fff;
}

.packing-option img {
    width: 80px;
    height: auto;
    margin-bottom: 10px;
}

.packing-option:hover {
    border-color: #04a799;
    transform: scale(1.02);
}

#supply_timeslot_section{
    margin-top: 25px;
}

@media (max-width: 600px) {
  .packing-option {
    width: 100%;
  }
}

</style>