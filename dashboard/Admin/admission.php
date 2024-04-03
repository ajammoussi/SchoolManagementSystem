<?php
require_once('../database/dbcreation.php');

// Generate PDF files for each submission
ConnexionBD::generate_pdf_for_all_submissions();

// Get the list of PDF files from the admission_pdf folder
$pdfFiles = scandir('admission/admission_pdf');

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $fileName = $_POST['fileName'];

    if ($action == 'accept') {
        ConnexionBD::addStudent_byemail($fileName);
        ConnexionBD::delete_submission($fileName);
    } elseif ($action == 'refuse') {
        ConnexionBD::delete_submission($fileName);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission PDF List</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        ul {
            list-style-type: none;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            border: 1px solid red;
            border-radius: 5px;
            padding: 10px;
            border-right: 1px solid red; /* Added to display the right border */
        }

        button {
            cursor: pointer;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function acceptFile(fileName) {
            $.ajax({
                url: '../database/dbcreation.php',
                type: 'POST',
                data: {
                    action: 'accept',
                    fileName: fileName
                },
                success: function(response) {
                    location.reload(); // Refresh the page to update the list
                }
            });
        }

        function refuseFile(fileName) {
            $.ajax({
                url: '../database/dbcreation.php',
                type: 'POST',
                data: {
                    action: 'refuse',
                    fileName: fileName
                },
                success: function(response) {
                    location.reload(); // Refresh the page to update the list
                }
            });
        }
    </script>
</head>

<body>
    
    <ul>
        <?php
        foreach ($pdfFiles as $file) {
            if ($file != "." && $file != "..") {
                echo "<li>";
                echo "<span><a href='admission/admission_pdf/$file' target='_blank'>$file</a></span>";
                echo "<div class='button-group'>";
                echo "<button class='btn btn-danger mb-2' onclick='acceptFile(\"$file\")'>Accept</button>";
                echo "<button class='btn btn-danger' onclick='refuseFile(\"$file\")'>Refuse</button>";
                echo "</div>";
                echo "</li>";
            }
        }
        ?>
    </ul>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

</body>

</html>
