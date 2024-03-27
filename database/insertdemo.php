<?php
session_start(); 
// Include the dbcreation.php file
require_once('../database/dbcreation.php');

// Get an instance of the PDO connection
$pdo = ConnexionBD::getInstance();

ConnexionBD::insertData_etudiant(array('nom' => 'admin', 'prenom' => 'admin', 'filiere' => 'GL', 'classe' => '2/2', 'email' => 'demo@insat.com', 'password' => 'demo1234'));