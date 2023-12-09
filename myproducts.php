<?php
require('php/config.php'); //connection to database

// Fetch Purchase Records
$purchaseSql = "SELECT mobile, product, invest_money, income_daily, total_income, purchase_date, daily_count , income_days FROM purchases WHERE mobile = '$mobile'";
$purchaseResult = mysqli_query($conn, $purchaseSql);

if (mysqli_num_rows($purchaseResult) > 0) {
    while ($row = mysqli_fetch_assoc($purchaseResult)) {
        $mobile = $row['mobile'];
        $product = $row['product'];
        $invest_money = $row['invest_money'];
        $income_daily = $row['income_daily'];
        $income_days = $row['income_days'];
        $total_income = $row['total_income'];
        $purchaseDateTime = $row['purchase_date'];
        $daily_count = $row['daily_count'];

        // Splitting purchaseTime and purchaseDate
        $dateTimeParts = explode(" ", $purchaseDateTime);
        $purchase_time = $dateTimeParts[1];
        $purchase_date = $dateTimeParts[0];

        $response[] = array(
            "mobile" => $mobile,
            "product" => $product,
            "invest_money" => $invest_money,
            "income_daily" => $income_daily,
            "daily_count" => $daily_count,
            "income_days" => $income_days,
            "purchase_date" => $purchase_date,
            "purchase_time" => $purchase_time,
            "total_income" => $total_income
        );
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
  <title>Purchased Products</title>
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
        <h5 class="card-title card-title2 text-white text-center">Purchased Products</h5>
      </div>

      <!-- Select Pannel -->
      <div class="container2 container card-header">

        <!-- buttons -->
        <div class="d-flex justify-content-between" style="margin-bottom: 5px;">
          <div style="flex: 1;">
            <a class="btn btn-underline my-btn btn-primary active btn-block" id="item1-btn">Daily</a>
          </div>
          <div style="flex: 1;">
            <a class="btn btn-underline my-btn btn-primary btn-block" id="item2-btn">Welfare</a>
          </div>
          <div style="flex: 1;">
            <a class="btn btn-underline my-btn btn-primary btn-block" id="item3-btn">All</a>
          </div>
        </div>
        <!-- Pannel Lists -->
        <div class="col-md-4" id="item1-cards">
          <!-- item1 -->
          <div id="stable-container"></div>
        </div>
        <div class="col-md-4" id="item2-cards" style="display: none;">
          <!-- item2 -->
          <div id="welfare-container"></div>
        </div>
        <div class="col-md-4" id="item3-cards" style="display: none;">
          <!-- item3 -->
          <div id="activity-container"></div>
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

  <script>
        var data = <?php echo json_encode($response); ?>;
        const stableContainer = document.getElementById('stable-container');
        const welfareContainer = document.getElementById('welfare-container');
        const activityContainer = document.getElementById('activity-container');

        // Sort the data in descending order based on purchase date and time
        data.sort((a, b) => new Date(b.purchase_date + ' ' + b.purchase_time) - new Date(a.purchase_date + ' ' + a.purchase_time));

        let hasStableRecords = false; // Flag to track if stableContainer has records
        let hasWelfareRecords = false; // Flag to track if welfareContainer has records
        let hasActivityRecords = false; // Flag to track if activityContainer has records


        data.forEach(item => {
          const product = item.product;
          const invest_money = item.invest_money;
          const income_daily = item.income_daily;
          const income_days = item.income_days;
          const daily_count = item.daily_count;
          const purchase_date = item.purchase_date;
          const purchase_time = item.purchase_time;
          const total_income = item.total_income;

          // Create card element
          const cardElement = document.createElement('div');
          cardElement.className = 'card-body card-text text-black';

          // Create and populate card title element (product name)
          const cardTitleElement = document.createElement('h5');
          cardTitleElement.className = 'card-title';
          cardTitleElement.innerHTML = `Product: ${product}<hr>`;
          cardElement.appendChild(cardTitleElement);

          // Create and populate invest money element
          const investMoneyElement = document.createElement('p');
          investMoneyElement.innerHTML = `Invest Money: ₹${invest_money} <br>`;
          cardElement.appendChild(investMoneyElement);

          // Create and populate income daily element
          const incomeDailyElement = document.createElement('p');
          incomeDailyElement.innerHTML = `Income Daily: ₹${income_daily} <br>`;
          cardElement.appendChild(incomeDailyElement);

          // Create and populate daily count element
          const dailyCountElement = document.createElement('p');
          dailyCountElement.innerHTML = `Income Days: ${daily_count} <br>`;
          cardElement.appendChild(dailyCountElement);

          // Create and populate daily count element
          const incomeDaysElement = document.createElement('p');
          incomeDaysElement.innerHTML = `Total Income Days: ${income_days} <br>`;
          cardElement.appendChild(incomeDaysElement);

          // Create and populate total income element
          const totalIncomeElement = document.createElement('p');
          totalIncomeElement.innerHTML = `Total Income: ₹${total_income} <br>`;
          cardElement.appendChild(totalIncomeElement);

          // Create and populate purchase date element
          const purchaseDateElement = document.createElement('p');
          purchaseDateElement.innerHTML = `Purchase Date: ${purchase_date} <br>`;
          cardElement.appendChild(purchaseDateElement);

          if (product.includes('Daily')) {
            stableContainer.appendChild(cardElement.cloneNode(true));
            hasStableRecords = true; // Set the flag to true if records are appended to the stableContainer
          }
          if (product.includes('Welfare')) {
            welfareContainer.appendChild(cardElement.cloneNode(true));
            hasWelfareRecords = true; // Set the flag to true if records are appended to the welfareContainer
          }
          activityContainer.appendChild(cardElement.cloneNode(true));
          hasActivityRecords = true; // Set the flag to true if records are appended to the activityContainer
        });

        if (!hasStableRecords) {
          const noRecordsStableContainer = document.createElement('p');
          noRecordsStableContainer.className = 'card-body card-text text-black';
          noRecordsStableContainer.innerHTML = '<p>No Daily Product Purchased!</p>';
          stableContainer.appendChild(noRecordsStableContainer);
        }

        if (!hasWelfareRecords) {
          const noRecordsWelfareContainer = document.createElement('p');
          noRecordsWelfareContainer.className = 'card-body card-text text-black';
          noRecordsWelfareContainer.innerHTML = '<p>No Welfare Product Purchased!</p>';
          welfareContainer.appendChild(noRecordsWelfareContainer);
        }

        if (!hasActivityRecords) {
          const noRecordsActivityContainer = document.createElement('div');
          noRecordsActivityContainer.className = 'card-body card-text text-black';
          noRecordsActivityContainer.innerHTML = '<p>No Product Purchased!</p>';
          activityContainer.appendChild(noRecordsActivityContainer);
        }
  </script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="script/mainpage.js"></script>

  <!-- use this for multiple buttons -->
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