<?php
require('php/config.php'); //connection to database
?>
<!DOCTYPE html>
<html>

<head>
  <title>Recharge</title>
  <link rel="icon" href="img/LOGO.png" type="png">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="format-detection" content="telephone=no" />
  <meta name="HandheldFriendly" content="true" />
  <meta name="MobileOptimized" content="320" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="css/mainpage.css" rel="stylesheet" />
  <style>
    body {
      height: 100vh;
      width: 100vw;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 400px;
      margin: 0 auto;
      padding: 5px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    .container2 {
      margin-bottom: 15px;
      margin-top: 15px;
    }

    .card-text {
      font-size: 18px;
    }

    .card-title {
      margin-bottom: 5px;
      font-size: 26px;
    }

    .card-header {
      background-color: rgb(105, 4, 11);
      color: #fff;
      padding: 5px;
      margin-bottom: 5px;
      border-radius: 5px !important;
      text-align: center;
    }

    label {
      display: block;
      font-weight: bold;
    }

    input {
      display: block;
      width: 100%;
      margin-top: 5px;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    a {
      display: block;
      margin-top: 5px;
      text-align: center;
      color: rgb(105, 4, 11);
      text-decoration: none;
      font-size: 16px;
      width: 100%;
    }

    form {
      background-color: #f2f2f2;
    }

    a:hover {
      text-decoration: underline;
    }

    .my-btn {
      width: 100%;
      font-size: 20px;
    }

    .external {
      display: flex;
      justify-content: space-around;
      margin: 5px;
    }

    .btn1 {
      background-color: rgb(105, 4, 11);
      /* Change this to the color of your choice */
      color: #fff;
      border: none;
      padding: 5px 5px;
      border-radius: 5px;
      font-size: 14px;
      font-family: 'Roboto', 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }

    .btn-primary2 {
      margin-top: 3px;
      margin-bottom: 10px;
      background-color: rgb(105, 4, 11);
      border: none;
      padding: 5px 5px;
      border-radius: 5px;
      font-size: 14px;
    }

    input {
      border-color: rgb(105, 4, 11);
      color: rgb(105, 4, 11);
      font-weight: bolder;
      border: 2px solid rgb(105, 4, 11);
      margin-bottom: 7px;
    }

    input:focus,
    input:focus:valid {
      border: 3px solid rgb(105, 4, 11);
      border-color: rgb(105, 4, 11);
      outline: none;
    }

    .bold {
      font-family: 'Roboto', 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
      font-size: 18px;
      font-weight: 1000;
      /* Increase the font weight for a bolder effect */
      color: #222;
      /* Darken the text color */
    }

    #on-click-recharge-show {
      display: none;
    }

    .smaller-image {
      width: 200px;
      height: 200px;
    }

    .custom-select,
    .image-label {
      width: 200px;
      padding: 8px;
      margin-bottom: 4px;
      font-size: 14px;
      border-radius: 4px;
      font-weight: bold;
      border: 1px solid #ccc;
    }

    .custom-select:focus {
      outline: none;
      border-color: rgb(105, 4, 11);
      box-shadow: 0 0 8px rgba(9, 77, 129, 0.1);
    }

    .input-container {
      position: relative;
    }

    .rupee-symbol {
      position: absolute;
      left: 8px;
      top: 50%;
      transform: translateY(-50%);
      pointer-events: none;
    }

    .amount-input {
      padding-left: 20px;
      /* Adjust as needed */
    }

    @media (max-width: 768px) {
      .container2 {
        margin: 2px;
        margin-top: 5px;
        padding: 1px;
        max-width: auto;
        /* Adjust the maximum width as needed */
      }

      .container {
        max-width: auto;
        /* Adjust the maximum width as needed */
      }
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="content">

      <div id="on-click-recharge-hide">
        <div class="container2">
          <h5 class="card-title text-white text-center">Recharge</h5>
          <p class="card-text text-center text-white">
            Recharge your products instantly with a few simple clicks!
          </p>
        </div>

        <div class="container">
          <div class="card-header">
            <h1 class="card-title">Recharge Gateway</h1>
          </div>

          <form id="Recharge-form">
            <div id="alert-div2">
              <div id="alert-message2" class="alert alert-danger fade show" role="alert"></div>
            </div>
            <div id="alert-div1">
              <div id="alert-message1" class="alert alert-success fade show" role="alert"></div>
            </div>

            <label for="amount">Recharge Amount:</label>
            <div class="input-container">
              <span class="rupee-symbol">&#8377;</span>
              <input type="text" id="amount" class="amount-input" placeholder="Enter Recharge Amount" name="amount"
                required>
            </div>

            <label for="quickselect">Quick Select:</label>
            <div class="external">
              <!-- Quick select buttons -->
              <!-- Button onclick event calls fillAmount() function to set the amount -->
              <button type="button" class="btn btn1" onclick="fillAmount(477)">₹477</button>
              <button type="button" class="btn btn1" onclick="fillAmount(1400)">₹1,400</button>
              <button type="button" class="btn btn1" onclick="fillAmount(3700)">₹3,700</button>
              <button type="button" class="btn btn1" onclick="fillAmount(8000)">₹8,000</button>
            </div>

            <div class="external">
              <!-- More quick select buttons -->
              <!-- Button onclick event calls fillAmount() function to set the amount -->
              <button type="button" class="btn btn1" onclick="fillAmount(1000)">₹1,000</button>
              <button type="button" class="btn btn1" onclick="fillAmount(3500)">₹3,500</button>
              <button type="button" class="btn btn1" onclick="fillAmount(6000)">₹6,000</button>
              <button type="button" class="btn btn1" onclick="fillAmount(12000)">₹12,000</button>
            </div>

            <!-- set3 -->
            <div class="external">
              <!-- More quick select buttons -->
            </div>

            <button type="submit" id="submit1" class="btn my-btn btn-primary">Recharge</button>
          </form>
        </div>

        <div class="container2">
          <h5 class="card-title text-white text-center">Recharge Rules</h5>
          <ul class="text-white">
            <li>Minimum Recharge amount: 200Rs</li>
            <li>Once the company receives the payment, it will be credited to the app.</li>
            <li>Arrival time: 10 minutes - 24 hours (subject to bank transfer time). We
              appreciate your patience.</li>
            <li>In case you do not receive the recharge within 24 hours, kindly reach out to our customer care.</li>
            <li>Stay connected with hassle-free product recharge and exceptional customer support.</li>
          </ul>
        </div>
      </div>


      <div id="on-click-recharge-show">
        <div class="container2">
          <h5 class="card-title text-white text-center">UPI Transaction</h5>
          <p class="card-text text-center text-white">
            Read Recharge Rules Below!
          </p>
        </div>
        <div class="container">
          <div class="card-header">
            <h1 class="card-title">UTR Verification</h1>
          </div>
          <p class="bold">Pay Amount ₹<span id="rechargeAmountValue"></span> from below options:</p>
          <label for="amount">Select UPI ID:</label>
          <select id="upi-select" class="custom-select">
            <option value="kinglocker001@ybl" class="custom-option">kinglocker001@ybl</option>
            <option value="royalclothing00@ibl" class="custom-option">royalclothing00@ibl</option>
            <option value="royalclothing@paytm" class="custom-option">royalclothing@paytm</option>
          </select>
          <div id="alert-div3">
            <div id="alert-message3" class="alert alert-success fade show" role="alert"></div>
          </div>
          <button class="btn btn-primary2" id="copyToClip" onclick="copyToClipboard()">Copy UPI ID</button>
          <label for="utr-scanner">Pay to Scanner:</label>
          <div id="scanner">
            <div class="d-flex align-items-center justify-content-start" id="scanner-container">
              <!-- Scanners will be dynamically generated here so give the new scanners down in javascript -->
            </div>
            <div>
              <button class="btn btn-primary2" id="toggleButton" onclick="toggleScanner()">Switch Scanner</button>
            </div>
          </div>
          <div id="alert-div4">
            <div id="alert-message4" class="alert alert-danger fade show" role="alert"></div>
          </div>
          <div id="alert-div5">
            <div id="alert-message5" class="alert alert-success fade show" role="alert"></div>
          </div>
          <form id="utr-form">
            <label for="utr-number">Paste UTR Number:</label>
            <input type="text" id="utr-number" placeholder="Enter 12-digit UTR Number" name="utr-number">
            <button type="submit" id="submit2" class="btn my-btn btn-primary">Verify&nbsp; UTR&nbsp; Number</button>
          </form>
        </div>

        <div class="container2">
          <h5 class="card-title text-white text-center">Recharge Rules</h5>
          <ul class="text-white">
            <li>The recharge amount should match the UTR amount, else recharge will not be processed.</li>
            <li>You can use any UPI app for payment.</li>
            <li>You can pay to either UPI ID or Scanner.</li>
            <li>Copy the 12-digit UTR Number from the payment app and paste it here.</li>
            <li>Recharge requests below the minimum amount of ₹200 will not be processed.</li>
            <li>Entering an invalid UPI Number may cause recharge failure, so please check before entering.</li>
            <li>Once the company receives the payment, it will be credited to the app.</li>
            <li>Arrival time: 10 minutes - 24 hours (subject to bank transfer time). We
              appreciate your patience.</li>
            <li>In case you do not receive the recharge within 24 hours, kindly reach out to our customer care.</li>
          </ul>
        </div>
      </div>

    </div>

    <!-- footer -->
    <footer class="footer">
      <div class="row">
        <div class="col-md-12">
          <div class="btn-group" role="group">
            <button class="btn btn-primary btn-icon btn-underline active" id="homeButton" onclick="location.href='mainpage'">
              <img src="img/home.png" alt="Home" class="btn-icon-image">
              <span class="btn-text"><br>Home</span>
            </button>
            <button class="btn btn-primary btn-icon btn-underline" id="teamButton"
              onclick="location.href='inviteRecords'">
              <img src="img/team.png" alt="inviteRecords" class="btn-icon-image">
              <span class="btn-text"><br>Team</span>
            </button>
            <button class="btn btn-primary btn-icon btn-underline" id="inviteButton" onclick="location.href='invite'">
              <img src="img/invite.png" alt="Invite" class="btn-icon-image">
              <span class="btn-text"><br>Invite</span>
            </button>
            <button class="btn btn-primary btn-icon btn-underline" id="profileButton" onclick="location.href='profile'">
              <img src="img/my.png" alt="Profile" class="btn-icon-image">
              <span class="btn-text"><br>Profile</span>
            </button>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script>
    // Recharge form submission event listener
    document.getElementById('Recharge-form').addEventListener('submit', function (event) {
      event.preventDefault();
      var rechargeAmount = document.getElementById('amount').value;
      rechargeAmountwithComma = parseFloat(rechargeAmount).toLocaleString(undefined, { maximumFractionDigits: 0 });
      if (rechargeAmount < 200) {
        document.getElementById('alert-message2').innerHTML = 'Minimum recharge amount is 200.';
        document.getElementById('alert-div2').style.display = 'block';
        document.getElementById('alert-div1').style.display = 'none';
        return;
      }
      if (isNaN(rechargeAmount)) {
        document.getElementById('alert-message2').innerHTML = 'Please enter a valid number.';
        document.getElementById('alert-div2').style.display = 'block';
        document.getElementById('alert-div1').style.display = 'none';
        return;
      }
      var hideDiv = document.getElementById("on-click-recharge-hide");
      var showDiv = document.getElementById("on-click-recharge-show");
      hideDiv.style.display = "none";
      showDiv.style.display = "block";
      document.getElementById('rechargeAmountValue').textContent = rechargeAmountwithComma;
    });
    // UTR verification form submission event listener
    document.getElementById('utr-form').addEventListener('submit', function (event) {
      event.preventDefault();
      var utrNumber = document.getElementById('utr-number').value;
      var rechargeAmount = document.getElementById('amount').value;
      if ((utrNumber.length !== 12) || isNaN(utrNumber)) {
        var alertDiv4 = document.getElementById('alert-div4');
        var alertMessage4 = document.getElementById('alert-message4');
        alertMessage4.innerText = 'Invalid UTR Number!';
        alertDiv4.style.display = 'block';
        var alertDiv5 = document.getElementById('alert-div5');
        alertDiv5.style.display = 'none';
        return;
      }
      // Create an object to store the data to be sent
      var data = {
        utrNumber: utrNumber,
        rechargeAmount: rechargeAmount
      };
      // Make a fetch request
      fetch('php/post_values.php', {
        method: 'POST',
        body: JSON.stringify(data), // Convert the data object to JSON
        headers: {
          'Content-Type': 'application/json'
        }
      })
        .then(response => response.json())
        .then(response => {
          var alertDiv5 = document.getElementById('alert-div5');
          var alertMessage5 = document.getElementById('alert-message5');
          if (response.status === 'success') {
            alertMessage5.innerText = response.message;
            alertDiv5.style.display = 'block';
            var alertDiv4 = document.getElementById('alert-div4');
            alertDiv4.style.display = 'none';
          } else {
            var alertDiv4 = document.getElementById('alert-div4');
            var alertMessage4 = document.getElementById('alert-message4');
            alertMessage4.innerText = response.message;
            alertDiv4.style.display = 'block';
            var alertDiv5 = document.getElementById('alert-div5');
            alertDiv5.style.display = 'none';
          }
        })
        .catch(error => {
          var alertDiv4 = document.getElementById('alert-div4');
          var alertMessage4 = document.getElementById('alert-message4');
          alertMessage4.innerText = 'Payment processing failed. Error: ' + error;
          alertDiv4.style.display = 'block';
          var alertDiv5 = document.getElementById('alert-div5');
          alertDiv5.style.display = 'none';
        });
      document.getElementById('submit2').disabled = true;
    });
  </script>

  <!-- FUNCTIONS JS -->
  <script>
    function fillAmount(amount) {
      document.getElementById('amount').value = amount;
    }
    function copyToClipboard() {
      var selectElement = document.getElementById('upi-select');
      var selectedUPIID = selectElement.value;
      var tempTextArea = document.createElement('textarea');
      tempTextArea.value = selectedUPIID;
      document.body.appendChild(tempTextArea);
      tempTextArea.select();
      document.execCommand('copy');
      document.body.removeChild(tempTextArea);
      var alertDiv = document.getElementById('alert-div3');
      var alertMessage = document.getElementById('alert-message3');
      alertMessage.innerText = 'Copied to Clipboard!';
      alertDiv.style.display = 'block';
    }

    const scanners = [
      { src: "img/scanner1.jpg", alt: "Scanner 1", label: "kinglocker001@ybl", },
      { src: "img/scanner2.jpg", alt: "Scanner 2", label: "royalclothing00@ibl", },
      { src: "img/scanner3.png", alt: "Scanner 3", label: "royalclothing@paytm", },
      // Add more scanner data here as needed
    ];
    let currentScannerIndex = 0;
    function toggleScanner() {
      const scannerContainer = document.getElementById("scanner-container");
      if (scannerContainer.children[currentScannerIndex]) {
        scannerContainer.children[currentScannerIndex].style.display = "none";
      }
      currentScannerIndex = (currentScannerIndex + 1) % scanners.length;
      createOrUpdateScannerElement(scannerContainer, scanners[currentScannerIndex]);
    }
    function createOrUpdateScannerElement(container, scannerData) {
      // If an element for the current scanner already exists, update it; otherwise, create a new one.
      if (container.children[currentScannerIndex]) {
        const scannerElement = container.children[currentScannerIndex];
        const image = scannerElement.querySelector("img");
        const label = scannerElement.querySelector(".image-label");
        image.src = scannerData.src;
        image.alt = scannerData.alt;
        label.textContent = scannerData.label;
        scannerElement.style.display = "block";
      } else {
        const imageContainer = document.createElement("div");
        imageContainer.className = "image-container";
        const image = document.createElement("img");
        image.src = scannerData.src;
        image.alt = scannerData.alt;
        image.className = "img-fluid smaller-image";
        const label = document.createElement("div");
        label.className = "image-label bold";
        label.textContent = scannerData.label;

        imageContainer.appendChild(image);
        imageContainer.appendChild(label);
        container.appendChild(imageContainer);
      }
    }
    // Initially, set the first scanner as visible
    createOrUpdateScannerElement(document.getElementById("scanner-container"), scanners[currentScannerIndex]);

  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="script/mainpage.js"></script>
</body>

</html>