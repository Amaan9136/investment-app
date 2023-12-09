<?php
require('php/config.php'); //connection to database

// SQL query
$sql = "SELECT previousUserMobile, presentUserMobile, level1Mobile, level2Mobile, level3Mobile
        FROM invite
        WHERE previousUserMobile = '$mobile'";

// Execute the query
$result = mysqli_query($conn, $sql);

// Prepare an array to store the results
$response = array();

if ($result) {
    // Fetch the data
    while ($inviteRow = mysqli_fetch_assoc($result)) {
        // Get the next users based on the previous user's mobile number
        $level1Mobile = $inviteRow['presentUserMobile'];
        $level2Mobile = null;
        $level3Mobile = null;

        // Get the next user's mobile number for level 2
        $sqlLevel2 = "SELECT presentUserMobile FROM invite WHERE previousUserMobile = '$level1Mobile'";
        $resultLevel2 = mysqli_query($conn, $sqlLevel2);
        if ($resultLevel2 && $rowLevel2 = mysqli_fetch_assoc($resultLevel2)) {
            $level2Mobile = $rowLevel2['presentUserMobile'];

            // Get the next user's mobile number for level 3
            $sqlLevel3 = "SELECT presentUserMobile FROM invite WHERE previousUserMobile = '$level2Mobile'";
            $resultLevel3 = mysqli_query($conn, $sqlLevel3);
            if ($resultLevel3 && $rowLevel3 = mysqli_fetch_assoc($resultLevel3)) {
                $level3Mobile = $rowLevel3['presentUserMobile'];
            }
        }

        // Build the response array for each record
        $record = array(
            "previousUserMobile" => $inviteRow['previousUserMobile'],
            "presentUserMobile" => $inviteRow['presentUserMobile'],
            "level1Mobile" => $level1Mobile,
            "level2Mobile" => $level2Mobile,
            "level3Mobile" => $level3Mobile
        );

        // Retrieve the level 1 data (invested, withdraw, byinvite)
        $sqlLevel1 = "SELECT invested, withdraw, byinvite FROM register WHERE mobile = '$level1Mobile'";
        $resultLevel1 = mysqli_query($conn, $sqlLevel1);
        if ($resultLevel1 && $rowLevel1 = mysqli_fetch_assoc($resultLevel1)) {
            $record['level1Invested'] = $rowLevel1['invested'];
            $record['level1withdraw'] = $rowLevel1['withdraw'];
            $record['level1ByInvite'] = $rowLevel1['byinvite'];
        }

        // Retrieve the level 2 data (invested, withdraw, byinvite)
        if ($level2Mobile) {
            $sqlLevel2 = "SELECT invested, withdraw, byinvite FROM register WHERE mobile = '$level2Mobile'";
            $resultLevel2 = mysqli_query($conn, $sqlLevel2);
            if ($resultLevel2 && $rowLevel2 = mysqli_fetch_assoc($resultLevel2)) {
                $record['level2Invested'] = $rowLevel2['invested'];
                $record['level2withdraw'] = $rowLevel2['withdraw'];
                $record['level2ByInvite'] = $rowLevel2['byinvite'];
            }
        }

        // Retrieve the level 3 data (invested, withdraw, byinvite)
        if ($level3Mobile) {
            $sqlLevel3 = "SELECT invested, withdraw, byinvite FROM register WHERE mobile = '$level3Mobile'";
            $resultLevel3 = mysqli_query($conn, $sqlLevel3);
            if ($resultLevel3 && $rowLevel3 = mysqli_fetch_assoc($resultLevel3)) {
                $record['level3Invested'] = $rowLevel3['invested'];
                $record['level3withdraw'] = $rowLevel3['withdraw'];
                $record['level3ByInvite'] = $rowLevel3['byinvite'];
            }
        }

        // Calculate the sum of investments for all levels
        $sumLevelInvested = ($record['level1Invested'] ?? 0) + ($record['level2Invested'] ?? 0) + ($record['level3Invested'] ?? 0);

        // Add the sum of investments to the record
        $record['sumLevelInvested'] = $sumLevelInvested;

        // Calculate the sum of withdrawals for all levels
        $sumLevelWithdraw = ($record['level1withdraw'] ?? 0) + ($record['level2withdraw'] ?? 0) + ($record['level3withdraw'] ?? 0);

        // Add the sum of withdrawals to the record
        $record['sumLevelWithdraw'] = $sumLevelWithdraw;

        // Calculate the sum of byinvite for all levels
        $sumLevelByInvite = ($record['level1ByInvite'] ?? 0) + ($record['level2ByInvite'] ?? 0) + ($record['level3ByInvite'] ?? 0);

        // Add the sum of byinvite to the record
        $record['sumLevelByInvite'] = $sumLevelByInvite;

        // Add the modified record to the response array
        $response[] = $record;
    }
} else {
    $response = array(
        "success" => false,
        "message" => "Query failed: " . mysqli_error($conn)
    );
}

