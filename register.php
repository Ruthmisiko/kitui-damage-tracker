<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();
    
    if ($check_email->num_rows > 0) {
        echo "Email already exists. Please use a different email.";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $phone, $email, $password);
        
        if ($stmt->execute()) {
            header("Location: login.html?registration=success");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    
    $stmt->close();
    $check_email->close();
}
$conn->close();
?>