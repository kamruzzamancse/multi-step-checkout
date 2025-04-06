<!-- Step 4: Supply Timeslot -->
<div class="step" id="step-4">
    <h2>Supply Timeslot</h2>
    <div class="pro_delivery">
        <div class="pro_delivery_warper">
            <div id="date_time_picker" class="pro_Delivery_col">
                <!-- <label for="supply_timeslot">Select a Supply Date:</label>
                <input type="text" id="supply_timeslot" name="supply_timeslot" readonly> -->
                
                <div class="pro_calendar">
                    <div class="pro_calendar_header">
                        <button id="prev-month">&lt;</button>
                        <span id="month-year"></span>
                        <button id="next-month">&gt;</button>
                    </div>
                    <div class="calendar-days">
                        <div>Sun</div><div>Mon</div><div>Tue</div>
                        <div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                    </div>
                    <div class="calendar-dates" id="calendar-dates"></div>
                </div>

                <div class="prev_next_button">
                    <button class="next-step">Continue</button>
                </div> 

            </div>
            
            <div id="arrival_window" class="pro_col">
        
                <h6><b>Select an arrival window</b></h6>
        
                <!-- *****an conflict would be happening here, so I will just comment it out***** -->
                <div class="option" id="flexibleArrival flexibleArrival_1">
                    <strong>Flexible Arrival</strong> <span class="calendar-price-1">Free</span>
                    <p>Receive a 3-hour arrival window the day before your appointment.
                    The earliest possible arrival is at 7 AM and the latest possible arrival is at 3 PM.</p>
                </div>
        
                <div class="option" id="scheduledArrival_1">
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
        this.classList.add("pro_selected"); // Fixed class name
        document.getElementById("scheduledArrival_1").classList.remove("pro_selected");
    });

    document.getElementById("scheduledArrival_1").addEventListener("click", function() {
        document.getElementById("timeSlots_1").style.display = "block";
        this.classList.add("pro_selected"); // Fixed class name
        document.getElementById("flexibleArrival_1").classList.remove("pro_selected");
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
        padding: 0;
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
  width: 100%;
  max-width: 100%;
  background-color: white;
  border: 1px solid #ddd;
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.2);
  font-family: sans-serif;
  overflow: hidden;
}

.pro_calendar_header {
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
  background: #fff;
  color: #04a799 !important;
  border: none !important;
  outline: none !important;
  padding: 5px 10px;
  font-size: 18px;
  border-radius: 6px;
  cursor: pointer;
}
#month-year{color: #04a799;}

.calendar-days, .calendar-dates {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  text-align: center;
  padding: 10px;
  gap: 5px;
}
.calendar-days{padding-bottom: 0;}

.calendar-days div {
  width: 100%;
  font-weight: 400;
  color: gray;
  border: 1px solid #ddd;
  padding: 5px 2px;
  border-radius: 3px;
}
.calendar-dates {
  padding-top: 5px;
}
.calendar-dates div {
  padding: 6px 10px;
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


</style>

<script>

const calendarDates = document.getElementById('calendar-dates');
const monthYear = document.getElementById('month-year');
const prevMonthBtn = document.getElementById('prev-month');
const nextMonthBtn = document.getElementById('next-month');

let viewDate = new Date(); // Date we are currently viewing
const today = new Date();

function getSelectableDays(year, month) {
  // Customize logic per month/year if needed
  return [9, 10, 11, 16, 17,18, today.getDate()];
}

function renderFixedCalendar() {
  const year = viewDate.getFullYear();
  const month = viewDate.getMonth();
  const firstDay = new Date(year, month, 1).getDay();
  const lastDate = new Date(year, month + 1, 0).getDate();
  const selectableDays = getSelectableDays(year, month);

  monthYear.textContent = `${viewDate.toLocaleString('default', { month: 'long' })} ${year}`;
  calendarDates.innerHTML = '';

  for (let i = 0; i < firstDay; i++) {
    calendarDates.innerHTML += `<div></div>`;
  }

  for (let i = 1; i <= lastDate; i++) {
    const isToday =
      i === today.getDate() &&
      month === today.getMonth() &&
      year === today.getFullYear();

    const isSelectable = selectableDays.includes(i);
    const isSelected = isToday && isSelectable;

    calendarDates.innerHTML += `
      <div class="
        ${isToday ? 'today' : ''}
        ${isSelectable ? 'selectable' : ''}
        ${isSelected ? 'selected' : ''}
      " data-day="${i}">
        ${i}
      </div>`;
  }

  document.querySelectorAll('.calendar-dates div.selectable').forEach(day => {
    day.addEventListener('click', () => {
      day.classList.toggle('selected');
    });
  });
}

prevMonthBtn.addEventListener('click', () => {
  viewDate.setMonth(viewDate.getMonth() - 1);
  renderFixedCalendar();
});

nextMonthBtn.addEventListener('click', () => {
  viewDate.setMonth(viewDate.getMonth() + 1);
  renderFixedCalendar();
});

renderFixedCalendar();
document.querySelectorAll('.calendar-dates div.selectable').forEach(day => {
  day.addEventListener('click', () => {
    // Remove .selected from all
    console.log(day);
    
    document.querySelectorAll('.calendar-dates .selected').forEach(el => {
      el.classList.remove('selected');
    });

    // Add to the clicked one
    day.classList.add('selected');

    // Get the date
    const selectedDay = parseInt(day.getAttribute('data-day'));
    const selectedDate = new Date(viewDate.getFullYear(), viewDate.getMonth(), selectedDay);

    console.log("Selected Date:", selectedDate.toDateString());
  });
});


</script>
