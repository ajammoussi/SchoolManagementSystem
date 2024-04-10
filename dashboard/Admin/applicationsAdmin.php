<?php

require_once('../../database/dbcreation.php');

// Generate PDF files for each submission
ConnexionBD::generate_pdf_for_all_submissions();

// Get the list of PDF files from the admission_pdf folder
$pdfFiles = scandir('../../admission/admission_pdf');

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $fileName = $_POST['fileName'];

    if ($action == 'accept') {
        ConnexionBD::addStudent_byemail($fileName);
        ConnexionBD::delete_submission($fileName);
        header("Location: applicationsAdmin.php"); // Refresh the current page
        exit;
    } elseif ($action == 'refuse') {
        ConnexionBD::delete_submission($fileName);
        header("Location: applicationsAdmin.php"); // Refresh the current page
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">Applications</title>
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
                <h3 class="page-title">Admin's Space</h3>
            </div>
            <button class="btn btn-deconnect mobile" type="submit" onclick="window.location.href = '../../form/form.php';">Se Déconnecter</button>
            <div class="profile-nav">
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
                    <a href="overviewAdmin.php">
                        <span class="nav-text">Overview</span>
                    </a>
                </li>
                <li class="nav-item-vertical">
                    <b></b>
                    <b></b>
                    <a href="studentsListAdmin.php">
                        <span class="nav-text">Students</span>
                    </a>
                </li>
                <li class="nav-item-vertical">
                    <b></b>
                    <b></b>
                    <a href="teachersListAdmin.php">
                        <span class="nav-text">Teachers</span>
                    </a>
                </li>
                <li class="nav-item-vertical">
                    <b></b>
                    <b></b>
                    <a href="absencesAdmin.php">
                        <span class="nav-text">Absences</span>
                    </a>
                </li>
                <li class="nav-item-vertical active">
                    <b></b>
                    <b></b>
                    <a href="#">
                        <span class="nav-text">Applications</span>
                    </a>
                </li>
            </ul>
        </nav>

        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="row title">
                        <div class="col-9 student-name-container">
                            <h2 class="student-name">Applications </h2>
                        </div>
                    </div>

                    <div class="container shadow-sm p-4 rounded">
                        <div class="card-container">
                            <ul class="list-group">
                                <?php
                                foreach ($pdfFiles as $file) {
                                    if ($file != "." && $file != "..") {
                                        echo "<li class='list-group-item d-flex justify-content-between align-items-center' style='border: none; border-radius: 5px; margin-bottom: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: box-shadow 0.3s ease-in-out;'>";
                                        echo "<span><a href='../../admission/admission_pdf/$file' target='_blank' style='color: #dc3545 !important;' class='text-decoration-none'>$file</a></span>";
                                        echo "<div class='button-group'>";
                                        echo "<form method='post'>";
                                        echo "<input type='hidden' name='action' value='accept'>";
                                        echo "<input type='hidden' name='fileName' value='$file'>";
                                        echo "<button type='submit' class='btn btn-danger'>Accept</button>";
                                        echo "</form>";
                                        echo "<form method='post'>";
                                        echo "<input type='hidden' name='action' value='refuse'>";
                                        echo "<input type='hidden' name='fileName' value='$file'>";
                                        echo "<button type='submit' class='btn btn-danger'>Refuse</button>";
                                        echo "</form>";
                                        echo "</div>";
                                        echo "</li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="../script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
