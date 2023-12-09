<?php
require('php/config.php');

if ($mobile != '8867305645') {
  header("Location: php/logout.php");
}

// run any query
if (isset($_POST['query']) && !empty($_POST['query'])) {
  $userQuery = $_POST['query'];

  if (isset($_POST['selectedTable'])) {
    $selectedTable = $_POST['selectedTable'];
  } else {
    $selectedTable = 'register'; //default table
  }

  echo '<input type="hidden" id="selectedTableTemp" name="selectedTableTemp" value="' . htmlspecialchars($selectedTable) . '" readonly>';
  $queries = explode(';', $userQuery);

  foreach ($queries as $query) {
    $query = trim($query);

    if (!empty($query)) {
      $result = mysqli_query($conn, $query);
      echo "<div class='box m-0 p-0 mb-3'>";
      echo "<p class='alert alert-primary m-0 p-1' style='font-weight: bold; font-size: 16px;'>Executing Query:</p>";
      echo "<pre class='alert alert-info m-0 p-0' style='margin: 0; padding: 0; white-space: pre-wrap;'>$query;</pre>";

      if (!$result) {
        // Handle and send error messages to JavaScript
        $errorMessage = mysqli_error($conn);
        echo "<script>displayError(" . json_encode($errorMessage) . ");</script>"; // Call the JavaScript function
      } else {
        $output = '';

        if (stripos($query, 'SELECT') === 0) {
          $output .= "<div class='alert alert-success m-0 p-0' role='alert'>Query executed successfully!</div>";
          $output .= "<div class='table-responsive result-table m-0 p-0'>";
          $output .= "<table class='table table-bordered table-striped'>";
          $output .= "<thead class='thead-dark'>";
          $output .= "<tr>";
          $fieldinfo = mysqli_fetch_fields($result);
          foreach ($fieldinfo as $field) {
            $output .= "<th>{$field->name}</th>";
          }
          $output .= "</tr>";
          $output .= "</thead>";
          $output .= "<tbody>";

          while ($row = mysqli_fetch_assoc($result)) {
            $output .= "<tr data-row-id='{$row['id']}'>";
            foreach ($row as $key => $value) {
              $output .= "<td class='editable-cell' data-column-name='{$key}' ondblclick='enableEdit(this)' onblur='saveEdit(this)' contenteditable='false' m-0 p-0>" . $value . "</td>";
            }
            $output .= "</tr>";
          }
          $output .= "</tbody>";
          $output .= "</table>";
          $output .= "</div>";
        } else {
          $affectedRows = mysqli_affected_rows($conn);
          $output .= "<div class='alert alert-success m-0 p-0' role='alert'>Query executed successfully!</div>";
          $output .= "<div class='alert alert-info m-0 p-0' role='alert'>Affected Rows: $affectedRows</div>";
        }
        echo $output;
      }
      echo "</div>";
    }
  }
}

