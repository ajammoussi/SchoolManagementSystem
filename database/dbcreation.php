<?php
class ConnexionBD
{
    private static $_dbname = "platformfac"; 
    private static $_user = "root";  
    private static $_pwd = "";
    private static $_host = "localhost";
    private static $_bdd = null;
    private function __construct()
    {
        try {
            // create database
            self::$_bdd = new PDO("mysql:host=" . self::$_host . ";dbname=" . self::$_dbname . ";charset=utf8", self::$_user, self::$_pwd,  array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));
            // create tableau etudiant 
            self::$_bdd ->query("create table if not exists etudiant (id int primary key auto_increment, nom varchar(50),
                                                                        prenom varchar(50), filiere varchar(50), classe varchar(50), email varchar(50), password varchar(50))");
        //     // creer un compte demo comme etudiant
        //     self::insertData_etudiant(array('nom' => 'demo nom', 'prenom' => 'demo prenom', 'filiere' => 'GL', 'classe' => '2/2', 'email' => 'demo@insat.com', 'password' => 'demo1234'));
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
    // insert data into the table etudiant
    public static function insertData_etudiant($data)
    {
        try {
            $pdo = self::getInstance();
            // Prepare the SQL statement for insertion pour etudiant !!!
            $stmt = $pdo->prepare("INSERT INTO etudiant (nom, prenom, filiere, classe, email, password) VALUES (:nom, :prenom, :filiere, :classe, :email, :password)");
            
            // Execute the prepared statement
            $stmt->execute($data);

            echo "Data inserted successfully";
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
    // shows the data from any table (useless if u use php my admin) to delete
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
}
