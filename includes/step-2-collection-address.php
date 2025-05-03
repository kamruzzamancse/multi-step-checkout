<!-- Step 2: Collection Address -->
<div class="step" id="step-2">
    <div class="pro_row">
        <div class="pro_col">
            <img src="https://cdn-icons-png.flaticon.com/512/4797/4797387.png" alt="png" width="70">
            <h3 class="mt-2 mb-3">Address & Details</h3>
            <h6><b>Tell us where to collect your stuff from</b></h6>
        </div>
    </div>

    <div class="pro_col p-0">
        <div id="pro_address_form" class="pro_form">

            <!-- Address Autocomplete Field -->
            <div class="pro_Row" id="searchBox">
                <div class="pro_col">
                    <input type="text" id="searchInput" class="form-control address-search" placeholder="Start typing and select your address">
                </div>
            </div>

            <!-- Hidden Fields (Address Details) -->
            <div id="hiddenField" class="hidden mt-3">
                <form class="pro_Form_hidden pro_Row">
                    <div class="pro_Row">
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label filled" for="first_name">First name *</label>
                                <input class="form-control" type="text" id="first_name" required>
                            </div>
                        </div>
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label filled" for="last_name">Last name *</label>
                                <input class="form-control" type="text" id="last_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="pro_Row">
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label filled" for="building_name">Building number/name *</label>
                                <input class="form-control" type="text" id="building_name" required>
                            </div>
                        </div>
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label filled" for="address_line1">Address line 1 *</label>
                                <input class="form-control" type="text" id="address_line1" required>
                            </div>
                        </div>
                    </div>

                    <div class="pro_Row">
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label filled" for="address_line2">Address line 2</label>
                                <input class="form-control" type="text" id="address_line2">
                            </div>
                        </div>
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label filled" for="town">Town *</label>
                                <input class="form-control" type="text" id="town" required>
                            </div>
                        </div>
                    </div>

                    <div class="pro_Row">
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label filled" for="postcode">Postcode *</label>
                                <input class="form-control" type="text" id="postcode" required>
                            </div>
                        </div>
                    </div>

                    <div class="pro_Row">
                        <div class="pro_col">
                            <div class="inline-label ls-textarea">
                                <textarea class="form-control" placeholder="Special instructions" rows="2" id="special_instructions"></textarea>
                            </div>
                        </div>
                    </div>

                    <div>
                        <span>Please enter special instructions here. Our drivers cannot always contact you by telephone on arrival so make sure that your door bell is working, that any reception point is informed, and that someone is able to meet the driver at the ground floor of the given address.</span>
                    </div>
                </form>
            </div>

            <!-- Google Map -->
            <div id="map" style="height: 300px; margin-top: 15px; display: none;"></div>

            <div class="row text-start mt-3">
                <span id="enterManually" style="cursor:pointer; color:blue;"><em>Or enter manually</em></span>
            </div>
        </div>

        <button class="next-step">Continue</button>
    </div>
</div>

<script>
    // ================== AUTO-UPDATE LABEL STATE FOR INPUT FIELDS ==================
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".pro_inputBox input").forEach((input) => {
            let label = input.closest(".pro_inputBox")?.querySelector("label");

            if (!label) return;

            // Initialize the label state
            if (input.value.trim()) label.classList.add("filled");

            // Add event listeners for focus, click, and blur
            input.addEventListener("focus", () => label.classList.add("filled"));
            input.addEventListener("click", () => label.classList.add("filled"));
            input.addEventListener("blur", () => {
                if (!input.value.trim()) label.classList.remove("filled");
            });
        });
    });
</script>

