<?php
require('php/config.php'); //connection to database

// Fetch Withdraw Records
$withdrawSql = "SELECT withdrawamount, holder_name, status, created_at FROM withdrawApp WHERE mobile = '$mobile'";
$withdrawResult = mysqli_query($conn, $withdrawSql);

if ($withdrawResult) {
    $withdrawIndex = 1; // Start index from 1 for withdraw records

    if (mysqli_num_rows($withdrawResult) > 0) {
        while ($row = mysqli_fetch_assoc($withdrawResult)) {
            $withdrawAmount = $row['withdrawamount'];
            $bankName = $row['holder_name'];
            $status = $row['status'];
            $withdrawDateTime = $row['created_at'];

            // Splitting withdrawTime and withdrawDate
            $dateTimeParts = explode(" ", $withdrawDateTime);
            $withdrawTime = $dateTimeParts[1];
            $withdrawDate = $dateTimeParts[0];

            $response[] = array(
                "withdrawId" => $withdrawIndex,
                "withdrawAmount" => $withdrawAmount,
                "bankName" => $bankName,
                "status" => $status,
                "withdrawTime" => $withdrawTime,
                "withdrawDate" => $withdrawDate
            );

            $withdrawIndex++; // Increment the withdraw index
        }
    } else {
        $response[] = array(
            "withdrawId" => null,
            "withdrawAmount" => null,
            "bankName" => null,
            "status" => null,
            "withdrawTime" => null,
            "withdrawDate" => null
        );
    }
}

// Fetch Recharge Records
$rechargeSql = "SELECT recharge_amount, utr_number, status, created_at FROM rechargeApp WHERE mobile = '$mobile'";
$rechargeResult = mysqli_query($conn, $rechargeSql);

