<!-- Step 2: Collection Address -->
<div class="step" id="step-2">
    <div class="pro_row">
        <div class="pro_col">
            <img src="https://cdn-icons-png.flaticon.com/512/4797/4797387.png" alt="png" width="70">
            <h3 class="mt-2 mb-3">Address & Details</h3>
            <h6><b>Tell us where to collect your stuff from</b></h6>
        </div>
    </div>

    <div class=" pro_col p-0" >
        
        <div id="pro_address_form" class="pro_form">
            <!-- Address Autocomplete Field -->
            <div class="pro_Row" id="searchBox">
                <div class="pro_col">
                    <input type="text" id="searchInput" oninput="searchSchool()" class="form-control address-search" placeholder="Start typing and select your address">
                </div>
                <div id="searchResult" class="hidden"></div>
            </div>
            <div id="hiddenField" class="hidden">
                <form class="pro_Form_hidden pro_Row">
                    <div class="pro_Row">
                        <!-- First Name -->
                        <div class="pro_col">
                            <div class=" pro_inputBox inline-label ls-input form-group">
                                <label class="label" for="first_name">First name *</label>
                                <input class="form-control valid mb-0 not-empty" type="text" placeholder="" aria-label="First name *" id="first_name" required>
                            </div>
                        </div>
                        <!-- Last Name -->
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label" for="last_name">Last name *</label>
                                <input class="form-control valid mb-0 not-empty" type="text" placeholder="" aria-label="Last name *" id="last_name" required>
                            </div>
                        </div>
                    </div>
    
                    <div class="pro_Row">
                        <!-- Building number/name -->
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label" for="building_name">Building number/name *</label>
                                <input class="form-control valid mb-0 not-empty" type="text" placeholder="" aria-label="Building number/name *" id="building_name" required>
                            </div>
                        </div>
                        <!-- Address Line 1 -->
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label" for="address_line1" >Address line 1 *</label>
                                <input class="form-control valid mb-0 not-empty" type="text" placeholder="" aria-label="Address line 1 *" id="address_line1" required>
                            </div>
                        </div>
                    </div>
    
                    <div class="pro_Row">
                        <!-- Address Line 2 -->
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label" for="address_line2">Address line 2</label>
                                <input class="form-control valid mb-0" type="text" placeholder="" aria-label="Address line 2" id="address_line2">
                            </div>
                        </div>
    
                        <!-- Town -->
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label" for="town" >Town *</label>
                                <input class="form-control valid mb-0 not-empty" type="text" placeholder="" aria-label="Town *" id="town" required>
                            </div>
                        </div>
                    </div>
    
                    <div class="pro_Row">
                        <!-- Postcode -->
                        <div class="pro_col">
                            <div class="pro_inputBox inline-label ls-input form-group">
                                <label class="label" for="postcode" >Postcode *</label>
                                <input class="form-control valid mb-0 not-empty" type="text" placeholder="" aria-label="Postcode *" id="postcode" required>
                            </div>
                        </div>
                    </div>
    
                    <!-- Special Instructions -->
                    <div class="pro_Row">
                        <div class="pro_col">
                            <div class="inline-label ls-textarea">
                                <textarea class="form-control" placeholder="Special instructions" rows="2" id="special_instructions"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="">
                        <span>Please enter special instructions here. Our drivers cannot always contact you by telephone on arrival so make sure that your door bell is working, that any reception point is informed, and that someone is able to meet the driver at the ground floor of the given address.</span>
                    </div>
                </form>
            </div>
            <div class="row text-start mt-3">
                <span id ="enterManually"><em>Or enter manually</em></span>
            </div>

        </div>
        <button class="next-step">Continue</button>
    </div>

</div>

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

<script>

    let schoolNames = [
        "ASKAR KALIBARI SECONDARY SCHOOL AND COLLEGE",
        "CHHOYGRAM SECONDARY SCHOOL AND COLLEGE",
        "ADARSHA HIGH SCHOOL AND COLLAGE,MOHONKATHI",
        "BAGDHA SECONDARY SCHOOL & COLLEGE",
        "BAHADURPUR NISHIKANTA GAIN GIRL S SCHOOL & COLLEGE",
        "BARISAL CADET COLLEGE",
        "MADDHABPASHA CHANDRADIP HIGH SCHOOL AND COLLEGE",
        "CHANDPASHA HIGH SCHOOL AND COLLEGE",
        "MASJIDBARI SECONDARY SCHOOL AND COLLEGE",
        "KASHIPUR GIRLS HIGH SCHOOL & COLLEGE",
        "PALORDI SCHOOL AND COLLEGE",
        "HALIMA KHATUN GIRLS SCHOOL & COLLEGE",
        "SHAHID ZIA ADARSHA GIRLS HIGH SCHOOL",
        "CHAR ZANGALIA SCHOOL & COLLEGE",
        "PANGASHIA SCHOOL AND COLLEGE",

    ]
    function searchSchool() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let searchResult = document.getElementById("searchResult");
        searchResult.innerHTML = ""; 
        console.log(input);
        console.log(searchResult);
        

        if (input.length < 3) {
            searchResult.classList.add("hidden");
        }
        if (input.length >= 3) {
            searchResult.classList.remove("hidden");
            searchResult.style.display = "block";
            console.log("kaj ki kore");
            
        } else {
            searchResult.classList.add("hidden");
            searchResult.style.display = "none";
        }

        let filteredSchools = schoolNames.filter(school => school.toLowerCase().startsWith(input));

        if (filteredSchools.length === 0) {
            searchResult.innerHTML = "<li>No matching schools found</li>";
            console.log("not found");
            
        } else {
            filteredSchools.forEach(school => {
                let li = document.createElement("li");
                li.textContent = school;
                searchResult.appendChild(li);
                console.log("school");
                
            });
        }
    }

    document.getElementById("enterManually").addEventListener("click", (event) => {
        document.querySelector("#hiddenField").classList.remove("hidden");
        event.target.classList.add("hidden");
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
