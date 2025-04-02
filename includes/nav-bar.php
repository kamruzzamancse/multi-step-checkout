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
  border: 2px solid var(--lightGray);
  padding: 15px;
  border-radius: 4px;
  cursor: pointer;
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
nav .box_warpper .box:nth-child(1) {
  background-color: var(--praimary);
  border: var(--praimary);
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

.box-label {
  margin-top: 8px;
  font-size: 11px;
  color: #333;
  text-align: center;
  font-weight: bold;
}

</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
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
});

</script>
