<?php
// Basic input validation
if(empty($_POST['username']) || empty($_POST['password'])) {
    die('Username and password are required');
}

$username = $_POST['username'];
$password = $_POST['password'];

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Create connection
$conn = new mysqli('localhost','root','','store');

if($conn->connect_error){
    die('Connection failed: '.$conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO loginform (username, password) VALUES(?, ?)");
    if(!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    
    // Corrected bind_param - use 'ss' for two strings, no & before variables
    $stmt->bind_param("ss", $username, $hashed_password);
    
    if($stmt->execute()) {
        echo "Registered successfully...";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>