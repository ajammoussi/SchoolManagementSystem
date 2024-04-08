<?php

require_once('fpdf/fpdf.php');

class ConnexionBD
{   
    private static $_dbname = "insatplatform";
    private static $_user = "root";
    private static $_pwd = "";
    private static $_host = "localhost";
    private static $_bdd = null;
    private function __construct()
    {
        try {
            // create database
            self::$_bdd = new PDO("mysql:host=" . self::$_host . ";dbname=" . self::$_dbname .
                ";charset=utf8", self::$_user, self::$_pwd,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));

            // create student table
            self::$_bdd ->query("create table if not exists student 
                    (id INT primary key auto_increment, firstname VARCHAR(50),
                    lastname VARCHAR(50), email VARCHAR(50), password VARCHAR(50),
                    phone INT(8), address VARCHAR(80), birthdate DATE, gender VARCHAR(10),
                    nationality VARCHAR(50), field VARCHAR(50), studylevel INT, class INT);"
            );

            //create request table
            self::$_bdd ->query("create table if not exists request 
                    (id INT primary key auto_increment, firstname VARCHAR(50),
                    lastname VARCHAR(50), email VARCHAR(50), 
                    phone INT(8), address VARCHAR(80), birthdate DATE, gender VARCHAR(10),
                    nationality VARCHAR(50), field VARCHAR(50), education VARCHAR(50), 
                    program VARCHAR(50), achievements TEXT, essay TEXT);"
            );

            //create teacher table
            self::$_bdd ->query("create table if not exists teacher 
                    (id INT primary key auto_increment, firstname VARCHAR(50),
                    lastname VARCHAR(50), email VARCHAR(50), password VARCHAR(50), 
                    phone INT(8), gender VARCHAR(10));"
            );

            //create course table
            self::$_bdd ->query("create table if not exists course 
                    (id INT primary key auto_increment, coursename VARCHAR(50), 
                     teacher INT,
                    FOREIGN KEY(teacher) REFERENCES teacher(id));"
            );

            //create absence table
            self::$_bdd ->query("create table if not exists absence 
                    (student INT, course INT, 
                     absencedate DATE, 
                     PRIMARY KEY(student, course, absencedate),
                     FOREIGN KEY(student) REFERENCES student(id),
                    FOREIGN KEY(course) REFERENCES course(id));"
            );
            //create admin table
            self::$_bdd ->query("create table if not exists admin 
                    (id INT primary key auto_increment, username VARCHAR(50),email VARCHAR(50),
                    password VARCHAR(80));"
            );
            // Create the view after creating the tables
            self::$_bdd->query("
            CREATE OR REPLACE VIEW user_auth AS
            SELECT id, email, password, 'student' AS type
            FROM student
            UNION ALL
            SELECT id, email, password, 'teacher' AS type
            FROM teacher
            UNION ALL
            SELECT id, email, password, 'admin' AS type
            FROM admin
            ");

        
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    public static function getInstance()
    {
        if (!self::$_bdd) {
            new ConnexionBD();
        }
        return (self::$_bdd);
    }

    //insert data into admin table
    public static function insertData_admin($data)
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                INSERT INTO admin ( username, email, password)
                    VALUES (:username, :email, :password) 
                ");

            // Hash the password before storing
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['password'] = $hashedPassword;
            $stmt->execute($data);
            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }

    // insert data into the table etudiant
    public static function insertData_etudiant($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                INSERT INTO student ( firstname, lastname, email, password,
                                     phone, address, birthdate, nationality,
                                     gender, field, studylevel, class)
                    VALUES (:firstname, :lastname, :email, :password,
                            :phone, :address, :birthdate, :nationality, 
                            :gender, :field, :studylevel, :class) 
            ");

            // Hash the password before storing
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['password'] = $hashedPassword;
            $stmt->execute($data);
            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
    // insert data into the table prof
    public static function insertData_prof($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                INSERT INTO teacher ( firstname, lastname, email, password,phone,gender)
                    VALUES (:firstname, :lastname, :email, :password,:phone,:gender) 
                ");

            // Hash the password before storing
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['password'] = $hashedPassword;
            $stmt->execute($data);
            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
    // insert data into the table prof
    public static function insertData_course($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                INSERT INTO course ( coursename, teacher)
                    VALUES (:coursename, :teacher) 
                ");

            
            $stmt->execute($data);
            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
    // insert data into the table abscence
    public static function insertData_abscence($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                INSERT INTO absence ( student,course,absencedate)
                    VALUES (:student,:course,:absencedate) 
            ");
            $stmt->execute($data);
            echo "abscence is inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }

    // shows the data from a table in the database
    public static function showData($table)
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT * FROM $table");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            
            return $result;
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
        }
    }

    public static function getStudents()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT * FROM student;");
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;

        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }

    public static function getTeachers()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT * FROM teacher;");
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;

        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }

    public static function getAbsences()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT a.student AS studentID, CONCAT(s.firstname, ' ', s.lastname) AS studentname, 
                                    c.coursename, a.absencedate FROM absence a
                                    JOIN student s ON s.id = a.student
                                    JOIN course c ON c.id = a.course;");
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;

        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }

