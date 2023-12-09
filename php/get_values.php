<?php
// file: get_values.php
require('config.php'); //connection to database

$sql = "SELECT previousUserMobile, presentUserMobile, level1Mobile, level2Mobile, level3Mobile
        FROM invite
        WHERE presentUserMobile = '$mobile'";
$result = mysqli_query($conn, $sql);

$response = array();
if (mysqli_num_rows($result) > 0) {
    $inviteRow = mysqli_fetch_assoc($result);
    $level1Mobile = $inviteRow['level1Mobile'];
    $level2Mobile = $inviteRow['level2Mobile'];
    $level3Mobile = $inviteRow['level3Mobile'];

    $sql = "SELECT balance FROM register WHERE mobile = '$mobile'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $balance = $row['balance'];
    } else {
        $balance = 0;
    }


    if (!empty($level1Mobile)) {
        $sql = "SELECT balance, byinvite FROM register WHERE mobile = '$level1Mobile'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $balance1 = $row['balance'];
            $byinvite1 = $row['byinvite'];
        } else {
            $balance1 = 0;
            $byinvite1 = 0;
        }
    } else {
        $balance1 = 0;
        $byinvite1 = 0;
    }

    if (!empty($level2Mobile)) {
        $sql = "SELECT balance, byinvite FROM register WHERE mobile = '$level2Mobile'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $balance2 = $row['balance'];
            $byinvite2 = $row['byinvite'];
        } else {
            $balance2 = 0;
            $byinvite2 = 0;
        }
    } else {
        $balance2 = 0;
        $byinvite2 = 0;
    }

    if (!empty($level3Mobile)) {
        $sql = "SELECT balance, byinvite FROM register WHERE mobile = '$level3Mobile'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $balance3 = $row['balance'];
            $byinvite3 = $row['byinvite'];
        } else {
            $balance3 = 0;
            $byinvite3 = 0;
        }
    } else {
        $balance3 = 0;
        $byinvite3 = 0;
    }

    // Repeat the same checks for level2Mobile and level3Mobile

    $sql = "SELECT mobile, password, balance, recharge, byinvite, withdrawalPassword
            FROM register
            WHERE mobile = '$mobile'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $mobile = $row['mobile'];
        $password = $row['password'];
        $balance = $row['balance'];
        $byinvite = $row['byinvite'];
        $recharge = $row['recharge'];
        $withdrawalPassword = $row['withdrawalPassword'];

        $sql = "SELECT gift, invest_money , product
                FROM purchases
                WHERE mobile = '$mobile'";

        $result = mysqli_query($conn, $sql);

        $gifts = array();
        $investMoney = array();
        $product = array();

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['gift'] !== null) {
                $gifts[] = $row['gift'];
            }
            if ($row['invest_money'] !== null) {
                $investMoney[] = $row['invest_money'];
            }
            if ($row['product'] !== null) {
                $product[] = $row['product'];
            }
        }

        $response = array(
            "success" => true,
            "mobile" => $mobile,
            "previousUserMobile" => $inviteRow['previousUserMobile'],
            "presentUserMobile" => $mobile,
            "level1Mobile" => $inviteRow['level1Mobile'],
            "level2Mobile" => $inviteRow['level2Mobile'],
            "level3Mobile" => $inviteRow['level3Mobile'],
            "balance1" => $balance1,
            "balance2" => $balance2,
            "balance3" => $balance3,
            "byinvite1" => $byinvite1,
            "byinvite2" => $byinvite2,
            "byinvite3" => $byinvite3,
            "balance" => $balance,
            "byinvite" => $byinvite,
            "recharge" => $recharge,
            "password" => $password,
            "withdrawalPassword" => $withdrawalPassword,
            "gift" => $gifts,
            "product" => $product,
            "invest_money" => $investMoney,
        );
    } else {
        $response = array("success" => false, "message" => "User not found");
    }
} else {
    // User not found in the Invite Table
    $level1Mobile = "";
    $level2Mobile = "";
    $level3Mobile = "";

    $balance1 = 0;
    $balance2 = 0;
    $balance3 = 0;
    $byinvite1 = 0;
    $byinvite2 = 0;
    $byinvite3 = 0;

    $sql = "SELECT mobile, password, balance, recharge, byinvite, withdrawalPassword
    FROM register
    WHERE mobile = '$mobile'";


    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $mobile = $row['mobile'];
        $password = $row['password'];
        $balance = $row['balance'];
        $byinvite = $row['byinvite'];
        $recharge = $row['recharge'];
        $withdrawalPassword = $row['withdrawalPassword'];


        $sql = "SELECT gift, invest_money , product
                FROM purchases
                WHERE mobile = '$mobile'";

        $result = mysqli_query($conn, $sql);

        $gifts = array();
        $investMoney = array();
        $product = array();

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['gift'] !== null) {
                $gifts[] = $row['gift'];
            }
            if ($row['invest_money'] !== null) {
                $investMoney[] = $row['invest_money'];
            }
            if ($row['product'] !== null) {
                $product[] = $row['product'];
            }
        }

        $response = array(
            "success" => true,
            "mobile" => $mobile,
            "previousUserMobile" => "",
            "presentUserMobile" => $mobile,
            "level1Mobile" => $level1Mobile,
            "level2Mobile" => $level2Mobile,
            "level3Mobile" => $level3Mobile,
            "balance1" => $balance1,
            "balance2" => $balance2,
            "balance3" => $balance3,
            "byinvite1" => $byinvite1,
            "byinvite2" => $byinvite2,
            "byinvite3" => $byinvite3,
            "balance" => $balance,
            "byinvite" => $byinvite,
            "recharge" => $recharge,
            "password" => $password,
            "withdrawalPassword" => $withdrawalPassword,
            "gift" => $gifts,
            "product" => $product,
            "invest_money" => $investMoney,
        );
    } else {
        $response = array("success" => false, "message" => "User not found");
    }
}

$conn->close();

header("Content-Type: application/json");
echo json_encode($response);
?>