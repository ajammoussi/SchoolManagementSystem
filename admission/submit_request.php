<?php

require_once('D:\GL2\Semestre 2\Web\Ateliers\TP PHP\SchoolManagementSystem\database\dbcreation.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get the data from the form
    $data = [
        'firstname' => $_POST['firstName'],
        'lastname' => $_POST['lastName'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'birthdate' => $_POST['birthDate'],
        'gender' => $_POST['gender'],
        'nationality' => $_POST['nationality'],
        'field' => $_POST['field'],
        'education' => $_POST['education'],
        'program' => $_POST['program'],
        'achievement' => $_POST['achievements'],
        'essay' => $_POST['essay']
    ];

    // add the submission to the database
    ConnexionBD::add_submission($data);
}
?>