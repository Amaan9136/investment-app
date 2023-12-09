<?php
require('php/config.php'); // Connection to the database
$query = "SELECT holder_name FROM bankdetails WHERE mobile = '$mobile'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
  $success = true;
  $message = "Bank details filled";
} else {
  $message = "Bank details not filled.";
  $success = false;
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Withdraw</title>
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
      margin-top: 5px;
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

    input {
      border-color: rgb(105, 4, 11);
      color: rgb(105, 4, 11);
      font-weight: bolder;
      border: 2px solid rgb(105, 4, 11);
    }

    input:focus,
    input:focus:valid {
      border: 3px solid rgb(105, 4, 11);
      border-color: rgb(105, 4, 11);
      outline: none;
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
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="content">

      <div class=" container2">
        <h5 class="card-title text-white text-center">Withdrawal</h5>
        <p class="card-text text-center text-white">
          Claim your Daily income and Invitation rewards by filling the below application.
        </p>
      </div>
      <div class="container">
        <div class="card-header">
          <h1 class="card-title">Withdraw Form</h1>
        </div>
        <form id="withdraw-form">
          <div id="alert-div2">
            <div id="alert-message2" class="alert alert-danger fade show" role="alert"></div>
          </div>
          <div id="alert-div1">
            <div id="alert-message1" class="alert alert-success fade show" role="alert"></div>
          </div>
          <label for="amount">Withdrawal Amount:</label>
          <div class="input-container">
            <span class="rupee-symbol">&#8377;</span>
            <input type="text" id="amount" class="amount-input" placeholder="Enter Withdrawal Amount" name="amount"
              required>
          </div>
          <label for="withdrawalPassword">Withdrawal Password:</label>
          <input type="password" id="withdrawalPassword" placeholder="Enter Withdrawal password"
            name="withdrawalPassword" required>
          <label class="form-label"><a href="contact">Forgot Withdraw Password?</a></label>
          <button type="submit" id="submit" class="btn my-btn ">Submit Application</button>
        </form>
      </div>


      <div class=" container2">
        <h5 class="card-title text-white text-center">Withdrawal Rules</h5>
        <ul class="text-white">
          <li>Minimum withdrawal amount: 150Rs</li>
          <li>SUBMIT ONE DAILY WITHDRAWAL APPLICATION PER DAY OR RISK LOSING YOUR FUNDS.</li>
          <li>Withdrawal Time: 07:00 AM - 5:00 PM (Normal withdrawal on weekends)</li>
          <li>Arrival time: 10 minutes - 24 hours (subject to bank transfer time)</li>
          <li>10% Tax will be Applied on each Withdrawal</li>
          <li>"WE STRIVE TO PROCESS YOUR WITHDRAWALS AS QUICKLY AS POSSIBLE. WE APPRECIATE YOUR PATIENCE."</li>
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
document.getElementById("withdraw-form").addEventListener("submit", function (event) {
    event.preventDefault();
    var currentTime = new Date();
    var currentHour = currentTime.getHours();
    if (currentHour < 7 || currentHour > 17) {
        document.getElementById("alert-div2").style.display = "block";
        document.getElementById("alert-message2").textContent = "The Withdrawal Application can only be submitted between 7:00 AM and 5:00 PM.";
        document.getElementById("alert-message2").classList.add("alert", "alert-danger");
        document.getElementById("alert-div1").style.display = "none";
        return;
    }
    var amount = document.getElementById("amount").value;
    var withdrawalPassword = document.getElementById("withdrawalPassword").value;
    var formData = { amount: amount, withdrawalPassword: withdrawalPassword };
    fetch("php/post_values.php", { method: "POST", body: JSON.stringify(formData), headers: { "Content-Type": "application/json" } })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                document.getElementById("alert-div1").style.display = "block";
                document.getElementById("alert-message1").innerHTML = data.message;
                document.getElementById("alert-message1").classList.add("alert", "alert-success");
                document.getElementById("alert-div2").style.display = "none";
            } else {
                document.getElementById("alert-div2").style.display = "block";
                document.getElementById("alert-message2").innerHTML = data.message;
                document.getElementById("alert-message2").classList.add("alert", "alert-danger");
                document.getElementById("alert-div1").style.display = "none";
            }
        })
        .catch((error) => {
            console.error("An error occurred:", error);
        });
});
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>

</html>