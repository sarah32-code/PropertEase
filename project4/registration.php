<?php
$host = "localhost";
$user = "smustafa2";
$pass = "smustafa2";
$dbname = "smustafa2";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql_create_db = "CREATE DATABASE IF NOT EXISTS smustafa2";
if ($conn->query($sql_create_db) === TRUE) {

    $conn->close();
    $conn = new mysqli($host, $user, $pass, "smustafa2");

    $sql_create_table = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,  
    email VARCHAR(50) NOT NULL,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    account_type ENUM('buyer', 'seller', 'admin') NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql_create_table) === TRUE) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $accountType = $_POST['accountType'];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql_insert_user = "INSERT INTO users (first_name, last_name, email, username, password, account_type) 
            VALUES ('$firstName', '$lastName', '$email', '$username', '$hashedPassword', '$accountType')";

            if ($conn->query($sql_insert_user) === TRUE) {
                header("Location: login.html");
                exit;
            } else {
                echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();
