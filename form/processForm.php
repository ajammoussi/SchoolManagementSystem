<?php
session_start(); 
// Include the dbcreation.php file
require_once('../database/dbcreation.php');

// Get an instance of the PDO connection
$pdo = ConnexionBD::getInstance();


if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    // Check if the email and password match some predefined values (for demonstration purposes)
    $valid_email = "demo@insat.com";
    $valid_password = "demo1234";
    $req=$pdo->prepare("SELECT * FROM etudiant WHERE email = :email AND password = :password");
    $req->execute(array('email' => $_POST['email'], 'password' => $_POST['password']));
    $result = $req->fetch();

    if ($result) {
        // Authentication successful, redirect to our dashboard
        header("Location: ../dashboard/dashboard.php");
        exit;
    } else {
        // if the profile doesn't exist in the database
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: form.php");
        exit;
    }
} else {
    // Handle case when email or password is not provided
    $_SESSION['error'] = "Email and password are required.";
    header("Location: form.php");
    exit;
}

