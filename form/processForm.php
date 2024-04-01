<?php
session_start(); 
// Include the dbcreation.php file
require_once('../database/dbcreation.php');

// Get an instance of the PDO connection
$pdo = ConnexionBD::getInstance();


if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM student WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Authentication successful
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../dashboard/Student/dashboardEtudiant.php");
        exit;
    } else {
        // Invalid email or password
        $_SESSION['error'] = "Invalid email or password";
        header("Location: form.php");
        exit;
    }
} else {
    // Handle case when email or password is not provided
    $_SESSION['error'] = "Email and password are required.";
    header("Location: form.php");
    exit;
}

