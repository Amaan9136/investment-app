<?php
require('php/config.php'); // Connection to the database

$response = array();

$sql = "SELECT holder_name, account_number, bank_name, ifsc_code FROM bankdetails WHERE mobile = '$mobile'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $response = array(
    "mobile" => $mobile,
    "holder_name" => $row['holder_name'],
    "account_number" => $row['account_number'],
    "bank_name" => $row['bank_name'],
    "ifsc_code" => $row['ifsc_code'],
  );
} else {
  $response = array(
    "mobile" => '',
    "holder_name" => '',
    "account_number" => '',
    "bank_name" => '',
    "ifsc_code" => '',
  );
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Bank Details</title>
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
      background-color: #000000;
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


    .card-title {
      margin-bottom: 0;
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

    input::placeholder {
      color: #000000;
      opacity: 0.9;
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

    .container2 {
      margin: 3px 0px 8px 0px;
      font-size: 14px;
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
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="content">

      <div class="container2 text-white">
        <p>
          "PLEASE ENSURE PRECISION WHEN FILLING IN YOUR BANK DETAILS AS IT CAN ONLY BE SUBMITTED ONCE.
          IN THE EVENT OF ANY ERRORS, DO NOT WORRY. KINDLY REACH OUT TO OUR CUSTOMER CARE FOR ASSISTANCE."
        </p>
      </div>

      <div class="container">
        <div class="card-header">
          <h1 class="card-title">Fill Bank Details</h1>
        </div>
        <form id="bank-form" action="" method="post">
          <div id="alert-div1">
            <div id="alert-message1" class="alert alert-success fade show" role="alert"></div>
          </div>
          <div id="alert-div2">
            <div id="alert-message2" class="alert alert-danger fade show" role="alert"></div>
          </div>
          <input type="text" id="mobile" placeholder="Mobile Number" name="mobile" required
            value="<?php echo $response['mobile']; ?>">
          <input type="text" id="holder_name" placeholder="Full Name" name="holder_name" required
            value="<?php echo $response['holder_name']; ?>">
          <input type="text" id="account_number" placeholder="Account Number" name="account_number" required
            value="<?php echo $response['account_number']; ?>">
          <input type="text" id="bank_name" placeholder="Bank Name" name="bank_name" required
            value="<?php echo $response['bank_name']; ?>">
          <input type="text" id="ifsc_code" placeholder="IFSC Code" name="ifsc_code" required
            value="<?php echo $response['ifsc_code']; ?>">
          <input type="password" id="withdrawalPassword" placeholder="Withdrawal Password" name="withdrawalPassword"
            required>
          <label class="form-label"><a href="contact">Forgot Withdraw Password?</a></label>
          <button type="submit" id="submit" class="btn my-btn">Save Bank Details</button>
        </form>
      </div>


    </div>
    <!-- footer -->
    <footer class="footer">
      <div class="row">
        <div class="col-md-12">
          <div class="btn-group" role="group">
            <button class="btn btn-primary btn-icon btn-underline active" id="homeButton"
              onclick="location.href='mainpage'">
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
  <script src="script/alertmessage.js"></script>
  <script>
    document.getElementById('bank-form').addEventListener('submit', function (event) {
      event.preventDefault();
      var mobile = document.getElementById('mobile').value;
      var holder_name = document.getElementById('holder_name').value;
      var account_number = document.getElementById('account_number').value;
      var bank_name = document.getElementById('bank_name').value;
      var ifsc_code = document.getElementById('ifsc_code').value;
      var withdrawalPassword = document.getElementById('withdrawalPassword').value;
      var formData = {
        mobile: mobile,
        holder_name: holder_name,
        account_number: account_number,
        bank_name: bank_name,
        ifsc_code: ifsc_code,
        withdrawalPassword: withdrawalPassword
      };
      fetch('php/post_values.php', {
        method: 'POST',
        body: JSON.stringify(formData),
        headers: {
          'Content-Type': 'application/json'
        }
      })
        .then(response => {
          return response.json();
        })
        .then(data => {
          if (data.success) {
            showSuccessAlert1(data.message, true, 2500);
            if (data.newRecord) {
              setTimeout(function () {
                document.getElementById('alert-div1').style.display = 'block';
                document.getElementById('alert-message1').textContent = 'Redirecting...';
              }, 1000);
              setTimeout(function () {
                window.location.href = 'withdraw';
              }, 3000);
            }
          } else {
            showDangerAlert2(data.message, false);
          }
        })
        .catch(error => {
          console.error('An error occurred:', error);
        });
    });

  </script>

</body>

</html>