    public static function get_statistics(): ?array
    {
        try {
            $pdo = self::getInstance();
            $result = [];

            // 'studentsPerYear':
            $stmt = $pdo->query("SELECT studylevel,count(id) as nbStudents FROM student group by(studylevel);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 'absencePerMonth':
            $stmt = self::getInstance()->query("SELECT absencedate,count(*) as nbAbsences FROM absence WHERE absencedate > DATE_SUB(CURDATE(), INTERVAL 20 DAY) group by(absencedate);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //'studentsPerGender':
            $stmt = self::getInstance()->query("SELECT gender,count(*) as nbStudents FROM student group by(gender);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 'studentsPerField':
            $stmt = self::getInstance()->query("SELECT field,count(*) as nbStudents FROM student group by(field);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 'teachersPerCourse':
            $stmt = self::getInstance()->query("SELECT coursename,count(teacher) as nbTeachers FROM course group by(coursename);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }


    /**
     * * inserts the new submission in the request table
     */
    public static function add_submission($data): void
    {
        try {
            $pdo = self::getInstance();
            $numberOfSubmissions = $pdo->query("SELECT COUNT(*) FROM request")->fetchColumn();
            if ($numberOfSubmissions == 0) {
                $data = ["id" => 1] + $data;
            } else {
                $data = ["id" => $numberOfSubmissions + 1] + $data;
            }
            $stmt = $pdo->prepare("INSERT INTO request (id, firstname, lastname, email, phone,
                                                            address, birthdate, gender, nationality,
                                                            education, program, achievements, essay)
                                  VALUES (:id, :firstname, :lastname, :email, :phone, :address, 
                                          :birthdate, :gender, :nationality, :education, 
                                          :program, :achievements, :essay);
            ");
            $stmt->execute($data);
            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }

    /**
     * *deletes the submission that has the same email
     * @param email email associated to the submission
     */
    public static function delete_submission($email)
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("DELETE FROM request WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error deleting submission: " . $e->getMessage();
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

    // Set font for title
    $pdf->SetFont('Arial', 'B', 16);
    
    // Set title color to red
    $pdf->SetTextColor(179, 0, 0);  // #B30000 in RGB

    // Add title
    $pdf->Cell(0, 10, 'Admission Application', 0, 1, 'C');
    $pdf->Ln(10);

    // Reset text color to black for other text
    $pdf->SetTextColor(0, 0, 0);

    // Add image at the top left
    $pdf->Image(__DIR__ . '/../dashboard/src/logo-insat.png', 1, 1, 20);  // Adjust path and dimensions as needed

    $pdf->SetFont('Arial', '', 12);

    foreach ($data as $key => $value) {
        // Set field label color to red
        $pdf->SetTextColor(179, 0, 0);  // #B30000 in RGB
        $pdf->Cell(50, 10, ucfirst(str_replace("_", " ", $key)) . ':', 0, 0);
        
        // Reset text color to black for field value
        $pdf->SetTextColor(0, 0, 0);
        
        $pdf->Cell(0, 10, $value, 0, 1);
    }

    // Save PDF to a file with the email address as the filename
    $pdfFileName = '../../admission/admission_pdf/' . $data['email'] . '.pdf';
    $pdf->Output($pdfFileName, 'F');
}


/**
 * Generates a pdf file for each submission in the database
 * Deletes all existing PDF files in the directory before generating new ones
 */
public static function generate_pdf_for_all_submissions()
{
    try {
        // Delete all existing PDF files in the directory
        $pdfDirectory = '../../admission/admission_pdf/';
        $files = glob($pdfDirectory . '*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }

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
     * * adding new student to Student table using his email
     * @param email the email of the student to be added
     */
    public static function addStudent_byemail($email)
    {
        try {
            $pdo = self::getInstance();

            // Select the student with the given email
            $stmt = $pdo->prepare("SELECT * FROM student WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$student) {
                echo "No student found with the provided email.";
                return;
            }

            // Generate a random password
            $password = self::generateRandomPassword();

            // Selecting the class with the least number of students in the same field
            $stmt = $pdo->prepare("SELECT class, COUNT(*) as num_students 
                                    FROM student 
                                    WHERE field = :field 
                                    GROUP BY class 
                                    ORDER BY num_students ASC 
                                    LIMIT 1");
            $stmt->execute($student['field']);

            $classInfo = $stmt->fetch(PDO::FETCH_ASSOC);
            $selectedClass = $classInfo['class'];

            // Use insertData_etudiant to add the student to the student table
            $data = [
                'firstname' => $student['firstname'],
                'lastname' => $student['lastname'],
                'email' => $student['email'],
                'password' => $password,
                'phone' => $student['phone'],
                'address' => $student['address'],
                'birthdate' => $student['birthdate'],
                'nationality' => $student['nationality'],
                'gender' => $student['gender'],
                'field' => $student['field'],
                'studylevel' => $student['studylevel'],
                'class' => $selectedClass
            ];

            // Send email to the student using PHPMailer
            $mail = new PHPMailer(true);


            // Gmail SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com'; // Your Gmail email address
            $mail->Password = 'your_password'; // Your Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('admin@school.com', 'School Administration');
            $mail->addAddress($student['email'], $student['firstname'] . ' ' . $student['lastname']);
            $mail->Subject = 'Welcome to Our School';
            $mail->Body    = "Dear " . $student['firstname'] . " " . $student['lastname'] . ",\n\n" .
                             "Congratulations! You have been accepted to our school.\n" .
                             "Your password is: " . $password . "\n\n" .
                             "Please keep this password secure and do not share it with anyone.\n\n" .
                             "Best regards,\n" .
                             "School Administration";

            $mail->send();

            echo "Email sent successfully.";

            self::insertData_etudiant($data);
            echo "Student added successfully.";
        } catch (PDOException $e) {
            echo "Error adding student: " . $e->getMessage();
        }
    }   

    /**
     * * generates a random password
     * @param length the length of the password with the default value of 8
     */
    private static function generateRandomPassword($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{}|:<>?';
        $charactersLength = strlen($characters);
        $randomPassword = '';

        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomPassword;
    }

}