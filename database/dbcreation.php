<?php

require 'fpdf/fpdf.php';

class ConnexionBD
{
    private static string $_dbname = "insatplatform";
    private static string $_user = "root";
    private static string $_pwd = "";
    private static string $_host = "localhost";
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
                    lastname VARCHAR(50), email VARCHAR(50), password VARCHAR(80),
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
                    lastname VARCHAR(50), email VARCHAR(50), password VARCHAR(80), 
                    phone INT(8), gender VARCHAR(10));"
            );

            //create course table
            self::$_bdd ->query("create table if not exists course 
                    (id INT primary key auto_increment, coursename VARCHAR(50), 
                     teacher INT, field VARCHAR(50), studylevel INT,
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
            //create coursevideo table
            self::$_bdd ->query("create table if not exists coursevideo 
                    (id INT primary key auto_increment, title VARCHAR(150),url VARCHAR(150) ,description varchar(500),field VARCHAR(50), studylevel INT);"
            );
            // Create the view after creating the tables
            self::$_bdd ->query("CREATE OR REPLACE VIEW user_auth AS
            SELECT id, email, password, 'student' AS type
            FROM student
            UNION ALL
            SELECT id, email, password, 'teacher' AS type
            FROM teacher
            UNION ALL
            SELECT id, email, password, 'admin' AS type
            FROM admin
            ");
            // Create a trigger that verifies when inserting or updating the absence table whether the student is enrolled in the course
            self::$_bdd ->query("
                CREATE OR REPLACE TRIGGER check_student_course
                BEFORE INSERT ON absence FOR EACH ROW
                BEGIN
                    DECLARE std_field VARCHAR(50);
                    DECLARE std_level INT;
                    DECLARE crs_field VARCHAR(50);
                    DECLARE crs_level INT;
                    SELECT field INTO std_field FROM student WHERE id = NEW.student;
                    SELECT studylevel INTO std_level FROM student WHERE id = NEW.student;
                    SELECT field INTO crs_field FROM course WHERE id = NEW.course;
                    SELECT studylevel INTO crs_level FROM course WHERE id = NEW.course;
                    IF (std_field != crs_field OR std_level != crs_level) THEN
                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'Student is not enrolled in the course';
                    END IF;
                END;
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
                REPLACE INTO admin (id, username, email, password)
                    VALUES (:id, :username, :email, :password) 
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
                REPLACE INTO student (id, firstname, lastname, email, password,
                                     phone, address, birthdate, nationality,
                                     gender, field, studylevel, class)
                    VALUES (:id, :firstname, :lastname, :email, :password,
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
                REPLACE INTO teacher (id, firstname, lastname, email, password,phone,gender)
                    VALUES (:id, :firstname, :lastname, :email, :password,:phone,:gender) 
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
    // insert data into the table course
    public static function insertData_course($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                REPLACE INTO course (id, coursename, teacher, field, studylevel)
                    VALUES (:id, :coursename, :teacher, :field, :studylevel) 
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
                REPLACE INTO absence ( student,course,absencedate)
                    VALUES (:student,:course,:absencedate) 
            ");
            $stmt->execute($data);
            echo "abscence is inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
    // insert data into the table courseVideo
    public static function insertData_courseVideo($data): void
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare("
                REPLACE INTO courseVideo (id, url,title,description,field , studylevel)
                    VALUES (:id,:url,:title,:description,:field,:studylevel) 
            ");
            $stmt->execute($data);
            echo "courseVideo is inserted successfully";
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

    // get the VideoCourses of a student 
    public static function getVideosByLevel()
{
    try {
        $pdo = self::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM coursevideo WHERE (studylevel = :studylevel AND field = :field)");
        $stmt->bindParam(':studylevel', $_SESSION['studylevel'], PDO::PARAM_INT);
        $stmt->bindParam(':field', $_SESSION['field'], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    } catch (PDOException $e) {
        echo "Error fetching data: " . $e->getMessage();
        return null;
    }
}
    public static function getStudentInfo()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query("SELECT id,firstname , lastname,email,phone,address,birthdate,gender,nationality,field,studylevel,class FROM student WHERE id = " . $_SESSION['user_id']);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return null;
        }
    }
    
    /**
     * * inserts the new submission in the requests table
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
     *
     */
    public static function delete_submission($data): void
    {
        try{
            $pdo = self::getInstance();
            $req= $pdo->prepare("DELETE FROM request WHERE id = :id");
            $req->execute(array('id' =>$data['id']));
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }

    public static function generate_pdf_for_all_submissions(): void
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


    private static function generate_pdf($data): void
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


    public static function get_statistics(): ?array
    {
        try {
            $pdo = self::getInstance();
            $result = [];

            // 'studentsPerYear':
            $stmt = $pdo->query("SELECT studylevel,count(id) as nbStudents FROM student group by(studylevel);");
            $result[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 'absencePerMonth':
            $stmt = self::getInstance()->query("SELECT absencedate,count(*) as nbAbsences FROM absence group by(absencedate);");
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
}
