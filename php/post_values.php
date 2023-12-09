<?php
// file: post_values.php
require('config.php'); // Connection to the database

$response = array();
function calculateReward($conn)
{
    $mobile = $_SESSION['mobile'];
    // Query to get previousUserMobile and presentUserMobile
    $sql = "SELECT previousUserMobile, presentUserMobile
            FROM invite
            WHERE presentUserMobile = '$mobile'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $inviteRow = mysqli_fetch_assoc($result);
        $previousUserMobile = $inviteRow['previousUserMobile'];
        $presentUserMobile = $inviteRow['presentUserMobile'];
        // Query to get reward for the previousUserMobile
        $sql = "SELECT reward
                FROM flags
                WHERE mobile = '$previousUserMobile'";
        $sql2 = "SELECT purchase
        FROM flags
        WHERE mobile = '$presentUserMobile'";
        $result = mysqli_query($conn, $sql);
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $row2 = mysqli_fetch_assoc($result2);
            $reward = intval($row['reward']);
            $purchase = intval($row2['purchase']);
            // Check if purchase is initially 0 for presentUserMobile
            if ($purchase == 0) {
                // Increment the purchase by 1 for presentUserMobile
                $purchase += 1;
                $updatePurchaseSql = "UPDATE flags SET purchase = $purchase WHERE mobile = '$presentUserMobile'";
                mysqli_query($conn, $updatePurchaseSql);
                // Increment the reward by 1 for previousUserMobile
                $reward += 1;
                $updateRewardSql = "UPDATE flags SET reward = $reward WHERE mobile = '$previousUserMobile'";
                mysqli_query($conn, $updateRewardSql);
            }
            // Return the reward as an array
            $rewardData = array(
                "reward" => $reward,
                "purchase" => $purchase
            );
            return $rewardData;
        }
    }
    // Return an array with reward and purchase both as 0 if no reward is available or applicable
    return array("reward" => 0, "purchase" => 0);
}

