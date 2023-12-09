<?php
require('php/config.php'); //connection to database
$conn->close();
?>
<!-- this requires two php files: get_values and post_values -->
<!-- stable means daily -->
<!-- welfare means stable -->

<!DOCTYPE html>
<html>

<head>
  <title>Products</title>
  <link rel="icon" href="img/LOGO.png" type="png">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="format-detection" content="telephone=no">
  <meta name="HandheldFriendly" content="true">
  <meta name="MobileOptimized" content="320">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/preloader.css">
  <link href="css/mainpage.css" rel="stylesheet">


  <style>
    body {
      margin: 0;
      padding: 0;
    }

    .d-block,
    .w-100 {
      height: 200px;
    }

    #carouselExample {
      height: 200px;
      /* Set the desired height */
      display: flex;
      align-items: flex-start;
      justify-content: flex-start;
      /* Align to the top */
    }

    p,
    h5 {
      color: #000000;
    }

    .my-btn {
      font-size: 16px;
    }

    .card-title {
      font-size: 16px;
      margin: 0px;
    }

    .active {
      font-weight: bold;
    }

    .btn-underline::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -2px;
      width: 100%;
      height: 2px;
      background-color: #000000;
      transform: scaleX(0);
      transition: transform 0.3s;
    }

    .btn-underline.active::after {
      transform: scaleX(1);
    }

    .col-auto {
      margin: 0px;
    }

    .btn {
      width: 100%;
    }

    .container2 {
      border: none;
    }

    @media (max-width: 768px) {
      .container2 {
        margin: 2px;
        margin-top: 5px;
        padding: 1px;
      }
    }

    .card-text {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .card-text span {
      font-size: 13px;
      color: #000;
      align-items: center;
      display: inline-block;
      margin: 5px;
      padding: 5px;
      border: 1px solid #ccc;
      background-color: #f2f2f2;
    }

    .modal.fade .modal-dialog {
      transform: translate(0, -50%);
      transition: opacity 0.5s ease, transform 0.5s ease;
      opacity: 0;
    }

    .modal.fade.show .modal-dialog {
      transform: translate(0, 0);
      opacity: 1;
    }

    .modal-body{
      padding: 12px;
    }
  </style>

</head>

<body>
  <div id="preloader">
    <img src="img/APP-IMG.png" alt="Preloader Image">
  </div>

  <div class="wrapper">
    <div class="content">
      <!-- Header corosal --> <!--change imgage of mainpage,  about & download -->

      <header class="head">
        <div id="carouselExample" class="carousel slide">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/APP-IMG.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item active">
              <img src="img/1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="img/3.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="img/2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="img/4.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="img/5.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="img/6.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="img/7.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="img/8.jpg" class="d-block w-100" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </header>

      <!-- Middle Page Jumpers  -->
      <div class="container2">
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

      <!-- buttons -->
      <div class="d-flex justify-content-between" style="margin-bottom: 5px;">
        <div style="flex: 1;">
          <a class="btn btn-underline my-btn btn-primary active btn-block" style=""
            id="stable-btn">Daily</a>
          <!-- Daily and Stable both are same -->
        </div>
        <div style="flex: 1;">
          <a class="btn btn-underline my-btn btn-primary btn-block" style=""
            id="welfare-btn">Welfare</a>
        </div>
      </div>

      <!-- income -->
      <div class="container2 container card-header" style="margin-top: 0; padding-top: 0;">

        <!-- Income Lists -->

          <!-- daily -->
          <div class="col-md-4" id="stable-cards">

            <div class="card mb-4">
              <img src="img/0.jpg" class="card-img-top" id="free-card" alt="Daily Free">
              <div class="card-body">
                <h5 class="card-title">Daily Income Free</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹0</span>
                  <span class="text-black">Income Daily: ₹10</span>
                  <span class="text-black">Income Days: 60</span>
                  <span class="text-black">Gift: VIP Level 0</span>
                  <span class="text-black">Total Income: ₹600</span>
                </div>
                <button type="button" class="btn btn-primary" onclick="stable()">Purchase</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/1.jpg" class="card-img-top" alt="Daily 1">
              <div class="card-body">
                <h5 class="card-title">Daily Income 1</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹477</span>
                  <span class="text-black">Income Daily: ₹110</span>
                  <span class="text-black">Income Days: 60</span>
                  <span class="text-black">Gift: VIP Level 1</span>
                  <span class="text-black">Total Income: ₹6,600</span>
                </div>
                <button type="button" class="btn btn-primary" onclick="stable()">Purchase</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/2.jpg" class="card-img-top" alt="Daily 2">
              <div class="card-body">
                <h5 class="card-title">Daily Income 2</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹1,800</span>
                  <span class="text-black">Income Daily: ₹646</span>
                  <span class="text-black">Income Days: 60</span>
                  <span class="text-black">Gift: VIP Level 2</span>
                  <span class="text-black">Total Income: ₹32,760</span>
                </div>
                <button type="button" class="btn btn-primary" onclick="stable()">Purchase</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/3.jpg" class="card-img-top" alt="Daily 3">
              <div class="card-body">
                <h5 class="card-title">Daily Income 3</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹3,700</span>
                  <span class="text-black">Income Daily: ₹1,461</span>
                  <span class="text-black">Income Days: 60</span>
                  <span class="text-black">Gift: VIP Level 3</span>
                  <span class="text-black">Total Income: ₹87,660</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="stable()">Pre-Sale</button>
              </div>
            </div>


            <div class="card mb-4">
              <img src="img/4.jpg" class="card-img-top" alt="Daily 4">
              <div class="card-body">
                <h5 class="card-title">Daily Income 4</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹8,000</span>
                  <span class="text-black">Income Daily: ₹3,800</span>
                  <span class="text-black">Income Days: 60</span>
                  <span class="text-black">Gift: VIP Level 4</span>
                  <span class="text-black">Total Income: ₹228,000</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="stable()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/5.jpg" class="card-img-top" alt="Daily 5">
              <div class="card-body">
                <h5 class="card-title">Daily Income 5</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹16,000</span>
                  <span class="text-black">Income Daily: ₹7,000</span>
                  <span class="text-black">Income Days: 60</span>
                  <span class="text-black">Gift: VIP Level 5</span>
                  <span class="text-black">Total Income: ₹420,000</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="stable()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/6.jpg" class="card-img-top" alt="Daily 6">
              <div class="card-body">
                <h5 class="card-title">Daily Income 6</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹30,000</span>
                  <span class="text-black">Income Daily: ₹14,500</span>
                  <span class="text-black">Income Days: 60</span>
                  <span class="text-black">Gift: VIP Level 6</span>
                  <span class="text-black">Total Income: ₹870,000</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="stable()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/7.jpg" class="card-img-top" alt="Daily 7">
              <div class="card-body">
                <h5 class="card-title">Daily Income 7</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹42,000</span>
                  <span class="text-black">Income Daily: ₹20,160</span>
                  <span class="text-black">Income Days: 60</span>
                  <span class="text-black">Gift: VIP Level 7</span>
                  <span class="text-black">Total Income: ₹12,09,600</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="stable()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/8.jpg" class="card-img-top" alt="Daily 8">
              <div class="card-body">
                <h5 class="card-title">Daily Income 8</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹80,000</span>
                  <span class="text-black">Income Daily: ₹41,600</span>
                  <span class="text-black">Income Days: 60</span>
                  <span class="text-black">Gift: VIP Level 8</span>
                  <span class="text-black">Total Income: ₹24,96,000</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="stable()">Pre-Sale</button>
              </div>
            </div>

            <div class="col-md-4" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">More Deals Soon...</h5>
                <p class="card-text">
                  Stay tuned for further updates as we unveil this game-changing income solution in the near future. Get
                  ready to embark on a transformative journey towards financial prosperity!
                </p>
              </div>
            </div>
          </div>


          <!-- welfare -->
          <div class="col-md-4" id="welfare-cards" style="display: none;">

            <!-- add product -->

            <div class="card mb-4">
              <img src="img/1.jpg" class="card-img-top" alt="Welfare 1">
              <div class="card-body">
                <h5 class="card-title">Welfare Income 1</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹1,000</span>
                  <span class="text-black">Income Daily: ₹700</span>
                  <span class="text-black">Income Days: 3</span>
                  <span class="text-black">Requirement: VIP Level 1</span>
                  <span class="text-black">Total Income: ₹2,100</span>
                </div>
                <button type="button" class="btn btn-primary " onclick="welfare()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/2.jpg" class="card-img-top" alt="Welfare 2">
              <div class="card-body">
                <h5 class="card-title">Welfare Income 2</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹3,500</span>
                  <span class="text-black">Income Daily: ₹1,700</span>
                  <span class="text-black">Income Days: 3</span>
                  <span class="text-black">Requirement: VIP Level 2</span>
                  <span class="text-black">Total Income: ₹5,100</span>
                </div>
                <button type="button" class="btn btn-primary " onclick="welfare()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/3.jpg" class="card-img-top" alt="Welfare 3">
              <div class="card-body">
                <h5 class="card-title">Welfare Income 3</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹6,000</span>
                  <span class="text-black">Income Daily: ₹3,500</span>
                  <span class="text-black">Income Days: 3</span>
                  <span class="text-black">Requirement: VIP Level 3</span>
                  <span class="text-black">Total Income: ₹10,500</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="welfare()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/4.jpg" class="card-img-top" alt="Welfare 4">
              <div class="card-body">
                <h5 class="card-title">Welfare Income 4</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹15,000</span>
                  <span class="text-black">Income Daily: ₹8,000</span>
                  <span class="text-black">Income Days: 3</span>
                  <span class="text-black">Requirement: VIP Level 4</span>
                  <span class="text-black">Total Income: ₹24,000</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="welfare()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/5.jpg" class="card-img-top" alt="Welfare 5">
              <div class="card-body">
                <h5 class="card-title">Welfare Income 5</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹20,000</span>
                  <span class="text-black">Income Daily: ₹13,500</span>
                  <span class="text-black">Income Days: 3</span>
                  <span class="text-black">Requirement: VIP Level 5</span>
                  <span class="text-black">Total Income: ₹40,500</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="welfare()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/6.jpg" class="card-img-top" alt="Welfare 6">
              <div class="card-body">
                <h5 class="card-title">Welfare Income 6</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹29,999</span>
                  <span class="text-black">Income Daily: ₹30,000</span>
                  <span class="text-black">Income Days: 3</span>
                  <span class="text-black">Requirement: VIP Level 6</span>
                  <span class="text-black">Total Income: ₹90,000</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="welfare()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/7.jpg" class="card-img-top" alt="Welfare 7">
              <div class="card-body">
                <h5 class="card-title">Welfare Income 7</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹41,999</span>
                  <span class="text-black">Income Daily: ₹50,000</span>
                  <span class="text-black">Income Days: 3</span>
                  <span class="text-black">Requirement: VIP Level 7</span>
                  <span class="text-black">Total Income: ₹1,50,000</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="welfare()">Pre-Sale</button>
              </div>
            </div>

            <div class="card mb-4">
              <img src="img/8.jpg" class="card-img-top" alt="Welfare 8">
              <div class="card-body">
                <h5 class="card-title">Welfare Income 8</h5>
                <div class="card-text">
                  <span class="text-black">Invest Money: ₹79,999</span>
                  <span class="text-black">Income Daily: ₹1,00,000</span>
                  <span class="text-black">Income Days: 3</span>
                  <span class="text-black">Requirement: VIP Level 8</span>
                  <span class="text-black">Total Income: ₹3,00,000</span>
                </div>
                <button type="button" class="btn btn-primary disabled" onclick="welfare()">Pre-Sale</button>
              </div>
            </div>

            <div class="col-md-4" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">More Welfare Income Soon...</h5>
                <p class="card-text">
                  Stay tuned for further updates as we unveil this game-changing income solution in the near future. Get
                  ready to embark on a transformative journey towards financial prosperity!
                </p>
              </div>
            </div>

          </div>

      </div>
    </div>


    <!-- purchase prompt -->
    <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="purchaseModalLabel">Confirm Purchase?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p id="investMoneyText"></p>
          </div>

          <div class="modal-footer">
            <button type="button" id="confirm" onclick="confirmPurchase()" class="btn btn-primary">Confirm</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
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
          <button class="btn btn-primary btn-icon btn-underline" id="inviteButton"
            onclick="location.href='invite'">
            <img src="img/invite.png" alt="Invite" class="btn-icon-image">
            <span class="btn-text"><br>Invite</span>
          </button>
          <button class="btn btn-primary btn-icon btn-underline" id="profileButton"
            onclick="location.href='profile'">
            <img src="img/my.png" alt="Profile" class="btn-icon-image">
            <span class="btn-text"><br>Profile</span>
          </button>
        </div>
      </div>
    </div>
  </footer>
  </div>


  <!-- SCRIPT -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="script/mainpage.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>

  <!-- PRELOADER -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var preloader = document.getElementById("preloader");

      // Simulating a 2-second delay for demonstration purposes
      setTimeout(function () {
        preloader.style.display = "none";
      }, 100);
    });

    document.addEventListener('DOMContentLoaded', function () {
      var myCarousel = document.querySelector('#carouselExample');
      var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 2000, // Set the interval time in milliseconds (2 seconds)
        pause: false, // Disable pausing on mouse hover
        wrap: true // Enable continuous looping of the carousel
      });

      // Start the carousel
      carousel.cycle();
    });

    // toggle button between welfare and stable
    $(document).ready(function () {
      // Add click event handlers to the buttons
      $("#stable-btn").click(function () {
        // Remove active class from all buttons
        $(".btn-primary").removeClass("active");
        // Add active class to the clicked button
        $(this).addClass("active");
      });

      $("#welfare-btn").click(function () {
        // Remove active class from all buttons
        $(".btn-primary").removeClass("active");
        // Add active class to the clicked button
        $(this).addClass("active");
      });

      $("#activity-btn").click(function () {
        // Remove active class from all buttons
        $(".btn-primary").removeClass("active");
        // Add active class to the clicked button
        $(this).addClass("active");
      });
    });

    // JavaScript code to handle button clicks and show/hide card sections
    const stableBtn = document.getElementById('stable-btn');
    const welfareBtn = document.getElementById('welfare-btn');

    const stableCards = document.getElementById('stable-cards');
    const welfareCards = document.getElementById('welfare-cards');

    stableBtn.addEventListener('click', () => {
      stableBtn.classList.add('active');

      stableCards.style.display = 'block';
      welfareCards.style.display = 'none';
    });

    welfareBtn.addEventListener('click', () => {
      welfareBtn.classList.add('active');

      stableCards.style.display = 'none';
      welfareCards.style.display = 'block';
    });
  </script>

</body>

</html>