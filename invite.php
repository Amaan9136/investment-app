<?php
require('php/config.php');
$invitationCode2store = 0;
$reward = 0;
$sql = "SELECT invitationCode2store FROM register WHERE mobile='$mobile'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $invitationCode2store = $row['invitationCode2store'];
}
$sql2 = "SELECT reward FROM flags WHERE mobile='$mobile'";
$result2 = mysqli_query($conn, $sql2);
if ($result2 && mysqli_num_rows($result2) > 0) {
  $row2 = mysqli_fetch_assoc($result2);
  $reward = $row2['reward'];
}
$response = array(
  "invitationCode2store" => $invitationCode2store,
  "reward" => $reward,
);
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Invite</title>
  <link rel="icon" href="img/LOGO.png" type="png">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/mainpage.css" rel="stylesheet">
  <style>body{ background: url('img/bgimg.png') no-repeat center/cover; height: 100vh; width: 100vw; margin: 0; padding: 0; color: #fff} h5{ font-size: 26px; text-align: center; margin-bottom: 0; color: #fff} .btn-primary2{ width: 50%; margin: 3px 0 10px; background-color: rgb(105, 4, 11); border: none; padding: 5px; border-radius: 5px; font-size: 14px} .align-c{ display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center} .text-black{ color: black; font-size: 18px} .section-title{ font-size: 20px; margin: 0} .card-text{ font-size: 18px} @media (max-width: 768px){ .container{ max-width: auto}} </style>
</head>

<body>
  <div class="wrapper">
    <div class="content">
      <div class="container container2">
        <h5 class="card-title" style="font-size: 26px;">Invitation Rewards</h5>
        <hr>
      </div>
      <div class="container2" style="margin-left: 2.5%;">
        <p class="item">Direct Recommendation (Level 1): 17%</p><br>
        <p class="item">Indirect Recommendation (Level 2): 2%</p><br>
        <p class="item">Indirect Recommendation (Level 3): 1%</p><br>
        <p class="item">Earn up to 20% of the total investment amount when your friends invest in the platform.</p><br>
        <p class="item">Earn Extra bonus of ₹1,500 everyday by inviting 15 new members from the options below:</p><br>
      </div>
      <div class="card-body align-c">
        <div id="alert-div3">
          <div id="alert-message3" class="alert alert-success fade show" role="alert"></div>
        </div>
        <p class="section-title text-black">Copy your Invite Code:</p>
        <p class="text-black" id="referral-code"></p>
        <button class="btn-primary btn-primary2" onclick="copyToClipboard('referral-code')">Copy Code</button>
        <p class="section-title text-black">Copy your Invite Link:</p>
        <p class="text-black" id="referral-link"></p>
        <button class="btn-primary btn-primary2" onclick="copyToClipboard('referral-link')">Copy Link</button>
        <p class="section-title text-black">Scan Invite QRCode:</p>
        <div id="qrcode" style="margin-top:5px;"></div>
      </div>
      <div class="card-body align-c">
        <div id="alert-div1">
          <div id="alert-message1" class="alert alert-success fade show" role="alert"></div>
        </div>
        <div id="alert-div2">
          <div id="alert-message2" class="alert alert-danger fade show" role="alert"></div>
        </div>
        <p class="section-title text-black">Bonus Invite Rewards:</p>
        <p class="text-black">Invite users and Earn bonus Rewards</p>
        <p class="text-black rewardValue" id="rewardValue1">0 / 3</p>
        <button class="btn-primary btn-primary2" id="rewardButton1" onclick="claim(100,1)">Claim ₹100</button>
        <p class="text-black rewardValue" id="rewardValue2">0 / 8</p>
        <button class="btn-primary btn-primary2" id="rewardButton2" onclick="claim(400,2)">Claim ₹400</button>
        <p class="text-black rewardValue" id="rewardValue3">0 / 15</p>
        <button class="btn-primary btn-primary2" id="rewardButton3" onclick="claim(1000,3)">Claim ₹1,000</button>
      </div>
    </div>
    <footer class="footer">
      <div class="row">
        <div class="col-md-12">
          <div class="btn-group" role="group">
            <button class="btn btn-primary btn-icon btn-underline" id="homeButton" onclick="location.href='mainpage'">
              <img src="img/home.png" alt="Home" class="btn-icon-image">
              <span class="btn-text"><br>Home</span>
            </button>
            <button class="btn btn-primary btn-icon btn-underline" id="teamButton"
              onclick="location.href='inviteRecords'">
              <img src="img/team.png" alt="inviteRecords" class="btn-icon-image">
              <span class="btn-text"><br>Team</span>
            </button>
            <button class="btn btn-primary btn-icon btn-underline active" id="inviteButton"
              onclick="location.href='invite'">
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
  <script>
    var data = <?php echo json_encode($response); ?>; var invitationCode = data.invitationCode2store; document.getElementById("referral-code").innerText = invitationCode; document.getElementById("referral-link").innerText = "https://paisa.great-site.net/?invitationCode=" + invitationCode; var reward = data.reward; document.getElementById('rewardValue1').innerText = reward + ' / 3'; document.getElementById('rewardValue2').innerText = reward + ' / 8'; document.getElementById('rewardValue3').innerText = reward + ' / 15'; var rewardButton1 = document.getElementById('rewardButton1'); var rewardButton2 = document.getElementById('rewardButton2'); var rewardButton3 = document.getElementById('rewardButton3'); rewardButton1.disabled = true; rewardButton2.disabled = true; rewardButton3.disabled = true; if (reward >= 3) rewardButton1.disabled = false; if (reward >= 8) rewardButton2.disabled = false; if (reward >= 15) rewardButton3.disabled = false;
    function copyToClipboard(elementId) { var text = document.getElementById(elementId).innerText; var tempTextArea = document.createElement('textarea'); tempTextArea.value = text; document.body.appendChild(tempTextArea); tempTextArea.select(); document.execCommand('copy'); document.body.removeChild(tempTextArea); var alertDiv = document.getElementById('alert-div3'); var alertMessage = document.getElementById('alert-message3'); if (text.includes('invitationCode')) alertMessage.innerText = 'Invite Link Copied to Clipboard!'; else alertMessage.innerText = 'Invite Code Copied to Clipboard!'; alertDiv.style.display = 'block'; }
    function claim(claimValue, clickbtn) { claimValue = parseInt(claimValue); clickbtn = parseInt(clickbtn); fetch('php/post_values.php', { method: 'POST', body: JSON.stringify({ claimValue: claimValue, clickbtn: clickbtn }), headers: { 'Content-Type': 'application/json' } }).then(response => { if (!response.ok) throw new Error('Network response was not ok'); return response.json(); }).then(data => { var alertDiv1 = document.getElementById('alert-div1'); var alertMessage1 = document.getElementById('alert-message1'); var alertDiv2 = document.getElementById('alert-div2'); var alertMessage2 = document.getElementById('alert-message2'); if (data.success) { alertDiv1.style.display = 'block'; alertMessage1.innerHTML = data.message; alertMessage1.classList.add('alert', 'alert-success'); alertDiv2.style.display = 'none'; } else { alertDiv2.style.display = 'block'; alertMessage2.innerHTML = data.message; alertMessage2.classList.add('alert', 'alert-danger'); alertDiv1.style.display = 'none'; } }); }

    var referrallink = document.getElementById("referral-link").innerText;
    const qrcode = new QRCode(document.getElementById('qrcode'), {
      text: referrallink,
      width: 128,
      height: 128,
      colorDark: 'rgb(69, 1, 5)',
      colorLight: '#fff',
      correctLevel: QRCode.CorrectLevel.H
    });
  </script>

</body>

</html>