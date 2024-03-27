<?php

require_once('admissionDB.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $data = [
        'firstname' => $_POST['firstName'],
        'lastname' => $_POST['lastName'],
        'dob' => $_POST['dob'],
        'gender' => $_POST['gender'],
        'nationality' => $_POST['nationality'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],     
        'education' => $_POST['education'],
        'program' => $_POST['program'],
        'achievement' => $_POST['achievements'],
        'essay' => $_POST['essay']
    ];

    admissionDB::add_submission($data);
}
?>