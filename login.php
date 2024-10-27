<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "user_signup"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$user_input = $_POST['email']; 
$password_input = $_POST['password'];


$stmt = $conn->prepare("SELECT password FROM users WHERE email = ? LIMIT 1"); 
$stmt->bind_param("s", $user_input);

$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashed_password);

if ($stmt->num_rows > 0) {
    $stmt->fetch();
    
  
    if (password_verify($password_input, $hashed_password)) {
        // Successful login
        echo "Login successful! Welcome, " . htmlspecialchars($user_input) . "." ;
        
        exit;
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that username.";
}


$stmt->close();
$conn->close();
?>
