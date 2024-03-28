<?php
session_start(); 
// Include the dbcreation.php file
require_once('../database/dbcreation.php');

// Get an instance of the PDO connection
$pdo = ConnexionBD::getInstance();


if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    // Check if the email and password match some predefined values (for demonstration purposes)
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Using prepared statements to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Authentication successful
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../dashboard/dashboard.php");
        exit;
    } else {
        // Invalid email or password
        $_SESSION['error'] = "Invalid email or password".$password;
        header("Location: form.php");
        exit;
    }
} else {
    // Handle case when email or password is not provided
    $_SESSION['error'] = "Email and password are required.";
    header("Location: form.php");
    exit;
}

