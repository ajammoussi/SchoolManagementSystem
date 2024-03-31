<!DOCTYPE html>
<?php
require'database/dbcreation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
    $action = $_POST['action'];
    $fileName = $_POST['fileName'];

    if ($action === 'accept') {
        admissionDB::addStudent_byemail($fileName);
        admissionDB::delete_submission($fileName);
    } elseif ($action === 'refuse') {
        admissionDB::delete_submission($fileName);
    }
}

admissionDB::generate_pdf_for_all_submissions();

$dir = "./admission_pdf/";  // Path to the directory containing the PDF files
$files = scandir($dir);  // Get all files from the directory

$pdfFiles = array_filter($files, function($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';  // Filter only PDF files
});
?>
<html>
<head>
    <style>
        .pdf-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        .pdf-item a {
            flex-grow: 1;
            margin-right: 10px;
        }
        .buttons {
            display: flex;
            flex-direction: column;
        }
        .button {
            margin-bottom: 5px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!--list of request in the form of pdf files -->
    <ul>
        <?php foreach ($pdfFiles as $pdf): ?>
            <li class="pdf-item">
                <a href="<?php echo $dir . $pdf; ?>" target="_blank"><?php echo $pdf; ?></a>
                <div class="buttons">
                    <button class="button accept" data-file="<?php echo $pdf; ?>">Accept</button>
                    <button class="button refuse" data-file="<?php echo $pdf; ?>">Refuse</button>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
        $(document).ready(function() {
            $('.button').click(function() {
                let action = $(this).hasClass('accept') ? 'accept' : 'refuse';
                let fileName = $(this).data('file');

                //applying the change without reloading the whole page
                $.ajax({
                    url: 'admission.php',
                    type: 'POST',
                    //sending the action type and the name of the file to the server
                    data: {
                        action: action,
                        fileName: fileName
                    },
                    success: function(response) {
                        // Handle success
                        console.log(response);
                        location.reload(); // Refresh the page to update the list
                    },
                    error: function(error) {
                        // Handle error
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>
</html>
