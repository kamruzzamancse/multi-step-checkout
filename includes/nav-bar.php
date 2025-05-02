<nav class="">
    <div class="box_warpper">
        <div class="box-container">
            <div class="box" id="boxOne">
                <div class="miniBox"></div>
            </div>
            <span class="box-label">Storage</span>
        </div>
        <div class="line"></div>
        <div class="box-container">
            <div class="box" id="boxTwo"></div>
            <span class="box-label">Address</span>
        </div>
        <div class="line"></div>
        <div class="box-container">
            <div class="box" id="boxThree"></div>
            <span class="box-label">Pickup</span>
        </div>
        <div class="line"></div>
        <div class="box-container">
            <div class="box" id="boxFour"></div>
            <span class="box-label">Materials</span>
        </div>
        <div class="line"></div>
        <div class="box-container">
            <div class="box" id="boxFive"></div>
            <span class="box-label">Protection</span>
        </div>
        <div class="line"></div>
        <div class="box-container">
            <div class="box" id="boxLast"></div>
            <span class="box-label">Checkout</span>
        </div>
    </div>
</nav>

<style>

nav {
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  padding: 20px 0 20px 0;
}

nav .box_warpper {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: start;
}
nav .box_warpper .box {
  width: 60px;
  height: 60px;
  /* border: 2px solid var(--lightGray) !important; */
  background-color: #fff;
  padding: 15px;
  border-radius: 4px;
  cursor: pointer;
}
.box-label{
  font-size: 15px !important;
}
nav .box_warpper .box.active {
    background-color: var(--praimary) !important;
    border-color: var(--praimary) !important;
}
nav .box_warpper .box .miniBox {
  width: 100%;
  height: 100%;
  background: #fff;
  border-radius: 3px;
}

nav .box_warpper .line {
  width: 80px;
  height: 2px;
  background-color: var(--lightGray);
  margin-top: -22px;
}

.box-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.box-container .box {
  border: 2px solid var(--lightGray);
  background-color: #fff;
}
nav .box_warpper .box-container:nth-child(1) .box {
  background-color: var(--praimary);
  border: var(--praimary);
}
.box-label {
  margin-top: 8px;
  font-size: 11px;
  color: #333;
  text-align: center;
  font-weight: bold;
}
@media (max-width: 576px) {
  nav .box_warpper {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
  nav .box_warpper .box {
    width: 50px;
    height: 50px;
    margin: 0;
  }
  nav .box_warpper .line {
    width: 60px;
    height: 2px;
  }
  .box-label{
    font-size: 10px !important;
  }
}

/* Active box color */
nav .box_warpper .box.active {
  background-color: #00a899;  /* Active color */
  border-color: #00a899;
}

/* Color for completed boxes (filled) */
nav .box_warpper .box.filled {
    background-color: #00a899;  /* Color for filled boxes (completed steps) */
    border-color: #00a899;
}

/* MiniBox inside active box */
nav .box_warpper .box .miniBox {
    background-color: #fff;  /* Optional styling for miniBox */
}
</style>

<script>
/*   document.addEventListener("DOMContentLoaded", () => {
    const boxes = document.querySelectorAll(".box");

    boxes.forEach((box) => {
        box.addEventListener("click", function () {
            // Remove 'active' class and miniBox from all boxes
            boxes.forEach((eachBox) => {
                eachBox.classList.remove("active");
                const miniBox = eachBox.querySelector(".miniBox");
                if (miniBox) eachBox.removeChild(miniBox);
            });

            // Add 'active' class and append miniBox to the clicked box
            this.classList.add("active");
            if (!this.querySelector(".miniBox")) {
                const miniBox = document.createElement("div");
                miniBox.classList.add("miniBox");
                this.appendChild(miniBox);
            }
        });
    });
}); */

</script>

<script>
/* document.addEventListener("DOMContentLoaded", () => {
    const boxes = document.querySelectorAll(".box");

    // Check for active step in sessionStorage and activate the corresponding box
    if (sessionStorage.getItem("step-1") === "true") {
        document.getElementById("boxOne").classList.add("active");
        addMiniBox(document.getElementById("boxOne"));
    }
    if (sessionStorage.getItem("step-2") === "true") {
        document.getElementById("boxTwo").classList.add("active");
        addMiniBox(document.getElementById("boxTwo"));
    }
    if (sessionStorage.getItem("step-3") === "true") {
        document.getElementById("boxThree").classList.add("active");
        addMiniBox(document.getElementById("boxThree"));
    }
    if (sessionStorage.getItem("step-4") === "true") {
        document.getElementById("boxFour").classList.add("active");
        addMiniBox(document.getElementById("boxFour"));
    }
    if (sessionStorage.getItem("step-5") === "true") {
        document.getElementById("boxFive").classList.add("active");
        addMiniBox(document.getElementById("boxFive"));
    }
    if (sessionStorage.getItem("step-6") === "true") {
        document.getElementById("boxLast").classList.add("active");
        addMiniBox(document.getElementById("boxLast"));
    }

    // Function to append miniBox if not already present
    function addMiniBox(boxElement) {
        if (!boxElement.querySelector(".miniBox")) {
            const miniBox = document.createElement("div");
            miniBox.classList.add("miniBox");
            boxElement.appendChild(miniBox);
        }
    }

    // Click event to mark boxes as active and store the active step in sessionStorage
    boxes.forEach((box) => {
        box.addEventListener("click", function () {
            // Remove 'active' class and miniBox from all boxes
            boxes.forEach((eachBox) => {
                eachBox.classList.remove("active");
                const miniBox = eachBox.querySelector(".miniBox");
                if (miniBox) eachBox.removeChild(miniBox);
            });

            // Add 'active' class and append miniBox to the clicked box
            this.classList.add("active");
            addMiniBox(this);

            // Store the active step in sessionStorage
            sessionStorage.setItem("active_step", this.id);
            const stepNumber = this.id.replace('box', 'step-'); // Convert box ID to step number
            sessionStorage.setItem(stepNumber, "true");
        });
    });
}); */
</script>
