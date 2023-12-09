<?php
// file: login.php

// Database connection setup for 3 php only
// Connect config.php, login.php and register.php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "earnify"; 

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Failed to connect to the database: " . $conn->connect_error);
}

$sessionLifetime = (30  * 24  * 60  * 60 ); // 30 days in seconds (30 days * 24 hours * 60 minutes * 60 seconds)

// Get the login data from the request
$input = json_decode(file_get_contents('php://input'), true);
$mobile = $input["mobile"];
$password = $input["password"];

// Escape special characters to prevent SQL injection
$mobile = $conn->real_escape_string($mobile);
$password = $conn->real_escape_string($password);

// Query the database to check if the mobile number and password match
$result = $conn->query("SELECT * FROM register WHERE mobile = '$mobile'");

if ($result->num_rows === 1) {
    // Mobile number exists, check password
    $row = $result->fetch_assoc();
    if ($row["password"] === $password) {
        // Login successful
        session_start();
        $_SESSION['logged_in'] = true; // Set the logged_in session variable
        $_SESSION['mobile'] = $mobile; // Store the mobile number in the session
        $_SESSION['expiry'] = time() + $sessionLifetime; // Set session expiration time
        
        $response = array(
            "success" => true,
            "message" => "Login successful",
        );
    } else {
        // Invalid password
        $response = array(
            "success" => false,
            "message" => "Invalid password"
        );
    }
} else {
    // Invalid mobile number
    $response = array(
        "success" => false,
        "message" => "Mobile number not registered"
    );
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