$input = json_decode(file_get_contents('php://input'), true);
// Extract recharge data if available
$newRecharge = isset($input['recharge']) ? $input['recharge'] : null;
if ($newRecharge !== null) {
    // Update balance for recharge
    $sql = "UPDATE register SET recharge = $newRecharge WHERE mobile = '$mobile'";
    if (mysqli_query($conn, $sql)) {
        $response = array("success" => true, "message" => "Balance updated successfully.");
    } else {
        $response = array("success" => false, "message" => "Error occurred while updating balance.");
    }
}
if (!empty($input["product"])) {
    // Insert purchase data
    $product = $conn->real_escape_string($input["product"]);
    $investMoney = (int) str_replace(',', '', $conn->real_escape_string($input["investMoney"]));
    $incomeDaily = (int) str_replace(',', '', $conn->real_escape_string($input["incomeDaily"]));
    $incomeDays = (int) $conn->real_escape_string($input["incomeDays"]);
    $total_income = (int) str_replace(',', '', $conn->real_escape_string($input["total_income"]));
    $gift = (int) $conn->real_escape_string($input["gift"]);
    // Insert the purchase data into the database
    $query = "INSERT INTO purchases (mobile, product, invest_money, income_daily, income_days, total_income, gift, purchase_date) VALUES ('$mobile', '$product', $investMoney, $incomeDaily, $incomeDays, $total_income, $gift, '$dateAndTime')";
    if ($conn->query($query)) {
        $response = array(
            "success" => true,
            "message" => $product . " Purchased successfully!"
        );
        if ($product !== "Daily Income Free") {
            $rewardData = calculateReward($conn); // calculate if it's the 1st purchase or not
            $response = array_merge($response, $rewardData);
        } else {
            $rewardData = array("reward" => 0, "purchase" => 0);
            $response = array_merge($response, $rewardData);
        }
    } else {
        $response = array(
            "success" => false,
            "message" => "Failed to store purchase data: " . $conn->error
        );
    }
} elseif (!empty($input["presentUserMobile"])) {
    // Update balances
    $presentUserMobile = $input["presentUserMobile"];
    $investMoney = $input["investMoney"];
    $level1Mobile = $input["level1Mobile"];
    $level2Mobile = $input["level2Mobile"];
    $level3Mobile = $input["level3Mobile"];
    $newBalance1 = $input["balance1"];
    $newBalance2 = $input["balance2"];
    $newBalance3 = $input["balance3"];
    $newbyinvite1 = $input["byinvite1"];
    $newbyinvite2 = $input["byinvite2"];
    $newbyinvite3 = $input["byinvite3"];
    // Check if the investMoney value is empty
    if (empty($investMoney)) {
        $response = array("success" => false, "message" => "Investment amount is missing or invalid.");
        echo json_encode($response);
        exit();
    }
    // Flag variable to track errors
    $errorFlag = false;
    // Update the invested for presentUserMobile
    if (!empty($presentUserMobile)) {
        $sql = "UPDATE register SET invested = invested + $investMoney WHERE mobile = '$presentUserMobile'";
        if (!mysqli_query($conn, $sql)) {
            // Error occurred while updating invested for presentUserMobile
            $response = array("success" => false, "message" => "Error occurred while updating invested for presentUserMobile: " . mysqli_error($conn));
            $errorFlag = true;
        }
    }
    // Update the balances for level1Mobile, level2Mobile, and level3Mobile
    if (!empty($level1Mobile)) {
        $sql = "UPDATE register SET balance = $newBalance1 , byinvite = $newbyinvite1 WHERE mobile = '$level1Mobile'";
        if (!mysqli_query($conn, $sql)) {
            // Error occurred while updating balance for level1Mobile
            $response = array("success" => false, "message" => "Error occurred while updating balance for level1Mobile: " . mysqli_error($conn));
            $errorFlag = true;
        }
    }
    if (!empty($level2Mobile)) {
        $sql = "UPDATE register SET balance = $newBalance2 , byinvite = $newbyinvite2 WHERE mobile = '$level2Mobile'";
        if (!mysqli_query($conn, $sql)) {
            // Error occurred while updating balance for level2Mobile
            $response = array("success" => false, "message" => "Error occurred while updating balance for level2Mobile: " . mysqli_error($conn));
            $errorFlag = true;
        }
    }
    if (!empty($level3Mobile)) {
        $sql = "UPDATE register SET balance = $newBalance3 , byinvite = $newbyinvite3 WHERE mobile = '$level3Mobile'";
        if (!mysqli_query($conn, $sql)) {
            // Error occurred while updating balance for level3Mobile
            $response = array("success" => false, "message" => "Error occurred while updating balance for level3Mobile: " . mysqli_error($conn));
            $errorFlag = true;
        }
    }
    // Check if any errors occurred during the updates
    if ($errorFlag) {
        mysqli_close($conn);
        echo json_encode($response);
        exit();
    }
    $response = array("success" => true, "message" => "Invite Bonus sent successfully. from post_values.php");
} elseif (!empty($input["claimValue"])) {
    // Query for reward information
    $sql = "SELECT reward, rewardbtn1, rewardbtn2, rewardbtn3 FROM flags WHERE mobile = '$mobile'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $reward = $row['reward'];
        $rewardbtn1 = $row['rewardbtn1'];
        $rewardbtn2 = $row['rewardbtn2'];
        $rewardbtn3 = $row['rewardbtn3'];
    }

    $claimValue = intval($input['claimValue']); // Convert to an integer for safety
    $clickbtn = intval($input['clickbtn']); // Convert to an integer for safety
    $success = false; // Initialize success flag as false

    // Check if the clicked button is already claimed
    if ($rewardbtn1 == 1 && $clickbtn === 1) {
        $message = "Already claimed ₹100 reward!";
    } elseif ($rewardbtn2 == 1 && $clickbtn === 2) {
        $message = "Already claimed ₹400 reward!";
    } elseif ($rewardbtn3 == 1 && $clickbtn === 3) {
        $message = "Already claimed ₹1,000 reward!";
    } else {
        // Update the balance in the "register" table for the logged-in user
        $sqlUpdateBalance = "UPDATE register
                            SET balance = balance + $claimValue,
                                byinvite = byinvite + $claimValue
                            WHERE mobile = '$mobile'";
        if (mysqli_query($conn, $sqlUpdateBalance)) {
            // Balance updated successfully, now update the clicked button in the "flags" table
            $sql2 = "";
            if ($clickbtn === 1) {
                $sql2 = "UPDATE flags SET rewardbtn1 = 1 WHERE mobile = '$mobile'";
            } elseif ($clickbtn === 2) {
                $sql2 = "UPDATE flags SET rewardbtn2 = 1 WHERE mobile = '$mobile'";
            } elseif ($clickbtn === 3) {
                $sql2 = "UPDATE flags SET rewardbtn3 = 1 WHERE mobile = '$mobile'";
            }
            if (!empty($sql2)) {
                if (mysqli_query($conn, $sql2)) {
                    // Button updated successfully
                    $success = true;
                    $message = "₹$claimValue claimed successfully!";
                }
            }
        }
    }
    // Prepare the response
    $response = array("success" => $success, "message" => $message);
} elseif (!empty($input["holder_name"])) {
    $inputMobile = $input["mobile"];
    $holderName = $input["holder_name"];
    $accountNumber = $input["account_number"];
    $bankName = $input["bank_name"];
    $ifscCode = $input["ifsc_code"];
    $withdrawalPassword = $input["withdrawalPassword"];

    if ($inputMobile !== $mobile) {
        $response = array(
            'success' => false,
            'message' => 'Registered mobile number is invalid!'
        );
    } else {
        // Check if the withdrawal password matches the one in the register table
        $sql = "SELECT withdrawalPassword 
            FROM register
            WHERE mobile = '$mobile'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $registeredWithdrawalPassword = $row['withdrawalPassword'];
            if ($withdrawalPassword !== $registeredWithdrawalPassword) {
                $response = array(
                    'success' => false,
                    'message' => 'Incorrect withdraw password!'
                );
            } else {
                $newRecord = false;
                // Check if the record already exists in bankdetails table for this mobile
                $sql2 = "SELECT mobile FROM bankdetails WHERE mobile = '$mobile'";
                $result2 = mysqli_query($conn, $sql2);
                if (mysqli_num_rows($result2) > 0) {
                    // Update the existing record
                    $sql2 = "UPDATE bankdetails SET holder_name = '$holderName', account_number = '$accountNumber', bank_name = '$bankName', ifsc_code = '$ifscCode' 
                    WHERE mobile = '$mobile'";
                    $sql3 = "UPDATE withdrawApp SET holder_name = '$holderName', account_number = '$accountNumber', bank_name = '$bankName', ifsc_code = '$ifscCode' 
                    WHERE mobile = '$mobile' AND `limit` = 1";
                    mysqli_query($conn, $sql3);
                } else {
                    // Insert a new record
                    $sql2 = "INSERT INTO bankdetails (mobile, holder_name, account_number, bank_name, ifsc_code) VALUES ('$mobile', '$holderName', '$accountNumber', '$bankName', '$ifscCode')";
                    $newRecord = true;
                }
                if (mysqli_query($conn, $sql2)) {
                    $response = array(
                        'success' => true,
                        'message' => 'Bank Details Successfully Saved!',
                        'newRecord' => $newRecord,
                    );
                }
            }
        }
    }
} elseif (!empty($input["amount"]) && !empty($input["withdrawalPassword"])) {
    $withdrawamount = $input["amount"];
    $withdrawalPassword = $input["withdrawalPassword"];
    $sql = "SELECT withdrawalPassword, balance, withdraw
        FROM register
        WHERE mobile = '$mobile'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $registeredWithdrawalPassword = $row['withdrawalPassword'];
        $balance = $row['balance'];
        $oldwithdrawamount = $row['withdraw'];

        if ($withdrawalPassword !== $registeredWithdrawalPassword) {
            $response = array(
                'success' => false,
                'message' => 'Incorrect Withdrawal password!'
            );
        } elseif ($withdrawamount > $balance) {
            $response = array(
                'success' => false,
                'message' => 'Insufficient Balance!'
            );
        } elseif ($withdrawamount < 150) {
            $response = array(
                'success' => false,
                'message' => 'Withdrawal amount should be at least ₹150'
            );
        } else {
            $sql = "SELECT COUNT(*) AS count
                FROM withdrawApp
                WHERE mobile = '$mobile' AND `limit` <> 0";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $countSubmitted = $row['count'];
            if ($countSubmitted > 0) {
                $response = array(
                    'success' => false,
                    'message' => 'Withdrawal Application already submitted!'
                );
            } else {
                $sql = "SELECT holder_name, account_number, bank_name, ifsc_code
                    FROM bankdetails
                    WHERE mobile = '$mobile'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $account_number = $row['account_number'];
                    $bank_name = $row['bank_name'];
                    $ifsc_code = $row['ifsc_code'];
                    $holder_name = $row['holder_name'];
                    $newwithdrawamount = $withdrawamount - (0.1 * $withdrawamount);
                    $withdrawamountstore = $newwithdrawamount + $oldwithdrawamount;
                    // Insert the withdrawal application
                    $sql = "INSERT INTO withdrawApp (mobile, withdrawamount, account_number, bank_name, ifsc_code, holder_name, `limit`, created_at)
                        VALUES ('$mobile', '$newwithdrawamount', '$account_number', '$bank_name', '$ifsc_code', '$holder_name', 1, '$dateAndTime')"; // Assuming you want to use the current timestamp
                    if (mysqli_query($conn, $sql)) {
                        // Update user's balance and total withdrawn amount
                        $newbalance = $balance - $withdrawamount;
                        $sql = "UPDATE register SET balance = '$newbalance', withdraw = $withdrawamountstore WHERE mobile = '$mobile'";
                        if (mysqli_query($conn, $sql)) {
                            $response = array(
                                'success' => true,
                                'message' => 'Withdrawal Application Successfully Sent!'
                            );
                        }
                    }
                } 
            }
        }
    } 
} elseif (!empty($input["rechargeAmount"]) && !empty($input["utrNumber"])) {
    $rechargeAmount = $input['rechargeAmount'];
    $utrNumber = $input['utrNumber'];
    $existingUtrQuery = "SELECT * FROM rechargeApp WHERE utr_number = '$utrNumber'";
    $existingUtrResult = mysqli_query($conn, $existingUtrQuery);
    if ($existingUtrResult !== false) {
        if (mysqli_num_rows($existingUtrResult) > 0) {
            $existingUtrRow = mysqli_fetch_assoc($existingUtrResult);
            $existingUtrStatus = $existingUtrRow['status'];
            if ($existingUtrStatus === 'Success') {
                $response = array('status' => 'error', 'message' => 'UTR number already used!');
            } elseif ($existingUtrStatus === 'Rejected') {
                $response = array('status' => 'error', 'message' => 'UTR number already used!');
            } elseif ($existingUtrStatus === 'Pending') {
                $response = array('status' => 'error', 'message' => 'UTR number under verification!');
            }
        } else {
            $sql = "INSERT INTO rechargeApp (mobile, recharge_amount, utr_number, created_at) VALUES ('$mobile', '$rechargeAmount', '$utrNumber' ,'$dateAndTime')";
            if (mysqli_query($conn, $sql)) {
                $response = array('status' => 'success', 'message' => 'UTR Number submitted! Please wait until verification is complete.');
            } else {
                $response = array('status' => 'error', 'message' => 'Failed to store recharge details: ' . mysqli_error($conn));
            }
        }
    } else {
        $sql = "INSERT INTO rechargeApp (mobile, recharge_amount, utr_number, created_at) VALUES ('$mobile', '$rechargeAmount', '$utrNumber' ,'$dateAndTime')";
        if (mysqli_query($conn, $sql)) {
            $response = array('status' => 'success', 'message' => 'UTR Number submitted! Please wait until verification is complete.');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to store recharge details: ' . mysqli_error($conn));
        }
    }
}

// Close the database connection
$conn->close();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>