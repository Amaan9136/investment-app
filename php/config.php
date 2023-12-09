<?php
// file: config.php

// $servername = "sql202.infinityfree.com";
// $username = "if0_35221762";
// $password = "u1Pv1wLoBqeT6c";
// $dbname = "if0_35221762_netflix";

// Database connection setup for 3 php only
// Connect config.php, login.php and register.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "earnify";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Failed to connect to the database: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Kolkata');

// Start the session
session_start();

$mobile = $_SESSION['mobile'];
$dateAndTime = date('Y-m-d H:i:s');

function generateNotLoggedInHTML() {
  return '
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Expired!</title>
    <style>
      body {
        background-color: black;
        margin:0 auto;
        height: 100vh;
      }
      
      .message {
        color: white;
        text-align: center;
        font-size: 24px;
      }
    </style>
  </head>
  <body>
    <div class="message">
    Session Expired!
    </div><br>
    <div class="message">
    User Not Logged In.
    </div>
    <script>
      setTimeout(function() {
        window.location.href = "php/logout.php";
      }, 5000); // Redirect after 5 seconds (adjust as needed)
    </script>
  </body>
  </html>';
}

if (!isset($_SESSION['mobile'])) {
  echo generateNotLoggedInHTML();
  echo '
  <script>
    window.location.href = "php/logout.php";
  </script>';
  exit();
}

if (isset($_SESSION['expiry']) && time() > $_SESSION['expiry']) {
  echo generateNotLoggedInHTML();
  // Session has expired, redirect to the login page
  echo '
  <script>
    window.location.href = "php/logout.php";
  </script>';
  exit;
}
?>