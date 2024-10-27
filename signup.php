<?php

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "user_signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$name = $_POST['name'];
$rollno = $_POST['rollno'];
$password = $_POST['password'];
$cnf_password = $_POST['cnf_password'];


if ($password !== $cnf_password) {
    die("Passwords do not match!");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (name, rollno, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $rollno, $hashed_password);

// Execute the statement and check for success
if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
