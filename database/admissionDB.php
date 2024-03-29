<?php

require 'fpdf/fpdf.php';

/**
 * *connects to the requests table in the database
 */
class admissionDB
{
  private static $_dbname = "university";
  private static $_user = "root";
  private static $_pwd = "";
  private static $_host = "localhost";
  private static $_bdd = null;
  private function __construct()
  {
    try {
      self::$_bdd = new PDO("mysql:host=" . self::$_host . ";dbname=" . self::$_dbname . ";charset=utf8", self::$_user, self::$_pwd,    array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));
    } catch (PDOException $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }
  public static function getInstance()
  {
    if (!self::$_bdd) {
      new admissionDB();
    }
    return (self::$_bdd);
  }

  /**
   * * inserts the new submission in the requests table
   * @param data input of the registration form
   */
  public static function add_submission($data)
  {
      try {
          $pdo = self::getInstance();
          $stmt = $pdo->prepare("INSERT INTO request (firstname, lastname, dob, gender, nationality, email, phone, address, education, program, achievement, essay)
                                  VALUES (:firstname, :lastname, :dob, :gender, :nationality, :email, :phone, :address, :education, :program, :achievement, :essay)");
          $stmt->execute($data);
          echo "Data inserted successfully";
      } catch (PDOException $e) {
          echo "Error inserting data: " . $e->getMessage();
      }
  }

  /**
   * 
   */
  public static function delete_submission($data)
  {
    try{
        $pdo = self::getInstance();
        $req= $pdo->prepare("DELETE FROM request WHERE id = :id");
        $req->execute(array('id' =>$data['id']));
    } catch (PDOException $e) {
        echo "Error inserting data: " . $e->getMessage();
    }
  }

  public static function generate_pdf_for_all_submissions()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT * FROM request");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                self::generate_pdf($row);
            }

            echo "PDF files generated successfully";
        } catch (PDOException $e) {
            echo "Error generating PDF: " . $e->getMessage();
        }
    }

/**
 * *generates a pdf file using the data given in the submission
 * @param data the data given in the submission
 */
    private static function generate_pdf($data)
    {
        $pdf = new FPDF();
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Arial', 'B', 16);

        // Add title
        $pdf->Cell(0, 10, 'Request', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);

        foreach ($data as $key => $value) {
            $pdf->Cell(50, 10, ucfirst(str_replace("_", " ", $key)) . ':', 0, 0);
            $pdf->Cell(0, 10, $value, 0, 1);
        }

        // Save PDF to a file with the email address as the filename
        $pdfFileName = 'admission_pdf/' . $data['email'] . '.pdf';
        $pdf->Output($pdfFileName, 'F');
    }




}
