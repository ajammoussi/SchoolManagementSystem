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
//          'gender' => 'Male'));
// ConnexionBD::insertData_prof(array('firstname' => 'profdemo', 'lastname' => 'prof lastname2','email' => 'prof.demo@insat.com', 'password' => 'prof1234', 'phone' => 0123456, 'gender' => 'F'));


// // insert demo course
// ConnexionBD::insertData_course(array('coursename' => 'web', 'teacher' => '1'));
// ConnexionBD::insertData_course(array('coursename' => 'java', 'teacher' => '1'));
// ConnexionBD::insertData_course(array('coursename' => 'python', 'teacher' => '4'));
// ConnexionBD::insertData_course(array('coursename' => 'english', 'teacher' => '5'));


// // insert demo abscence for our student demo (foulene fouleni ) with the id 24
// ConnexionBD::insertData_abscence(array('student' => '24', 'course' => '1', 'absencedate' => '2021-05-01'));
// ConnexionBD::insertData_abscence(array('student' => '24', 'course' => '1', 'absencedate' => '2021-05-02'));
// ConnexionBD::insertData_abscence(array('student' => '24', 'course' => '2', 'absencedate' => '2024-04-01'));
// ConnexionBD::insertData_abscence(array('student' => '19', 'course' => '3', 'absencedate' => '2024-03-22'));
// ConnexionBD::insertData_abscence(array('student' => '19', 'course' => '4', 'absencedate' => '2024-03-22'));
// ConnexionBD::insertData_abscence(array('student' => '17', 'course' => '3', 'absencedate' => '2024-03-22'));
// ConnexionBD::insertData_abscence(array('student' => '18', 'course' => '4', 'absencedate' => '2024-03-26'));
// ConnexionBD::insertData_abscence(array('student' => '17', 'course' => '4', 'absencedate' => '2024-03-28'));


// //insert admin
// ConnexionBD::insertData_admin(array('username' => 'admin', 'email' => 'admin.admin@ucar.tn','password' => 'admin1234'));
