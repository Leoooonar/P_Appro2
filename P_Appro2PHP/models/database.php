<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "root";
    private $database = "db_P_Appro2";
    private $conn;

    // Constructor
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }

    // Méthode pour préparer et exécuter une requête avec des paramètres
    private function queryPrepare($query, $params = array()) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Méthode pour vérifier le login
    public function checkLogin($username, $password) {
        $query = "SELECT * FROM t_user WHERE useUsername = :username";
        $stmt = $this->queryPrepare($query, array(':username' => $username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row && password_verify($password, $row['usePassword'])) {
            // Le mot de passe est correct, stocker l'utilisateur dans la session
            $_SESSION['user'] = $row;
            return true;
        }
    
        // Le nom d'utilisateur ou le mot de passe est incorrect, retourne false
        return false;
    }

    // Méthode pour enregistrer un nouvel utilisateur
    public function registerUser($username, $password) {
        try {
            // Hasher le mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Préparer la requête d'insertion
            $query = "INSERT INTO t_user (useUsername, usePassword) VALUES (:username, :password)";
            $params = array(':username' => $username, ':password' => $hashed_password);
            $this->queryPrepare($query, $params);
            
            // Si l'insertion a réussi, retourne true
            return true;
        } catch(PDOException $e) {
            // Une erreur s'est produite lors de l'insertion
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
