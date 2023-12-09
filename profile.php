<?php require('php/config.php'); //connection to database 

$sql = "SELECT balance,recharge,byinvite FROM register WHERE mobile = '$mobile'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $balance = $row['balance'];
  $recharge = $row['recharge'];
  $byinvite = $row['byinvite'];
} else {
  $balance = 0;
  $recharge = 0;
  $byinvite = 0;
}
$response = array(
  "mobile" => $mobile,
  "balance" => $balance,
  "recharge" => $recharge,
  "byinvite" => $byinvite,
);
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profile</title>
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

    h5 {
      font-size: 26px;
      text-align: center;
      margin-bottom: 0;
      color: #fff;
    }

    .btn-text1 {
      display: flex;
      justify-content: center;
      font-size: 16px;
      color: #fff;
      font-family: 'Roboto', 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }

    span {
      text-align: middle;
    }

    hr {
      background-color: #fff;
      margin: 1px -5px;
      padding: 2px;
    }

    .my-btn {
      display: block;
      width: 100%;
      align-items: left;
    }

    .btn-text {
      font-size: 16px;
    }

    #mobile.btn-text2.text-white {
      margin-left: -20px;
      text-align: center;
      font-family: 'Roboto', 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
      font-size: 26px;
    }

    .container {
      margin: 15px 5px;
    }

    .text {
      font-size: 14px;
      margin: 6px 0px 0px 0px;
      padding: 0px;
      font-family: 'Roboto', 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }

    .text2 {
      padding: 0px;
      font-size: 14px;
      font-family: 'Roboto', 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }

    .modal-title {
      font-size: 20px;
      font-weight: bold;
      color: black;
    }

    #text {
      color: black;
      font-weight: bold;
    }

    .text-16 {
      font-size: 16px;
    }

    .container3 {
      display: flex;
      justify-content: center;
    }

    .image-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
    }

    .image-container div {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: calc(50% - 2px);
      margin: 1px;
      /* Adjust the margin value as needed */
    }

    .image-container img {
      width: 35px;
      height: 35px;
    }

    .inner-image {
      background-color: rgb(105, 4, 11);
    }

    .logo{
      width: 80px;
      height: 80px;
      margin-right: 20px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="content">

      <div class="container2" style="text-align: center;">
        <img src="img/LOGO.png" class="logo" alt="Mobile" />
        <p class="btn-text2 text-white" id="mobile">
        </p>
        <hr>
      </div>

      <!-- TOP -->
      <div class="container2">
        <div class="row">
          <div class="col-md-12">
            <div class="btn-group" role="group">
            <div class="btn btn-icon">
                <p class="btn-text2" id="balance"></p>
                <p class="btn-text1">Balance</p>
              </div>
              <div class="btn btn-icon">
                <p class="btn-text2" id="recharge"></p>
                <p class="btn-text1">Recharge</p>
              </div>
              <div class="btn btn-icon">
                <p class="btn-text2" id="byinvite"></p>
                <p class="btn-text1">Commission</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Middle Page Jumpers  -->
      <div class=" container2">
        <div class="row">
          <div class="col-md-12">
            <div class="btn-group" role="group">
              <button class="btn btn-primary btn-icon btn-underline" onclick="location.href='recharge'">
                <img src="img/recharge.png" alt="Recharge" class="btn-icon-image">
                <span class="btn-text"><br>Recharge</span>
              </button>
              <button class="btn btn-primary btn-icon btn-underline" onclick="location.href='withdraw'">
                <img src="img/withdraw.png" alt="Withdrawal" class="btn-icon-image">
                <span class="btn-text"><br>Withdraw</span>
              </button>
              <button class="btn btn-primary btn-icon btn-underline" onclick="location.href='contact'">
                <img src="img/online.png" alt="Contact" class="btn-icon-image">
                <span class="btn-text"><br>Contact</span>
              </button>
              <button class="btn btn-primary btn-icon btn-underline" onclick="location.href='about'">
                <img src="img/about.png" alt="About" class="btn-icon-image" id="white">
                <span class="btn-text"><br>About</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Jumpers -->
      <div class="container2">
        <div class="container3 justify-content-between">
          <div class="image-container">
            <div class="inner-image">
              <img src="img/transactionRecords.png" onclick="location.href='transactionRecords'"
                alt="Transaction Records">
              <p class="text-white text-16">Transaction Records</p>
            </div>
            <div class="inner-image">
              <img src="img/inviteRecords.png" onclick="location.href='inviteRecords'" alt="Invite Records">
              <p class="text-white text-16">Team Records</p>
            </div>
            <div class="inner-image">
              <img src="img/myproducts.png" onclick="location.href='myproducts'" alt="My Purchased Products">
              <p class="text-white text-16">My Products</p>
            </div>
            <div class="inner-image">
              <img src="img/bankDetails.png" onclick="location.href='bankDetails'" alt="Bank Details">
              <p class="text-white text-16">Bank Details</p>
            </div>
            <div class="inner-image">
              <img src="img/download.png" onclick="location.href='download'" alt="App Download">
              <p class="text-white text-16">App Download</p>
            </div>
            <div class="inner-image">
              <img src="img/company.png" onclick="location.href='about'" alt="Our Company">
              <p class="text-white text-16">Our Company</p>
            </div>
          </div>
        </div>
        <div class="buttons-container">
          <button class="btn btn-primary btn-underline my-btn btn-text" onclick="confirmLogout()">Logout</button>
        </div>
      </div>


      <!-- About Amount Types Caption -->
      <div class="container2 text-white">
        <hr>
        <h4 class="text">Recharge Amount:</h4>
        <p class="text2">Amount obtained from recharging your account and to make purchases.</p>
        <hr>
        <h4 class="text">Commission Amount:</h4>
        <p class="text2">Amount earned by inviting friends once they make a payment.</p>
        <hr>
        <h4 class="text">Balance Amount:</h4>
        <p class="text2">Available balance used for withdrawal.</p>
        <hr>
      </div>

      <!-- Logout Prompt -->
      <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ModalLabel">Confirm Logout?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p id="text"></p>
            </div>
            <div class="modal-footer">
              <button type="button" id="confirm" onclick="confirmLogout()"
                class="btn my-btn btn-primary">Confirm</button>
              <button type="button" class="btn my-btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>


    </div>
    <!-- footer -->
    <footer class="footer">
    <div class="row">
      <div class="col-md-12">
        <div class="btn-group" role="group">
          <button class="btn btn-primary btn-icon btn-underline" id="homeButton"
            onclick="location.href='mainpage'">
            <img src="img/home.png" alt="Home" class="btn-icon-image">
            <span class="btn-text"><br>Home</span>
          </button>
          <button class="btn btn-primary btn-icon btn-underline" id="teamButton"
            onclick="location.href='inviteRecords'">
            <img src="img/team.png" alt="inviteRecords" class="btn-icon-image">
            <span class="btn-text"><br>Team</span>
          </button>
          <button class="btn btn-primary btn-icon btn-underline" id="inviteButton"
            onclick="location.href='invite'">
            <img src="img/invite.png" alt="Invite" class="btn-icon-image">
            <span class="btn-text"><br>Invite</span>
          </button>
          <button class="btn btn-primary btn-icon btn-underline active" id="profileButton"
            onclick="location.href='profile'">
            <img src="img/my.png" alt="Profile" class="btn-icon-image">
            <span class="btn-text"><br>Profile</span>
          </button>
        </div>
      </div>
    </div>
  </footer>
  </div>

  <!-- Print Details -->
  <script>
        var data = <?php echo json_encode($response); ?>;
        document.getElementById('mobile').textContent = data.mobile;
        document.getElementById('recharge').textContent = data.recharge;
        document.getElementById('byinvite').textContent = data.byinvite;
        document.getElementById('balance').textContent = data.balance;
  </script>

  <!-- logout -->
  <script>
function confirmLogout() {
  const modal = new bootstrap.Modal(document.getElementById('Modal'));
  modal.show();
  document.getElementById('text').textContent = 'Are you sure you want to logout?';

  document.getElementById('confirm').addEventListener('click', () => {
    window.location.href = 'php/logout.php';
  });
}
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>

</html>