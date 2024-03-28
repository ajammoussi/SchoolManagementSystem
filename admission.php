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
