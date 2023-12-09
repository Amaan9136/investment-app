<?php
// file: post_values.php
require('config.php'); // Connection to the database

$response = array();
$responseMessage = '';
$success = false;
// Retrieve the form data from the POST request

$input = json_decode(file_get_contents('php://input'), true);

if (!empty($input["rechargeAmount"]) && !empty($input["utrNumber"])) {
    // recharge form
    $utrNumber = $input['utrNumber'];
    $rechargeAmount = $input['rechargeAmount'];
    $sql = "SELECT recharge_amount, mobile, status FROM rechargeApp WHERE utr_number = '$utrNumber'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $dbUTRNumber = $utrNumber;
        $dbRechargeAmount = $row['recharge_amount'];
        $dbMobile = $row['mobile'];
        if ($row['status'] === 'Rejected') {
            $responseMessage = "Previous status: Rejected. ";
        } elseif ($row['status'] === 'Success') {
            $responseMessage = "Previous status: Success. ";
            echo json_encode(['message' => $responseMessage]);
            exit;
        }
        if ($utrNumber === $dbUTRNumber && $rechargeAmount === $dbRechargeAmount) {
            $status = 'Success';
            $responseMessage .= "Updated: Success! \nUser Number: $dbMobile";
            $updateSql = "UPDATE rechargeApp SET status = '$status' WHERE utr_number = '$dbUTRNumber'";
            mysqli_query($conn, $updateSql);
            $updateRegisterSql = "UPDATE register SET recharge = recharge + $rechargeAmount WHERE mobile = '$dbMobile'";
            mysqli_query($conn, $updateRegisterSql);
        } else {
            $status = 'Rejected';
            $responseMessage .= "Updated: Rejected! \nUser Number: $dbMobile";
            $updateSql = "UPDATE rechargeApp SET status = '$status' WHERE utr_number = '$dbUTRNumber'";
            if (mysqli_query($conn, $updateSql)) {
                echo json_encode(['message' => $responseMessage]); // Send the response and exit
                exit;
            } else {
                $responseMessage = "Error updating status: " . mysqli_error($conn);
            }
        }
    } else {
        $responseMessage = "UTR number not found in the database!";
    }
    $response = [
        'message' => $responseMessage
    ];
    echo json_encode($response);
    exit;
} elseif (!empty($input["mobile"]) && !empty($input["status"])) {
    // withdraw form
    $FormMobile = $input['mobile'];
    $FormStatus = $input['status'];
    $updateSql = "UPDATE withdrawApp SET status = '$FormStatus' WHERE `limit` = 1 AND mobile = '$FormMobile'";
    if (mysqli_query($conn, $updateSql)) {
        $responseMessage = "Updated status: $FormStatus!";
        // can implement if($FormStatus=='Rejected'){Refund balance to register table + 10% tax}
    } else {
        $responseMessage = "Error updating status: " . mysqli_error($conn);
    }
    $response = [
        'message' => $responseMessage
    ];
} elseif (isset($input["balance"]) && isset($input["recharge"]) && isset($input["mobile2"])) {
    $balance = floatval($input['balance']);
    $recharge = floatval($input['recharge']);
    $mobile2 = $input['mobile2'];


    $sql = "SELECT balance, recharge FROM register WHERE mobile = '$mobile2'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $dbRecharge = floatval($row['recharge']);
        $dbBalance = floatval($row['balance']);

        $newBalance = max(0, $balance + $dbBalance);
        $newRecharge = max(0, $recharge + $dbRecharge);

        $updateSql = "UPDATE register SET balance = $newBalance, recharge = $newRecharge WHERE mobile = '$mobile2'";
        if (mysqli_query($conn, $updateSql)) {
            $responseMessage = "Balance and recharge updated successfully.";
            $success = true;
        } else {
            $responseMessage = "Error updating balance and recharge: " . mysqli_error($conn);
        }
    } else {
        $responseMessage = "User with mobile number '$mobile2' not found.";
    }
    $response = [
        'message' => $responseMessage,
        'success' => $success
    ];
}

// Close the database connection
$conn->close();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>