// If there are no records, set default values
if (empty($response)) {
    $defaultRecord = array(
        "previousUserMobile" => null,
        "presentUserMobile" => null,
        "level1Mobile" => null,
        "level2Mobile" => null,
        "level3Mobile" => null,
        "level1Invested" => 0,
        "level2Invested" => 0,
        "level3Invested" => 0,
        "level1withdraw" => 0,
        "level2withdraw" => 0,
        "level3withdraw" => 0,
        "level1ByInvite" => 0,
        "level2ByInvite" => 0,
        "level3ByInvite" => 0,
        "sumLevelInvested" => 0,
        "sumLevelWithdraw" => 0,
        "sumLevelByInvite" => 0
    );

    $response[] = $defaultRecord;
}

$storedData = array(); // Create an array to store the data

foreach ($response as $record) {
    $storedData[] = array(
        "previousUserMobile" => $record['previousUserMobile'],
        "presentUserMobile" => $record['presentUserMobile'],
        "level1Mobile" => $record['level1Mobile'],
        "level2Mobile" => $record['level2Mobile'],
        "level3Mobile" => $record['level3Mobile'],
        "level1Invested" => $record['level1Invested'],
        "level1withdraw" => $record['level1withdraw'],
        "level1ByInvite" => $record['level1ByInvite'],
        "sumLevelInvested" => $record['sumLevelInvested'],
        "sumLevelWithdraw" => $record['sumLevelWithdraw'],
        "sumLevelByInvite" => $record['sumLevelByInvite']
    );
}
// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Invitation Records</title>
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

    .text-black {
      text-align: start;
      color: black;
    }

    hr {
      background-color: #000000;
      margin: 1px -5px;
      padding: 2px;
    }

    .alert.no-content {
      display: none;
    }

    .alert,
    .alert-message {
      margin: 0;
      padding: 0;
      padding-bottom: 2px;
      font-size: 12px;
      /* Adjust the font size as per your preference */
      font-weight: bold;
    }

    .alert-message:empty {
      display: none;
    }

    br {
      margin: 0;
    }

    .my-btn {
      font-size: 14px;
    }

    .card-title {
      margin: 0;
      font-size: 14px;
      font-family: 'Roboto', 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }

    .card-title2 {
      font-size: 26px;
      font-family: 'Roboto', 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }

    .card-text {
      font-size: 12px;
    }

    .bold {
      font-family: 'Roboto', 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
      font-size: 12px;
      font-weight: 1000;
      /* Increase the font weight for a bolder effect */
      color: #222;
      /* Darken the text color */
    }

    /* Media query for mobile devices */
    @media (max-width: 768px) {
      .container2 {
        margin: 2px;
        margin-top: 5px;
        padding: 1px;
        max-width: auto;
        /* Adjust the maximum width as needed */
      }
    }

    p {
      display: flex;
      text-align: left;
    }

    .btn {
      padding: 5px 5px;
      font-weight: 600;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="content">


      <div class="container container2">
        <h5 class="card-title card-title2 text-white text-center">Invitation Records</h5>
        <p style="font-size: 14px" class="card-text text-center text-white bold" id="total_invest"></p>
        <p style="font-size: 14px" class="card-text text-center text-white bold" id="total_withdraw"></p>
        <p style="font-size: 14px" class="card-text text-center text-white bold" id="total_comm"></p>
      </div>

      <!-- Select Pannel -->
      <div class="container2 container card-header">

        <!-- buttons -->

        <div class="d-flex justify-content-between">
          <div style="flex: 1;">
            <a class="btn btn-underline my-btn btn-primary active btn-block" id="item1-btn">level- 1</a>
          </div>
          <div style="flex: 1;">
            <a class="btn btn-underline my-btn btn-primary btn-block" id="item2-btn">level- 2</a>
          </div>
          <div style="flex: 1;">
            <a class="btn btn-underline my-btn btn-primary btn-block" id="item3-btn">level- 3</a>
          </div>
        </div>


        <!-- Pannel Lists -->

        <div class="col-md-4" id="item1-cards">
          <!-- item1 -->
          <div id="level1mobile-container"></div>
        </div>

        <div class="col-md-4" id="item2-cards" style="display: none;">
          <!-- item2 -->
          <div id="level2mobile-container"></div>
        </div>

        <div class="col-md-4" id="item3-cards" style="display: none;">
          <!-- item3 -->
          <div id="level3mobile-container"></div>
        </div>


      </div>

    </div>
    <!-- footer -->
    <footer class="footer">
      <div class="row">
        <div class="col-md-12">
          <div class="btn-group" role="group">
            <button class="btn btn-primary btn-icon btn-underline" id="homeButton" onclick="location.href='mainpage'">
              <img src="img/home.png" alt="Home" class="btn-icon-image">
              <span class="btn-text"><br>Home</span>
            </button>
            <button class="btn btn-primary btn-icon btn-underline active" id="teamButton"
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

  <!-- use this for multiple buttons -->
  <script>
    // JavaScript code to handle button clicks and show/hide card sections
    const item1Btn = document.getElementById('item1-btn');
    const item2Btn = document.getElementById('item2-btn');
    const item3Btn = document.getElementById('item3-btn');

    const item1Cards = document.getElementById('item1-cards');
    const item2Cards = document.getElementById('item2-cards');
    const item3Cards = document.getElementById('item3-cards');

    item1Btn.addEventListener('click', () => {
      item1Btn.classList.add('active');

      item1Cards.style.display = 'block';
      item2Cards.style.display = 'none';
      item3Cards.style.display = 'none';
    });

    item2Btn.addEventListener('click', () => {
      item2Btn.classList.add('active');

      item1Cards.style.display = 'none';
      item2Cards.style.display = 'block';
      item3Cards.style.display = 'none';
    });

    item3Btn.addEventListener('click', () => {
      item3Btn.classList.add('active');

      item1Cards.style.display = 'none';
      item2Cards.style.display = 'none';
      item3Cards.style.display = 'block';
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Invite Hirarchy Display -->
  <script>
  $(document).ready(function () {
    var data = <?php echo json_encode($storedData); ?>;
    let idCounter = 1;
    const printedRecords = new Set();

    const level1Container = $('#level1mobile-container');
    const level2Container = $('#level2mobile-container');
    const level3Container = $('#level3mobile-container');

    let sumLevelInvested = 0;
    let sumlevelWithdraw = 0;
    let sumlevelByinvite = 0;

    const level1MobileRecords = data.filter(record => record.level1Mobile !== null);
    const level2MobileRecords = data.filter(record => record.level2Mobile !== null);
    const level3MobileRecords = data.filter(record => record.level3Mobile !== null);

    if (level1MobileRecords.length === 0) {
        const noLevel1MembersCard = document.createElement('div');
        noLevel1MembersCard.className = 'card-body card-text text-black';
        noLevel1MembersCard.innerHTML = '<p>No Level-1 Members to Show</p>';
        level1Container.append(noLevel1MembersCard);
    }
    if (level2MobileRecords.length === 0) {
        const noLevel2MembersCard = document.createElement('div');
        noLevel2MembersCard.className = 'card-body card-text text-black';
        noLevel2MembersCard.innerHTML = '<p>No Level-2 Members to Show</p>';
        level2Container.append(noLevel2MembersCard);
    }
    if (level3MobileRecords.length === 0) {
        const noLevel3MembersCard = document.createElement('div');
        noLevel3MembersCard.className = 'card-body card-text text-black';
        noLevel3MembersCard.innerHTML = '<p>No Level-3 Members to Show</p>';
        level3Container.append(noLevel3MembersCard);
    }

    $.each(data, function (index, record) {
      const level1Mobile = record.level1Mobile;
      const level2Mobile = record.level2Mobile;
      const level3Mobile = record.level3Mobile;
      const level1ByInvite = parseFloat(record.level1ByInvite);
      const level2ByInvite = parseFloat(record.level2ByInvite);
      const level3ByInvite = parseFloat(record.level3ByInvite);
      const level1Invested = parseFloat(record.level1Invested);
      const level2Invested = parseFloat(record.level2Invested);
      const level3Invested = parseFloat(record.level3Invested);
      const level1withdraw = parseFloat(record.level1withdraw);
      const level2withdraw = parseFloat(record.level2withdraw);
      const level3withdraw = parseFloat(record.level3withdraw);

      const recordInvestmentSum =
        (isNaN(level1Invested) ? 0 : level1Invested) +
        (isNaN(level2Invested) ? 0 : level2Invested) +
        (isNaN(level3Invested) ? 0 : level3Invested);

      sumLevelInvested += recordInvestmentSum;
      $('#total_invest').html(`Total Team Investment: ₹${sumLevelInvested.toFixed(2)}`);

      const recordWithdrawSum =
        (isNaN(level1withdraw) ? 0 : level1withdraw) +
        (isNaN(level2withdraw) ? 0 : level2withdraw) +
        (isNaN(level3withdraw) ? 0 : level3withdraw);

      sumlevelWithdraw += recordWithdrawSum;
      $('#total_withdraw').html(`Total Team Withdrawal: ₹${sumlevelWithdraw.toFixed(2)}`);
      const recordbyinvite =
        (isNaN(level1ByInvite) ? 0 : level1ByInvite) +
        (isNaN(level2ByInvite) ? 0 : level2ByInvite) +
        (isNaN(level3ByInvite) ? 0 : level3ByInvite);

      sumlevelByinvite += recordbyinvite;
      $('#total_comm').html(`Total Team Commission: ₹${sumlevelByinvite.toFixed(2)}`);

      if (level1Mobile !== null && !printedRecords.has(level1Mobile)) {
        const cardElement = $('<div>').addClass('card-body card-text text-black');
        const cardTitleElement = $('<h5>').addClass('card-title').html(`Invited User: ${idCounter}<hr>`);
        cardElement.append(cardTitleElement);
        const mobileElement = $('<p>').addClass('mobile');
        const mobilePrefix = level1Mobile.slice(0, 3);
        const mobileSuffix = level1Mobile.slice(-3);
        const maskedMobile = `${mobilePrefix}####${mobileSuffix}`;
        mobileElement.html(`Mobile: ${maskedMobile} <br>`);
        cardElement.append(mobileElement);
        const byinviteElement = $('<p>').addClass('byinvite').html(`Commission: ₹${level1ByInvite}<br>`);
        cardElement.append(byinviteElement);
        const investedElement = $('<p>').addClass('invested').html(`Investment: ₹${level1Invested}<br>`);
        cardElement.append(investedElement);
        const withdrawElement = $('<p>').addClass('withdraw').html(`Withdrawn: ₹${level1withdraw}<br>`);
        cardElement.append(withdrawElement);
        level1Container.append(cardElement);
        printedRecords.add(level1Mobile);
        idCounter++;
      }

      if (level2Mobile !== null && !printedRecords.has(level2Mobile)) {
        const cardElement = $('<div>').addClass('card-body card-text text-black');
        const cardTitleElement = $('<h5>').addClass('card-title').html(`Invited User: ${idCounter}<hr>`);
        cardElement.append(cardTitleElement);
        const mobileElement = $('<p>').addClass('mobile');
        const mobilePrefix = level2Mobile.slice(0, 3);
        const mobileSuffix = level2Mobile.slice(-3);
        const maskedMobile = `${mobilePrefix}####${mobileSuffix}`;
        mobileElement.html(`Mobile: ${maskedMobile} <br>`);
        cardElement.append(mobileElement);
        const byinviteElement = $('<p>').addClass('byinvite').html(`Commission: ₹${level2ByInvite}<br>`);
        cardElement.append(byinviteElement);
        const investedElement = $('<p>').addClass('invested').html(`Investment: ₹${level2Invested}<br>`);
        cardElement.append(investedElement);
        const withdrawElement = $('<p>').addClass('withdraw').html(`Withdrawn: ₹${level2withdraw}<br>`);
        cardElement.append(withdrawElement);
        level2Container.append(cardElement);
        printedRecords.add(level2Mobile);
        idCounter++;
      }

      if (level3Mobile !== null && !printedRecords.has(level3Mobile)) {
        const cardElement = $('<div>').addClass('card-body card-text text-black');
        const cardTitleElement = $('<h5>').addClass('card-title').html(`Invited User: ${idCounter}<hr>`);
        cardElement.append(cardTitleElement);
        const mobileElement = $('<p>').addClass('mobile');
        const mobilePrefix = level3Mobile.slice(0, 3);
        const mobileSuffix = level3Mobile.slice(-3);
        const maskedMobile = `${mobilePrefix}####${mobileSuffix}`;
        mobileElement.html(`Mobile: ${maskedMobile} <br>`);
        cardElement.append(mobileElement);
        const byinviteElement = $('<p>').addClass('byinvite').html(`Commission: ₹${level3ByInvite}<br>`);
        cardElement.append(byinviteElement);
        const investedElement = $('<p>').addClass('invested').html(`Investment: ₹${level3Invested}<br>`);
        cardElement.append(investedElement);
        const withdrawElement = $('<p>').addClass('withdraw').html(`Withdrawn: ₹${level3withdraw}<br>`);
        cardElement.append(withdrawElement);
        level3Container.append(cardElement);
        printedRecords.add(level3Mobile);
        idCounter++;
      }
    });
  });
</script>

  <!-- use this for multiple buttons -->
  <script>
    $(document).ready(function () {
      // Add click event handlers to the buttons
      $("#item1-btn").click(function () {
        // Remove active class from all buttons
        $(".my-btn").removeClass("active");
        // Add active class to the clicked button
        $(this).addClass("active ");
      });
      $("#item2-btn").click(function () {
        // Remove active class from all buttons
        $(".my-btn").removeClass("active");
        // Add active class to the clicked button
        $(this).addClass("active");
      });
      $("#item3-btn").click(function () {
        // Remove active class from all buttons
        $(".my-btn").removeClass("active");
        // Add active class to the clicked button
        $(this).addClass("active");
      });
    });
  </script>
</body>

</html>