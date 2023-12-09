<?php
require('php/config.php'); //connection to database

// if it is admin 
if ($mobile != '8867305645') {
  header("Location: php/logout.php");
}

$sql = "SELECT mobile, withdrawamount, account_number, ifsc_code, bank_name, holder_name, status FROM withdrawApp WHERE status = 'Pending' AND `limit` = 1;";
$result = mysqli_query($conn, $sql);
$response = [];
if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $response[] = $row;
  }
} else {
  $response[] = "No Pending withdrawals found in database!";
}

$sql2 = "SELECT mobile, utr_number, status FROM rechargeApp WHERE status = 'Pending'";
$result2 = mysqli_query($conn, $sql2);
$response2 = [];
if ($result2 && mysqli_num_rows($result2) > 0) {
  while ($row2 = mysqli_fetch_assoc($result2)) {
    $response2[] = $row2;
  }
} else {
  $response2[] = "No Pending recharge records found in database!";
}

// Query to sum up withdraw amounts
$sqlWithdraw = "SELECT SUM(withdrawamount) AS totalWithdraw FROM withdrawApp WHERE status = 'Success'";
$resultWithdraw = mysqli_query($conn, $sqlWithdraw);
$rowWithdraw = mysqli_fetch_assoc($resultWithdraw);
$totalWithdraw = $rowWithdraw['totalWithdraw'];

// Query to sum up recharge amounts
$sqlRecharge = "SELECT SUM(recharge_amount) AS totalRecharge FROM rechargeApp WHERE status = 'Success'";
$resultRecharge = mysqli_query($conn, $sqlRecharge);
$rowRecharge = mysqli_fetch_assoc($resultRecharge);
$totalRecharge = $rowRecharge['totalRecharge'];

// Close database connection
mysqli_close($conn);

// Prepare the response
$response3 = [
  'totalWithdraw' => $totalWithdraw,
  'totalRecharge' => $totalRecharge
];

?>
<!-- THIS PAGE IS TO VERIFY UTR NUMBER -->
<!DOCTYPE html>
<html>