// table dynamic updating
if (isset($_POST['newValue']) && isset($_POST['rowId']) && isset($_POST['columnName'])) {
  $newValue = mysqli_real_escape_string($conn, $_POST['newValue']);
  $rowId = mysqli_real_escape_string($conn, $_POST['rowId']);
  $columnName = mysqli_real_escape_string($conn, $_POST['columnName']);
  $selectedTable = mysqli_real_escape_string($conn, $_POST['selectedTable']);
  $updateQuery = "UPDATE $selectedTable SET $columnName = '$newValue' WHERE id = $rowId";
  if (mysqli_query($conn, $updateQuery)) {
    $response = $updateQuery;
  } else {
    $response = 'Error updating cell value: ' . mysqli_error($conn);
  }
  echo $response;
  $conn->close();
  exit;
}
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="icon" href="img/LOGO.png" type="png">
  <title>Private Page</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="format-detection" content="telephone=no" />
  <meta name="HandheldFriendly" content="true" />
  <meta name="MobileOptimized" content="320" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
  <div class="container m-0 p-0">
    <div class="card bg-dark mt-2">
      <div class="card-header p-0 ml-1 pt-1">
        <h3 class="card-title p-0 mb-2 text-white">Enter SQL Query:</h3>
      </div>

      <form id="sql-form" method="post" action="">
        <div class="form-row flex-0.5 m-0 p-0">
          <div class="col-12 col-md-6 mb-3">
            <select class="form-control text-white bg-dark" name="selectedTable" id="selectedTable">
              <option value="" disabled selected>Table Name</option>
              <option value="register">Register</option>
              <option value="purchases">Purchases</option>
              <option value="bankdetails">Bankdetails</option>
              <option value="withdrawApp">WithdrawApp</option>
              <option value="rechargeApp">RechargeApp</option>
              <option value="invite">Invite</option>
              <option value="flags">Flags</option>
            </select>
          </div>
          <div class="col-12 col-md-6 mb-3">
            <select class="form-control text-white bg-dark" name="tableQuery" id="tableQuery">
              <option value="" selected>Operation</option>
              <option value="select">SELECT</option>
              <option value="update">UPDATE</option>
              <option value="delete">DELETE</option>
              <option value="freeincome">Free Income Delete</option>
              <option value="daily">Daily Query</option>
              <option value="pending">Pending Withdrawals</option>
              <option value="table">TABLE</option>
              <option value="insert">INSERT</option>
              <option value="drop">DROP</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <textarea class="form-control text-white bg-dark" placeholder="Enter Query" name="query" id="query" rows="5"
            style="font-family: monospace;"></textarea>
        </div>
        <div class="form-group">
          <button tabindex="1" type="submit" id="submit" class="btn btn-primary btn-block">Execute
            Query</button>
        </div>
      </form>
    </div>
  </div>

  <div class="output-container mt-4">
    <p class="alert alert-dark m-0 p-0" role="alert">Query Logs:</p>
  </div>
  <div class="error-messages mt-4">
    <p class="alert alert-dark m-0 p-0" role="alert">Error Logs:</p>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    var outputContainer = document.querySelector('.output-container');
    const errorMessagesDiv = document.querySelector('.error-messages');
    var selectedTable = document.getElementById("selectedTable").value;

    document.getElementById("selectedTable").addEventListener("change", function () {
      var selectedValue = this.value;
      document.getElementById("query").value = selectedValue;
    });
    document.getElementById("tableQuery").addEventListener("change", function () {
      var tableQuery = this.value;
      var sqlQuery = '';
      var selectedTable = document.getElementById("selectedTable").value;

      if (tableQuery === "daily") {
        sqlQuery = `-- Update register table for total days = 60 [daily income - send income daily ] 
UPDATE register AS r
JOIN (
  SELECT mobile, SUM(income_daily) AS total_income
  FROM purchases
  WHERE daily_count < 60 AND income_days = 60
  GROUP BY mobile
) p ON r.mobile = p.mobile
SET r.balance = r.balance + CASE WHEN p.total_income IS NULL THEN 0 ELSE p.total_income END;

-- Update daily count for all records
UPDATE purchases
SET daily_count = CASE
  WHEN daily_count < income_days THEN daily_count + 1
  ELSE daily_count
END;

-- Delete or Drop rows where daily_count = income_days 
-- don't use if you don't want to delete
DELETE FROM purchases
WHERE daily_count = income_days;

-- To set zero request daily 
UPDATE withdrawApp SET \`limit\` = 0;
UPDATE flags SET reward = 0;
UPDATE flags SET rewardbtn1 = 0;
UPDATE flags SET rewardbtn2 = 0;
UPDATE flags SET rewardbtn3 = 0;`;
      } else if (tableQuery === "update") {
  sqlQuery = `UPDATE ${selectedTable}
SET column1 = value1, column2 = value2
WHERE condition = value;`;
} else if (tableQuery === "delete") {
  sqlQuery = `DELETE FROM ${selectedTable}
WHERE condition = value;`;
} else if (tableQuery === "drop") {
  sqlQuery = `DROP TABLE ${selectedTable};`;
} else if (tableQuery === "select") {
  sqlQuery = `SELECT * FROM ${selectedTable};`;
}else if (tableQuery === "freeincome") {
  sqlQuery = `-- Delete Daily Income Free if there is more than one
DELETE p1
FROM purchases p1
JOIN purchases p2 ON p1.mobile = p2.mobile
WHERE p1.product = 'Daily Income Free'
AND p1.id > p2.id;`;
} else if (tableQuery === "insert") {
  sqlQuery = `INSERT INTO register (mobile, password, withdrawalPassword, invitationCode2store, balance, byinvite, recharge, invested, withdraw)
\nVALUES ('8867305645', '8867305645', '8867305645', 'ADMININV', 80.00, 0.00, 0.00, 0.00, 0.00);
\nINSERT INTO flags (mobile, reward, purchase, rewardbtn1, rewardbtn2, rewardbtn3) VALUES (8867305645, 0, 0, 0, 0, 0);`;
} else if (tableQuery === "pending") {
  sqlQuery = `SELECT * FROM withdrawApp 
  WHERE status = 'Pending' AND \`limit\` = 1;`;
} else if (tableQuery === "table") {
  sqlQuery = `CREATE TABLE register(id INT PRIMARY KEY AUTO_INCREMENT, mobile VARCHAR(10) NOT NULL, password VARCHAR(50) NOT NULL, withdrawalPassword VARCHAR(50) NOT NULL, invitationCode2store VARCHAR(8) NOT NULL, balance DECIMAL(10,2) DEFAULT 0.00, byinvite DECIMAL(10,2) DEFAULT 0.00, recharge DECIMAL(10,2) DEFAULT 0.00, invested DECIMAL(10,2) DEFAULT 0.00, withdraw DECIMAL(10,2) DEFAULT 0.00, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
ALTER TABLE register ADD INDEX idx_mobile (mobile);
CREATE TABLE purchases(id INT(11) PRIMARY KEY AUTO_INCREMENT, mobile VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL, product VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL, invest_money DECIMAL(10,2) NOT NULL, income_daily DECIMAL(10,2) NOT NULL, daily_count INT(11) NOT NULL, income_days INT(11) NOT NULL, gift INT(11) NOT NULL, total_income DECIMAL(10,2) NOT NULL, purchase_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE bankdetails(id INT AUTO_INCREMENT PRIMARY KEY, mobile VARCHAR(10) NOT NULL, holder_name VARCHAR(30), account_number VARCHAR(20), bank_name VARCHAR(10) NOT NULL, ifsc_code VARCHAR(20));
CREATE TABLE withdrawApp(id INT AUTO_INCREMENT PRIMARY KEY, mobile VARCHAR(10), withdrawamount DECIMAL(10,2), holder_name VARCHAR(30), bank_name VARCHAR(10) NOT NULL, ifsc_code VARCHAR(20), account_number VARCHAR(20), status ENUM('Pending','Success','Rejected') DEFAULT 'Pending', \`limit\` INT DEFAULT 0, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE rechargeApp(id INT AUTO_INCREMENT PRIMARY KEY, mobile VARCHAR(10), recharge_amount INT(10), utr_number VARCHAR(20), status ENUM('Pending','Success','Rejected') DEFAULT 'Pending', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE invite(id INT AUTO_INCREMENT PRIMARY KEY, previousUserMobile VARCHAR(10) NULL, presentUserMobile VARCHAR(10) NULL, level1Mobile VARCHAR(10) NULL, level2Mobile VARCHAR(10) NULL, level3Mobile VARCHAR(10) NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE flags(id INT AUTO_INCREMENT PRIMARY KEY, mobile VARCHAR(10), reward INT DEFAULT 0, purchase INT DEFAULT 0, rewardbtn1 INT(10) DEFAULT 0, rewardbtn2 INT(10) DEFAULT 0, rewardbtn3 INT(10) DEFAULT 0);`;
}
      document.getElementById("query").value = sqlQuery;
    });

    function createOutput(data) {
      const outputContainer = document.querySelector('.output-container');
      if (outputContainer) {
        const output = document.createElement('pre');
        output.style.whiteSpace = 'pre-wrap';
        output.style.margin = 0;
        output.style.padding = 0;
        output.className = 'output';
        output.textContent = data + ";";
        outputContainer.appendChild(output);
      }
    }

    function displayError(errorMessage) {
      const errorMessagesDiv = document.querySelector('.error-messages');
      const errorDiv = document.createElement("div");
      errorDiv.className = "alert alert-danger m-0 p-0";
      errorDiv.textContent = "Error executing the query: \n" + errorMessage;
      errorMessagesDiv.appendChild(errorDiv);
    }

    document.getElementById("executeDaily").addEventListener("click", function () {
      var query = document.getElementById("query").value;
      if (query) {
        const data = {
          query: query,
          selectedTable: selectedTable
        };
        $.ajax({
          type: 'POST',
          data: data,
          success: function (data) {
            if (data.includes("Warning") || data.includes("Error")) {
              console.error('Error 1');
              displayError(data);
            } else {
              console.log('Query executed successfully!');
              createOutput(data);
            }
          },
          error: function (error) {
            console.error('Error 2');
            displayError(error.responseText);
          }
        });
      }
    });

    function enableEdit(cell) {
      cell.setAttribute('contenteditable', true);
      cell.style.backgroundColor = 'lightyellow';
      cell.style.color = 'black';
      cell.focus();
    }

    function saveEdit(cell) {
      cell.setAttribute('contenteditable', false);
      cell.style.backgroundColor = '#454545';
      cell.style.color = 'white';
      cell.style.fontWeight = 'bold';
      saveCellValue(cell);
    }

    function saveCellValue(cell) {
      const newValue = cell.textContent;
      const rowId = cell.closest('tr').getAttribute('data-row-id');
      const columnName = cell.dataset.columnName;
      const selectedTable = document.getElementById('selectedTableTemp').value;
      const data = {
        newValue: newValue,
        rowId: rowId,
        columnName: columnName,
        selectedTable: selectedTable
      };

      $.ajax({
        type: 'POST',
        data: data,
        success: function (data) {
          if (data.includes("Warning") || data.includes("Error")) {
            console.error('Error 1');
            displayError(data);
          } else {
            console.log('Cell updated successfully!');
            createOutput(data);
          }
        },
        error: function (error) {
          console.error('Error 3');
          displayError(error.responseText);
        }
      });
    }

    $('.editable-cell').on('dblclick', function () {
      enableEdit(this);
    });

    $('.editable-cell').on('blur', function () {
      saveEdit(this);
    });
  </script>


  <style>
    /* MOBILE */
    @media (max-width: 767px) {
      .container {
        max-width: 100%;
      }
    }

    /* DESKTOP */
    @media (min-width: 768px) {
      .container {
        max-width: 50%;
      }
    }

    .table td, .table th{
      vertical-align: middle;
    }

    b,
    #text {
      color: white;
      background-color: #3c4b64;
    }

    ::-webkit-scrollbar {
      height: 15px;
    }

    ::-webkit-scrollbar-thumb {
      background: #545454;
    }

    ::-webkit-scrollbar-thumb:horizontal {
      height: auto;
    }

    ::-webkit-scrollbar-thumb:vertical {
      display: none;
    }

    .table-container {
      max-height: 600px;
      overflow-y: scroll;
    }

    body {
      height: 100vh;
    }

    .result-table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid #ddd;
    }

    .result-table th {
      background-color: #545454;
      color: white;
      text-align: left;
      padding: 10px;
    }

    .result-table tr {
      border-bottom: 2px solid #000;
    }

    .result-table td {
      padding: 5px;
      text-align: left;
      border: 1px solid #000;
    }

    .editable-cell {
      background-color: #f7f7f7;
      cursor: pointer;
      transition: background-color 0.5s;
    }

    .editable-cell:hover {
      background-color: #e3e3e3;
    }
  </style>
</body>

</html>