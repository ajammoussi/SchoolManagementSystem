<?php
    require_once('../../database/dbcreation.php');
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
            <li class="nav-item-vertical">
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

            <li class="nav-item-vertical active">
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

        <!-- content of profile section  -->
        <div class="container">
            <div class="row">
                <div class="row title">
                    <div class="col-9 student-name-container">
                        <h2 class="student-name">Students </h2>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <div class="row info">
                            <form action="studentsListAdmin.php" method="post">
                                <p>Filter students by:
                                    <span>
                                        <select name="filter" id="filter">
                                            <option value="default">--</option>
                                            <option value="field">Field</option>
                                            <option value="studyLevel">Study Level</option>
                                        </select>
                                    </span>
                                </p>
                                <!-- Select menu for field -->
                                <p id="fieldSelect" hidden> Select a Field:
                                    <select name="field" id="field">
                                        <option value="default">--</option>
                                        <option value="MPI">MPI</option>
                                        <option value="CBA">CBA</option>
                                        <option value="GL">gL</option>
                                        <option value="RT">RT</option>
                                        <option value="IIA">IIA</option>
                                        <option value="IMI">IMI</option>
                                        <option value="CH">CH</option>
                                        <option value="BIO">BIO</option>
                                    </select>
                                </p>

                                <!-- Select menu for study level -->
                                <p id="studyLevelSelect" hidden> Select a study level:
                                    <select name="studyLevel" id="studyLevel">
                                        <option value="default">--</option>
                                        <option value="1">1st Year</option>
                                        <option value="2">2nd Year</option>
                                        <option value="3">3rd Year</option>
                                        <option value="4">4th Year</option>
                                        <option value="5">5th Year</option>
                                    </select>
                                </p>

                                <button class="btn btn-primary submit" type="submit" onclick="window.location.href = 'studentsListAdmin.php';">Filter</button>
                            </div>
                        </form>
                    </div>
                    <?php
                        $students = [];
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $field = $_POST['field'];
                            $studyLevel = $_POST['studyLevel'];
                            $filter = $_POST['filter'];

                            $students = ConnexionBD::showStudents($field, $studyLevel, $filter);
                        }
                    ?>
                    <div class="card card-two">
                        <div class="row info">
                            <!-- bootstrap table -->
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Field</th>
                                        <th scope="col">Study Level</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($students as $student) { ?>
                                            <tr>
                                                <td><?= $student->id ?></td>
                                                <td><?= $student->firstname ?></td>
                                                <td><?= $student->lastname ?></td>
                                                <td><?= $student->field ?></td>
                                                <td><?= $student->studylevel ?></td>
                                            </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of profile section -->
    </section>
</main>
<script src="../script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>



</html>