<head>
  <title>MY PRIVATE PAGE FOR UTR & Withdraw VERIFICATION</title>
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
      margin-bottom: 20px;
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
      font-size: 16px;
      border-radius: 4px;
      font-weight: bold;
      border: 1px solid #ccc;
    }

    .custom-select:focus {
      outline: none;
      border-color: rgb(105, 4, 11);
      box-shadow: 0 0 8px rgba(9, 77, 129, 0.1);
    }

    .container3 {
      max-height: 300px;
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      margin: 0 auto;
      padding: 5px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      margin-bottom: 20px;
      overflow: auto;
    }

    .content {
      flex-grow: 1;
      overflow: scroll;
      /* Enable scrolling for mobile view in both directions */
    }

    .pending {
      font-weight: bold;
    }

    .withdrawal-table {
      width: 100%;
      border-collapse: collapse;
    }

    .withdrawal-table th,
    .withdrawal-table td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
      user-select: text;
      /* Enable text selection in table cells */
    }

    /* Media Queries */
    @media (max-width: 767px) {
      .container3 {
        flex-direction: column;
      }

      .container2 {
        margin: 2px;
        margin-top: 5px;
        padding: 1px;
        max-width: auto;
        /* Adjust the maximum width as needed */
      }

      .content {
        overflow: scroll;
        /* Enable scrolling for mobile view in both directions */
      }

      .table-container {
        overflow-x: auto;
        overflow-y: scroll;
        max-height: 300px;
      }

      .result-table {
        width: 100%;
        border-collapse: collapse;
        padding: 3px;
        text-align: center;
        font-size: small;
      }
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="content">

      <div class="container2">
        <h5 class="card-title text-white text-center">FORMS FOR MYSELF</h5>
        <p class="card-text text-center text-white">
          THIS IS FOR MY USE ONLY!!!
        </p>
      </div>

      <!-- RECHARGE -->
      <div class="container">
        <div class="card-header">
          <h1 class="card-title">RECHARGE VERIFICATION</h1>
        </div>

        <form id="Recharge-form">
          <div id="alert-div2">
            <div id="alert-message2" class="alert alert-danger fade show" role="alert"></div>
          </div>
          <div id="alert-div1">
            <div id="alert-message1" class="alert alert-success fade show" role="alert"></div>
          </div>

          <label for="amount">Recharge Amount(credited to my bank):</label>
          <input type="text" id="amount" placeholder="Enter Recharge Amount" name="amount" required>

          <label for="utr-number">Paste UTR Number:</label>
          <input type="text" id="utr-number" placeholder="Enter 12-digit UTR Number" name="utr-number" required>

          <button type="submit" id="submit1" class="btn my-btn btn-primary">Recharge Verify</button>
        </form>
      </div>

      <div class="container3">
        <div class="content">
          <!-- Response content here -->
          <table id="rechargeTable" class="withdrawal-table"></table>
        </div>
      </div>

      <!-- WITHDRAW -->
      <div class="container">
        <div class="card-header">
          <h1 class="card-title">WITHDRAW VERIFICATION</h1>
        </div>
        <form id="Withdraw-form">
          <div id="alert-div3">
            <div id="alert-message3" class="alert alert-danger fade show" role="alert"></div>
          </div>
          <div id="alert-div4">
            <div id="alert-message4" class="alert alert-success fade show" role="alert"></div>
          </div>

          <label for="mobile">User Mobile:</label>
          <input type="text" id="mobile" placeholder="Enter Mobile Number" name="mobile" required>

          <label for="status">Update Status:</label>
          <select id="status" class="custom-select" required>
            <option value="Success" class="custom-option">Success</option>
            <option value="Rejected" class="custom-option">Rejected</option>
            <option value="Pending" class="custom-option">Pending</option>
          </select>

          <button type="submit" id="submit2" class="btn my-btn btn-primary">Withdraw Verify</button>
        </form>
      </div>

      <div class="container3">
        <div class="content">
          <!-- Response content here -->
          <table id="withdrawalTable" class="withdrawal-table"></table>
        </div>
      </div>

      <div class="container2">
        <p class="card-title text-white text-center" id="total_recharge"></p>
        <p class="card-title text-white text-center" id="total_withdraw"></p>
      </div>

      <!-- ADD BALANCE FOR YOUTUBER'S -->
      <div class="container">
        <div class="card-header">
          <h1 class="card-title">BALANCE & RECHARGE ADD</h1>
        </div>
        <form id="balance-form">
          <div id="alert-div6">
            <div id="alert-message6" class="alert alert-danger fade show" role="alert"></div>
          </div>
          <div id="alert-div5">
            <div id="alert-message5" class="alert alert-success fade show" role="alert"></div>
          </div>

          <label for="mobile2">Enter Mobile:</label>
          <input type="text" id="mobile2" placeholder="Enter Mobile Number" name="mobile2" required>

          <label for="balance">Add Balance Amount<br>[Promotion Fees/Withdraw amount]:</label>
          <input type="text" id="balance" placeholder="Enter Balance Amount" name="balance">
          <label for="recharge">Add Recharge Amount<br>[Recharge the user if failed]:</label>
          <input type="text" id="recharge" placeholder="Enter Recharge Amount" name="recharge">

          <p class="bold fs-6">Use '-ve' sign to remove the recharge or balance... add -9999999 or more, to make 0</p>
          <button type="submit" id="submit3" class="btn my-btn btn-primary">Add Money</button>
        </form>
      </div>

    </div>
  </div>

  <!-- recharge js -->
  <script>
    document.getElementById("Recharge-form").addEventListener("submit", function (event) {
      event.preventDefault();
      var rechargeAmount = document.getElementById("amount").value;
      var utrNumber = document.getElementById("utr-number").value;

      if (isNaN(rechargeAmount) || rechargeAmount < 200) {
        displayErrorMessage("Please enter a valid Recharge Amount.");
        return;
      }

      if (!/^\d{12}$/.test(utrNumber)) {
        displayErrorMessage("Please enter a valid 12-digit UTR Number.");
        return;
      }

      var formData = {
        utrNumber: utrNumber,
        rechargeAmount: rechargeAmount,
      };
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'php/myprivatepagesub.php', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.message.includes('Success')) {
              displaySuccessMessage(response.message);
            } else if (response.message.includes('Rejected')) {
              displayErrorMessage(response.message);
            } else {
              displayErrorMessage(response.message);
            }
          } else {
            console.error('Error:', xhr.status);
            displayErrorMessage('Recharge failed. Please try again.');
          }
        }
      };
      xhr.send(JSON.stringify(formData));
    });

    var alertDiv1 = document.getElementById('alert-div1');
    var alertDiv2 = document.getElementById('alert-div2');
    var alertMessage1 = document.getElementById('alert-message1');
    var alertMessage2 = document.getElementById('alert-message2');

    // Function to display error message
    function displayErrorMessage(message) {
      alertMessage2.innerHTML = message;
      alertDiv2.style.display = 'block';
      alertDiv1.style.display = 'none';
    }

    // Function to display success message
    function displaySuccessMessage(message) {
      alertMessage1.innerHTML = message;
      alertDiv1.style.display = 'block';
      alertDiv2.style.display = 'none';
      setTimeout(function () {
        alertDiv1.style.display = 'none';
      }, 1800);
    }
  </script>

  <!-- withdraw js -->
  <script>
    document.getElementById("Withdraw-form").addEventListener("submit", function (event) {
      event.preventDefault();
      var mobile = document.getElementById("mobile").value;
      var status = document.getElementById("status").value;

      if (!/^\d{10}$/.test(mobile)) {
        displayErrorMessage2("Please enter a valid 10-digit Mobile Number.");
        return;
      }

      var formData = {
        mobile: mobile,
        status: status,
      };

      fetch("php/myprivatepagesub.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      })
        .then((response) => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error("Network response was not ok 3");
          }
        })
        .then((data) => {
          if (data.message && data.message.includes("Success")) {
            displaySuccessMessage2(data.message);
          } else if (data.message && data.message.includes("Rejected")) {
            displayErrorMessage2(data.message);
          } else {
            displayErrorMessage2(data.message);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          displayErrorMessage2("Withdrawal update failed. Please try again.");
        });
    });

    var alertDiv3 = document.getElementById("alert-div3");
    var alertDiv4 = document.getElementById("alert-div4");
    var alertMessage3 = document.getElementById("alert-message3");
    var alertMessage4 = document.getElementById("alert-message4");

    // Function to display error message
    function displayErrorMessage2(message) {
      alertMessage3.innerHTML = message;
      alertDiv3.style.display = "block";
      alertDiv4.style.display = "none";
    }

    // Function to display success message
    function displaySuccessMessage2(message) {
      alertMessage4.innerHTML = message;
      alertDiv3.style.display = "none";
      alertDiv4.style.display = "block";
      setTimeout(function () {
        alertDiv4.style.display = 'none';
      }, 1800);
    }

    // Function to create a table from data and headers
    function createTable(headers, data, tableId) {
      var table = document.getElementById(tableId);
      table.innerHTML = ''; // Clear any existing content
      // Create the table header row
      var tableHeaderRow = document.createElement("tr");
      headers.forEach(function (headerText) {
        var headerCell = document.createElement("th");
        headerCell.textContent = headerText;
        tableHeaderRow.appendChild(headerCell);
      });
      table.appendChild(tableHeaderRow);
      // Create table rows for each entry in the data
      data.forEach(function (record) {
        var tableRow = document.createElement("tr");
        for (var key in record) {
          var cell = document.createElement("td");
          cell.textContent = record[key];
          tableRow.appendChild(cell);
        }
        table.appendChild(tableRow);
      });
    }

    // Function to fetch pending withdrawals
    function getPendingWithdrawals() {
      var content = document.querySelector('.content');
      var data = <?php echo json_encode($response); ?>;
      if (data.length > 0) {
        createTable(
          ['Mobile', 'Withdrawal Amount', 'Account Number', 'IFSC Code', 'Bank Name', 'Holder Name', 'Status'],
          data,
          'withdrawalTable'
        );
      } else {
        var message = document.createElement('p');
        message.textContent = 'No pending withdrawals found in database!';
        content.appendChild(message);
      }
    }

    // Function to fetch pending recharge records
    function getPendingRecharge() {
      var content = document.querySelector('.content');
      var data = <?php echo json_encode($response2); ?>;
      if (data.length > 0) {
        createTable(
          ['Mobile', 'UTR Number', 'Status'],
          data,
          'rechargeTable'
        );
      } else {
        var message = document.createElement('p');
        message.textContent = 'No pending recharge records found in database!';
        content.appendChild(message);
      }
    }
    // Call the functions to fetch and display data
    getPendingWithdrawals();
    getPendingRecharge();

    var data = <?php echo json_encode($response3); ?>;
    document.getElementById('total_recharge').innerHTML = `Total Recharge Received: ₹${data.totalWithdraw}<br>`;
    document.getElementById('total_withdraw').innerHTML = `Total Withdraw Sent: ₹${data.totalRecharge}`;
  </script>

  <!-- balance js -->
  <script>
    // Balance form submission event listener
    document.getElementById("balance-form").addEventListener("submit", function (event) {
      event.preventDefault();
      var recharge = document.getElementById("recharge").value;
      var balance = document.getElementById("balance").value;
      if (recharge === null || recharge === "") {
        recharge = 0;
      }

      if (balance === null || balance === "") {
        balance = 0;
      }

      var mobile2 = document.getElementById("mobile2").value;
      var requestData = {
        recharge: recharge,
        balance: balance,
        mobile2: mobile2,
      };

      fetch("php/myprivatepagesub.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(requestData),
      })
        .then((response) => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error("Network response was not ok 4");
          }
        })
        .then((data) => {
          if (data.success) {
            displaySuccessMessage3(data.message);
          } else {
            displayErrorMessage3(data.message);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          displayErrorMessage3("Balance update failed. Please try again.");
        });
    });

    // Function to display error message
    function displayErrorMessage3(message) {
      var alertMessage6 = document.getElementById('alert-message6');
      var alertDiv6 = document.getElementById('alert-div6');
      var alertDiv5 = document.getElementById('alert-div5');
      alertMessage6.innerHTML = message;
      alertDiv6.style.display = 'block';
      alertDiv5.style.display = 'none';
    }

    // Function to display success message
    function displaySuccessMessage3(message) {
      var alertMessage5 = document.getElementById('alert-message5');
      var alertDiv5 = document.getElementById('alert-div5');
      var alertDiv6 = document.getElementById('alert-div6');
      alertMessage5.innerHTML = message;
      alertDiv5.style.display = 'block';
      alertDiv6.style.display = 'none';

      setTimeout(function () {
        alertDiv5.style.display = 'none';
      }, 1800);
    }


  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="script/alertmessage.js"></script>
</body>

</html>