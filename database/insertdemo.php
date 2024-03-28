<?php
session_start();

// Include the dbcreation.php file
require_once('../database/dbcreation.php');

// Get an instance of the PDO connection
$pdo = ConnexionBD::getInstance();

ConnexionBD::insertData_etudiant(array('firstname' => 'foulen', 'lastname' => 'fouleni',
        'email' => 'hh@gmail.com', 'password' => 'demo1234', 'phone' => 12345678,
        'address' => '5 Rue de la Liberté Tunis', 'birthdate' => '1999-01-01', 'gender' => 'M',
    'nationality' => 'Tunisian', 'field' => 'GL', 'studylevel' => 2, 'class' => 2));