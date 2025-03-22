<?php
// Input validation functions that return true/false for error checking during signup

function emptyInputSignup($name, $email, $number, $address, $pwd, $rpwd) {
    // Check if any input field is empty
    return empty($name) || empty($email) || empty($number) || empty($address) || empty($pwd) || empty($rpwd);
}

function invalidPhone($number) {
    // Check if the phone number is less than 11 digits
    return strlen($number) < 11;
}

function invalidEmail($email) {
    // Validate email format using PHP's built-in filter
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function pwdMatch($pwd, $rpwd) {
    // Check if passwords match
    return $pwd === $rpwd;
}

function createUser($name, $email, $address, $pwd, $number) {
    // Database connection details
    $serverName = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "db_ecommerce";

    // Create a new MySQLi connection
    $conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password for security
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    // Use prepared statements to prevent SQL injection
    $sql = $conn->prepare("INSERT INTO customer (customer_fname, customer_email, customer_pwd, customer_phone, customer_address) VALUES (?, ?, ?, ?, ?)");
    if (!$sql) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters to the prepared statement
    $sql->bind_param('sssss', $name, $email, $hashedPwd, $number, $address);

    // Execute the statement
    if ($sql->execute()) {
        // Redirect user to the index page with a success message
        header("location: ../index.php?userSuccessfullycreated!loginNow");
        exit(); // Ensure no further code is executed after redirection
    } else {
        die("Execute failed: " . $sql->error);
    }

    // Close the statement and connection
    $sql->close();
    $conn->close();
}