<script>
    let autocomplete;
    let map;
    let marker;

    function initMap() {
        const input = document.getElementById("searchInput");

        autocomplete = new google.maps.places.Autocomplete(input, {
            types: ["geocode"],
            componentRestrictions: { country: "ca" },
            fields: ["address_components", "geometry", "formatted_address"]
        });

        autocomplete.addListener("place_changed", fillInAddress);

        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 51.509865, lng: -0.118092 },
            zoom: 12,
            mapTypeControl: false // Hide map/satellite toggle
        });

        marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });
    }

    function fillInAddress() {
        const place = autocomplete.getPlace();
        if (!place.geometry) return;

        map.setCenter(place.geometry.location);
        map.setZoom(15);

        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        // Show map
        document.getElementById("map").style.display = "block";

        const components = place.address_components;

        const getComponent = (type) => {
            const comp = components.find(c => c.types.includes(type));
            return comp ? comp.long_name : '';
        };

        const buildingNumber = getComponent("street_number");
        const route = getComponent("route");
        const sublocality = getComponent("sublocality") || getComponent("sublocality_level_1");
        const locality = getComponent("locality") || getComponent("postal_town");
        const postalCode = getComponent("postal_code");

        // Set values
        document.getElementById("building_name").value = buildingNumber;
        document.getElementById("address_line1").value = route;
        document.getElementById("address_line2").value = sublocality;
        document.getElementById("town").value = locality;
        document.getElementById("postcode").value = postalCode;

        document.getElementById("hiddenField").classList.remove("hidden");

    }

    window.initMap = initMap;
</script>

<script>
    const rawAddress = sessionStorage.getItem("collection_address_checkout");
    const specialInstructions = sessionStorage.getItem("special_instructions");

    if (rawAddress) {
        try {
            const addressData = JSON.parse(rawAddress);
            const fields = {
                first_name: 'first_name',
                last_name: 'last_name',
                building_name: 'building_name',
                address_line1: 'address_line1',
                address_line2: 'address_line2',
                town: 'town',
                postcode: 'postcode'
            };

            // Populate standard address fields
            for (const key in fields) {
                const el = document.getElementById(fields[key]);
                if (el && addressData[key]) {
                    el.value = addressData[key];
                }
            }

            // Set special instructions if available
            if (specialInstructions) {
                const specialEl = document.getElementById('special_instructions');
                if (specialEl) {
                    specialEl.value = specialInstructions;
                }
            }

            // Show the hidden form
            document.getElementById("hiddenField").classList.remove("hidden");
            document.getElementById("enterManually").classList.add("hidden");

        } catch (e) {
            console.error("Error parsing collection_address_checkout:", e);
        }
    }

    // Manual entry fallback
    document.getElementById("enterManually").addEventListener("click", (event) => {
        document.getElementById("hiddenField").classList.remove("hidden");
        event.target.classList.add("hidden");
    });
</script>

<script>
    document.getElementById("enterManually").addEventListener("click", (event) => {
        document.querySelector("#hiddenField").classList.remove("hidden");
        event.target.classList.add("hidden");
    });
</script>

<script>

    document.querySelectorAll("#step-2 input, #special_instructions").forEach(input => {
        input.addEventListener("input", saveAddressToSession);
    });

    function restoreAddressFromSession() {
        const saved = sessionStorage.getItem("collection_address_checkout");
        if (!saved) return;

        const data = JSON.parse(saved);

        document.getElementById("first_name").value = data.first_name || "";
        document.getElementById("last_name").value = data.last_name || "";
        document.getElementById("building_name").value = data.building_name || "";
        document.getElementById("address_line1").value = data.address_line1 || "";
        document.getElementById("address_line2").value = data.address_line2 || "";
        document.getElementById("town").value = data.town || "";
        document.getElementById("postcode").value = data.postcode || "";
    }

    document.addEventListener("DOMContentLoaded", function () {
        restoreAddressFromSession(); // Load saved address values on refresh
    });

    document.getElementById("special_instructions").value = sessionStorage.getItem("special_instructions") || "";
    document.getElementById("special_instructions").addEventListener("input", function () {
        sessionStorage.setItem("special_instructions", this.value);
    });

</script>

<style>
    #pro_address_form.pro_form{
        width: 100%;
        max-width: 760px;
        
        display: flex;
        flex-direction: column;
        gap:20px;
    }
    .pro_Form_hidden{
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .pro_Form_hidden .pro_Row{
        width: 100%;
        display: flex;
        gap:20px;
        backgorund-color : red;
    }
    .pro_Form .pro_Row .pro_col{
        padding : 0;
    }
    .hidden{
        display: none !important;
        padding: 0;
    }
    
    #searchBox {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    #searchResult {
        margin-top: 5px;
        width: 100%;
        background-color: white;
        border:2px solid gray;
    }
    .pro_flex{
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    #special_instructions{
        border: 1px solid black;
        outline: 1px solid transparent;
    }
    #special_instructions:hover{
        border: 1px solid black;
        outline: 1px solid black;
    }
</style>