if ($rechargeResult) {
    $rechargeIndex = 1; // Start index from 1 for recharge records

    if (mysqli_num_rows($rechargeResult) > 0) {
        while ($row = mysqli_fetch_assoc($rechargeResult)) {
            $rechargeAmount = $row['recharge_amount'];
            $utrNumber = $row['utr_number'];
            $status = $row['status'];
            $rechargeDateTime = $row['created_at'];

            // Splitting rechargeTime and rechargeDate
            $dateTimeParts = explode(" ", $rechargeDateTime);
            $rechargeTime = $dateTimeParts[1];
            $rechargeDate = $dateTimeParts[0];

            $response[] = array(
                "rechargeId" => $rechargeIndex,
                "rechargeAmount" => $rechargeAmount,
                "utrNumber" => $utrNumber,
                "status" => $status,
                "rechargeTime" => $rechargeTime,
                "rechargeDate" => $rechargeDate
            );

            $rechargeIndex++; // Increment the recharge index
        }
    } else {
        $response[] = array(
            "rechargeId" => null,
            "rechargeAmount" => null,
            "utrNumber" => null,
            "status" => null,
            "rechargeTime" => null,
            "rechargeDate" => null
        );
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Transaction Records</title>
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
        <h5 class="card-title card-title2 text-white text-center">Transaction Records</h5>
      </div>

      <!-- Select Pannel -->
      <div class="container2 container card-header">

        <!-- buttons -->
        <div class="d-flex justify-content-between" style="margin-bottom: 5px;">
          <div style="flex: 1;">
            <a class="btn btn-underline my-btn btn-primary active btn-block" id="item1-btn">Withdraw</a>
          </div>
          <div style="flex: 1;">
            <a class="btn btn-underline my-btn btn-primary btn-block" id="item2-btn">Recharge</a>
          </div>
          <div style="flex: 1;">
            <a class="btn btn-underline my-btn btn-primary btn-block" id="item3-btn">All</a>
          </div>
        </div>

        <!-- Pannel Lists -->

          <div class="col-md-4" id="item1-cards">
            <!-- item1 -->
            <div id="withdraw-container"></div>
          </div>

          <div class="col-md-4" id="item2-cards" style="display: none;">
            <!-- item2 -->
            <div id="recharge-container"></div>
          </div>

          <div class="col-md-4" id="item3-cards" style="display: none;">
            <!-- item3 -->
            <div id="all-container"></div>
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

  <!-- income -->
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

<!-- withdrawjs -->
<script>
    function setStatusClass(status, element) {
    if (status === 'Success') {
      element.classList.add('alert', 'alert-success');
    } else if (status === 'Rejected') {
      element.classList.add('alert', 'alert-danger');
    } else if (status === 'Pending') {
      element.classList.add('alert', 'alert-warning');
    }
  }
var response = <?php echo json_encode($response); ?>;

// Filter response to get only withdrawal records
var withdrawalRecords = response.filter(function(record) {
    return record.withdrawId;
});
const withdrawContainer = document.getElementById('withdraw-container');

if (withdrawalRecords.length === 0) {
    const noRecordsCard = document.createElement('div');
    noRecordsCard.className = 'card-body card-text text-black';
    noRecordsCard.innerHTML = '<p>No Withdraw Records to Show!</p>';
    withdrawContainer.appendChild(noRecordsCard);
  } else {
    withdrawalRecords.forEach(item => {
      if (!item.withdrawAmount) {
        return; // Skip this record if withdrawAmount is null or undefined
      }

      const withdrawAmount = item.withdrawAmount;
      const bankName = item.bankName;
      const status = item.status;
      const createdAtDate = item.withdrawDate;
      const createdAtTime = item.withdrawTime;
      const withdrawId = item.withdrawId; // Add this line to retrieve the ID

      // Create card element
      const cardElement = document.createElement('div');
      cardElement.className = 'card-body card-text text-black';

      // Create and populate card title element (application number)
      const cardTitleElement = document.createElement('h5');
      cardTitleElement.className = 'card-title';
      cardTitleElement.innerHTML = `Withdraw Application: ${withdrawId}<hr>`;
      cardElement.appendChild(cardTitleElement);

      // Create and populate withdraw amount element
      const withdrawAmountElement = document.createElement('p');
      withdrawAmountElement.className = 'withdraw-amount';
      withdrawAmountElement.innerHTML = `Withdraw Amount: ₹${withdrawAmount}<br>`;
      cardElement.appendChild(withdrawAmountElement);

      // Create and populate bank name element
      const bankNameElement = document.createElement('p');
      bankNameElement.className = 'bank-name';
      bankNameElement.innerHTML = `Account Holder: ${bankName}<br>`;
      cardElement.appendChild(bankNameElement);

      // Create and populate created at time element
      const createdAtTimeElement = document.createElement('p');
      createdAtTimeElement.className = 'created_at_time';
      // createdAtTimeElement.innerHTML = `Withdraw Time: ${createdAtTime}<br>`;
      cardElement.appendChild(createdAtTimeElement);

      // Create and populate created at date element
      const createdAtDateElement = document.createElement('p');
      createdAtDateElement.className = 'created_at_date';
      createdAtDateElement.innerHTML = `Withdraw Date: ${createdAtDate}<br>`;
      cardElement.appendChild(createdAtDateElement);

      // Create and populate status element
      const statusElement = document.createElement('p');
      statusElement.className = 'status';
      statusElement.innerHTML = `Withdraw Status: ${status}<br>`;

      setStatusClass(status, statusElement);

      cardElement.appendChild(statusElement);

      // Append card element to the withdraw container
      withdrawContainer.appendChild(cardElement);
    });
  }

</script>

<!-- rechargejs -->
<script>
// Filter response to get only recharge records
var rechargeRecords = response.filter(function(record) {
    return record.rechargeId;
});
const rechargeContainer = document.getElementById('recharge-container');
if (rechargeRecords.length === 0) {
    const noRecordsCard = document.createElement('div');
    noRecordsCard.className = 'card-body card-text text-black';
    noRecordsCard.innerHTML = '<p>No Recharge Records to Show!</p>';
    rechargeContainer.appendChild(noRecordsCard);
  } else {
    rechargeRecords.forEach(item => {
      if (!item.rechargeAmount) {
        return; // Skip this record if rechargeAmount is null or undefined
      }

      const rechargeAmount = item.rechargeAmount;
      const utrNumber = item.utrNumber;
      const status = item.status;
      const createdAtDate = item.rechargeDate;
      const createdAtTime = item.rechargeTime;
      const rechargeId = item.rechargeId; // Replace 'id' with 'rechargeId'

      // Create card element
      const cardElement = document.createElement('div');
      cardElement.className = 'card-body card-text text-black';

      // Create and populate card title element (application number)
      const cardTitleElement = document.createElement('h5');
      cardTitleElement.className = 'card-title';
      cardTitleElement.innerHTML = `Recharge Application: ${rechargeId}<hr>`;
      cardElement.appendChild(cardTitleElement);

      // Create and populate recharge amount element
      const rechargeAmountElement = document.createElement('p');
      rechargeAmountElement.className = 'recharge-amount';
      rechargeAmountElement.innerHTML = `Recharge Amount: ₹${rechargeAmount}<br>`;
      cardElement.appendChild(rechargeAmountElement);

      // Create and populate UTR number element
      const utrNumberElement = document.createElement('p');
      utrNumberElement.className = 'utr-number';
      utrNumberElement.innerHTML = `UTR Number: ${utrNumber}<br>`;
      cardElement.appendChild(utrNumberElement);

      // Create and populate created at time element
      const createdAtTimeElement = document.createElement('p');
      createdAtTimeElement.className = 'created_at_time';
      // createdAtTimeElement.innerHTML = `Recharge Time: ${createdAtTime}<br>`;
      cardElement.appendChild(createdAtTimeElement);

      // Create and populate created at date element
      const createdAtDateElement = document.createElement('p');
      createdAtDateElement.className = 'created_at_date';
      createdAtDateElement.innerHTML = `Recharge Date: ${createdAtDate}<br>`;
      cardElement.appendChild(createdAtDateElement);

      // Create and populate status element
      const statusElement = document.createElement('p');
      statusElement.className = 'status';
      statusElement.innerHTML = `Recharge Status: ${status}<br>`;

      setStatusClass(status, statusElement);

      cardElement.appendChild(statusElement);

      // Append card element to the recharge container
      rechargeContainer.appendChild(cardElement);
    });
  }

</script>

<!-- allrecordjs -->
<script>
  const allRecords = [...response];

  // Combine withdraw and recharge records
  const combinedRecords = allRecords.reduce((combined, record) => {
    if (record.withdrawTime) {
      combined.push({ ...record, time: record.withdrawTime, type: 'Withdraw' });
    }
    if (record.rechargeTime) {
      combined.push({ ...record, time: record.rechargeTime, type: 'Recharge' });
    }
    return combined;
  }, []);

  // Sort the combined records based on time in ascending order
  combinedRecords.sort((a, b) => new Date(a.time) - new Date(b.time));

  const allContainer = document.getElementById('all-container');

  if (combinedRecords.length === 0) {
    const noRecordsCard = document.createElement('div');
    noRecordsCard.className = 'card-body card-text text-black';
    noRecordsCard.innerHTML = '<p>No Records to Show!</p>';
    allContainer.appendChild(noRecordsCard);
  } else {
    combinedRecords.forEach(record => {
      const withdrawId = record.withdrawId;
      const rechargeId = record.rechargeId;
      const id = withdrawId || rechargeId; // Use withdraw ID if available, otherwise use recharge ID

      if (!id) {
        return;
      }

      const withdrawAmount = record.withdrawAmount;
      const bankName = record.bankName;
      const rechargeAmount = record.rechargeAmount;
      const utrNumber = record.utrNumber;
      const withdrawStatus = record.withdrawStatus || record.status; // Use withdraw status if available, otherwise use status
      const rechargeStatus = record.rechargeStatus || record.status; // Use recharge status if available, otherwise use status
      const withdrawDate = record.withdrawDate;
      const withdrawTime = record.withdrawTime;
      const rechargeDate = record.rechargeDate;
      const rechargeTime = record.rechargeTime;
      const type = record.type;

      // Create card element
      const cardElement = document.createElement('div');
      cardElement.className = 'card-body card-text text-black';

      // Create and populate card title element (application number)
      const cardTitleElement = document.createElement('h5');
      cardTitleElement.className = 'card-title';
      cardTitleElement.innerHTML = `${type} Application: ${id}<hr>`;
      cardElement.appendChild(cardTitleElement);

      // Check if it's a withdraw record
      if (withdrawId) {
        // Create and populate withdraw amount element
        const withdrawAmountElement = document.createElement('p');
        withdrawAmountElement.className = 'withdraw-amount';
        withdrawAmountElement.innerHTML = `Withdraw Amount: ₹${withdrawAmount} <br>`;
        cardElement.appendChild(withdrawAmountElement);

        // Create and populate bank name element
        const bankNameElement = document.createElement('p');
        bankNameElement.className = 'bank-name';
        bankNameElement.innerHTML = `Account Holder: ${bankName} <br>`;
        cardElement.appendChild(bankNameElement);

        // Create and populate created at time element
        const createdAtTimeElement = document.createElement('p');
        createdAtTimeElement.className = 'created_at_time';
        // createdAtTimeElement.innerHTML = `Withdraw Time: ${withdrawTime} <br>`;
        cardElement.appendChild(createdAtTimeElement);

        // Create and populate created at date element
        const createdAtDateElement = document.createElement('p');
        createdAtDateElement.className = 'created_at_date';
        createdAtDateElement.innerHTML = `Withdraw Date: ${withdrawDate} <br>`;
        cardElement.appendChild(createdAtDateElement);

        // Create and populate status element
        const statusElement = document.createElement('p');
        statusElement.className = 'status';
        statusElement.innerHTML = `Withdraw Status: ${withdrawStatus} <br>`;

        setStatusClass(withdrawStatus, statusElement);

        cardElement.appendChild(statusElement);
      }

      // Check if it's a recharge
      if (rechargeId) {
        // Create and populate recharge amount element
        const rechargeAmountElement = document.createElement('p');
        rechargeAmountElement.className = 'recharge-amount';
        rechargeAmountElement.innerHTML = `Recharge Amount: ₹${rechargeAmount} <br>`;
        cardElement.appendChild(rechargeAmountElement);

        // Create and populate UTR number element
        const utrNumberElement = document.createElement('p');
        utrNumberElement.className = 'utr-number';
        utrNumberElement.innerHTML = `UTR Number: ${utrNumber} <br>`;
        cardElement.appendChild(utrNumberElement);

        // Create and populate created at time element
        const createdAtTimeElement = document.createElement('p');
        createdAtTimeElement.className = 'created_at_time';
        // createdAtTimeElement.innerHTML = `Recharge Time: ${rechargeTime} <br>`;
        cardElement.appendChild(createdAtTimeElement);

        // Create and populate created at date element
        const createdAtDateElement = document.createElement('p');
        createdAtDateElement.className = 'created_at_date';
        createdAtDateElement.innerHTML = `Recharge Date: ${rechargeDate} <br>`;
        cardElement.appendChild(createdAtDateElement);

        // Create and populate status element
        const statusElement = document.createElement('p');
        statusElement.className = 'status';
        statusElement.innerHTML = `Recharge Status: ${rechargeStatus} <br>`;

        setStatusClass(rechargeStatus, statusElement);

        cardElement.appendChild(statusElement);
      }

      // Append card element to the all container
      allContainer.appendChild(cardElement);
    });
  }

</script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      // Add click event handlers to the buttons
      $("#item1-btn").click(function () {
        // Remove active class from all buttons
        $(".my-btn").removeClass("active");
        // Add active class to the clicked button
        $(this).addClass("active ");

        // Add your code for the "Withdraw" functionality here
      });

      $("#item2-btn").click(function () {
        // Remove active class from all buttons
        $(".my-btn").removeClass("active");
        // Add active class to the clicked button
        $(this).addClass("active");

        // Add your code for the "Recharge" functionality here
      });

      $("#item3-btn").click(function () {
        // Remove active class from all buttons
        $(".my-btn").removeClass("active");
        // Add active class to the clicked button
        $(this).addClass("active");

        // Add your code for the "All Records" functionality here
      });
    });
  </script>

</body>

</html>