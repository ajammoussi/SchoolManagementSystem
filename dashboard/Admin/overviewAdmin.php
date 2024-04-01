<?php
  session_start();
  require_once('../../database/dbcreation.php');
  $pdo = ConnexionBD::getInstance();
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../main.css" rel="stylesheet">
    <link href="../nav%20bar.css" rel="stylesheet">
    <link href="overviewAdmin.css" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <div class="container-nav">
        <div class="logo-uni-nav">
            <a class="ucar" href="#"><img src="../src/logo-ucar.png"></a>
            <a class="insat" href="#"><img src="../src/logo-insat.png"></a>


        </div>
        <button class="btn btn-deconnect mobile" type="submit" onclick="window.location.href = '../../form/form.php';">Se Déconnecter</button>
        <div class="profile-nav" >
            <p class="username-nav">Welcome, Admin</p>
            <img class="profile-pic-nav" src="../src/profile%20pic.png">
            <button class="btn btn-deconnect" type="submit" onclick="window.location.href = '../../form/form.php';">Se Déconnecter</button>
        </div>

    </div>
</nav>
<main>
    <!-- vertical nav bar -->
    <nav class="main-menu">
        <h1 class="current-nav-element">Menu</h1>
        <img class="logo" src="../src/logo.png" alt="logo" />
        <ul>
            <li class="nav-item-vertical active">
                <b></b>
                <b></b>
                <a href="#">
                    <img src="../src/profile%20pic.png" alt="home img " class="nav-vertical-icons">
                    <span class="nav-text">Overview</span>
                </a>
            </li>

            <!-- <li class="nav-item-vertical">
              <b></b>
              <b></b>
              <a href="#">
                <img src="src/profile pic.png" alt="Profile img " class="nav-vertical-icons">
                <span class="nav-text">Home</span>
              </a>
            </li> -->

            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="#">
                    <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
                    <span class="nav-text">Students</span>
                </a>
            </li>

            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="#">
                    <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
                    <span class="nav-text">Teachers</span>
                </a>
            </li>

            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="#">
                    <!-- <img src="src/abscent white.png" alt="abscence img " class="nav-vertical-icons"> -->
                    <span class="nav-text">Absences</span>
                </a>
            </li>
        </ul>
    </nav>

    <section class="content">

        <div>
            <canvas id="studentsPerYearCanvas"></canvas>
        </div>
        <div>
            <canvas id="abscenceCanvas"></canvas>
        </div>
        <div>
            <canvas id="genderCanvas" ></canvas>
        </div>
        <?php 
            $studentStatistics=ConnexionBD::get_data('studentsPerYear');  
            $abscenceStatistics=ConnexionBD::get_data('abscencePerMonth');  
            $genderStatistics=ConnexionBD::get_data('gender');
        ?>
        <script>
            const studentStatistics = <?= json_encode($studentStatistics) ?> ; 
            const abscenceStatistics = <?= json_encode($abscenceStatistics) ?> ; 
            const genderStatistics = <?= json_encode($genderStatistics) ?> ; 
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="./overviewAdmin.js" type="module"></script>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>


</html>