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