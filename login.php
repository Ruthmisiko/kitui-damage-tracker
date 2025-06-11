<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start a new session
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Email not found!";
    }
    
    $stmt->close();
}
$conn->close();
?>