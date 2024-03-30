<<<<<<< HEAD:admission/admission.php
<!DOCTYPE html>
<?php
require_once('../database/dbcreation.php');

ConnexionBD::generate_pdf_for_all_submissions();

$dir = "./admission_pdf/";  // Path to the directory containing the PDF files
$files = scandir($dir);  // Get all files from the directory

$pdfFiles = array_filter($files, function($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';  // Filter only PDF files
});
?>
<html>
    <ul>
        <?php foreach ($pdfFiles as $pdf): ?>
            <li><a href="<?php echo $dir . $pdf; ?>" target="_blank"><?php echo $pdf; ?></a></li>
        <?php endforeach; ?>
    </ul>
</html>
=======
<!DOCTYPE html>
<?php
require_once('database/admissionDB.php');

admissionDB::generate_pdf_for_all_submissions();

$dir = "./admission_pdf/";  // Path to the directory containing the PDF files
$files = scandir($dir);  // Get all files from the directory

$pdfFiles = array_filter($files, function($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';  // Filter only PDF files
});
?>
<html>
    <ul>
        <?php foreach ($pdfFiles as $pdf): ?>
            <li><a href="<?php echo $dir . $pdf; ?>" target="_blank"><?php echo $pdf; ?></a></li>
        <?php endforeach; ?>
    </ul>
</html>
>>>>>>> 1e0ce9c5e7f8471feac8f422ff79a098afec129b:admission.php
