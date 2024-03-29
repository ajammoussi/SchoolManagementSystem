<?php
session_start();

// Include the dbcreation.php file
require_once('../database/dbcreation.php');

// Get an instance of the PDO connection
$pdo = ConnexionBD::getInstance();

ConnexionBD::insertData_etudiant(array('firstname' => 'foulen', 'lastname' => 'fouleni',
        'email' => 'demo@insat.com', 'password' => 'demo1234', 'phone' => 12345678,
        'address' => '5 Rue de la Liberté Tunis', 'birthdate' => '1999-01-01', 'gender' => 'M',
    'nationality' => 'Tunisian', 'field' => 'GL', 'studylevel' => 2, 'class' => 2));


// // insert demo prof

// ConnexionBD::insertData_prof(array('firstname' => 'prof name', 'lastname' => 'prof lastname',
//         'email' => 'profdemo@insat.com', 'password' => 'profdemo1234', 'phone' => 12345678,
//          'gender' => 'M'));

// // insert demo course
// ConnexionBD::insertData_course(array('coursename' => 'web', 'teacher' => '1'));


// // insert demo abscence
// ConnexionBD::insertData_abscence(array('student' => '2', 'course' => '1', 'absencedate' => '2021-05-01'));
