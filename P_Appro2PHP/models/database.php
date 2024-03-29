<?php
class Database {
    private $host = "host.docker.internal"; 
    private $port = "6033"; 
    private $username = "root";
    private $password = "root";
    private $database = "db_P_Appro2";
    private $conn;

    //Constructor
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->database}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }

    //Méthode pour préparer et exécuter une requête avec des paramètres
    private function queryPrepare($query, $params = array()) {
        try {
            // Vérifie si la connexion à la base de données est établie
            if(!$this->conn) {
                throw new PDOException("La connexion à la base de données n'est pas établie.");
            }

            // Prépare la requête SQL
            $stmt = $this->conn->prepare($query);

            // Vérifie si la préparation de la requête a échoué
            if(!$stmt) {
                throw new PDOException("Erreur lors de la préparation de la requête.");
            }

            // Exécute la requête avec les paramètres fournis
            $result = $stmt->execute($params);

            // Vérifie si l'exécution de la requête a échoué
            if(!$result) {
                throw new PDOException("Erreur lors de l'exécution de la requête.");
            }

            // Retourne l'objet PDOStatement résultant
            return $stmt;
        } catch(PDOException $e) {
            // Gère l'erreur
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /////////////////////////////////////////////////////////////////////
    //                      GESTION UTILISATEURS                       //
    /////////////////////////////////////////////////////////////////////

    //Méthode pour vérifier le login
    public function checkLogin($username, $password) {
        $query = "SELECT * FROM t_user WHERE useUsername = :username";
        $stmt = $this->queryPrepare($query, array(':username' => $username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row && password_verify($password, $row['usePassword'])) {
            // Le mot de passe est correct, stocker l'utilisateur dans la session
            $_SESSION['user'] = $row;
            return true;
        }
    
        // si le nom d'utilisateur ou le mot de passe est incorrect, retourne false
        return false;
    }

    //Méthode pour enregistrer un nouvel utilisateur
    public function registerUser($username, $password) {
        try {
            // Hashe le mot de passe
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

    public function updateUserInfo($userId, $newUsername, $newFirstname, $newLastname, $newEmail, $newGender) {
        try {
            $query = "UPDATE t_user 
                      SET useUsername = :username,
                          useFirstname = :firstname, 
                          useLastname = :lastname, 
                          useMail = :email, 
                          useGender = :gender 
                      WHERE user_id = :userId";
    
            $params = array(
                ':username' => $newUsername,
                ':firstname' => $newFirstname,
                ':lastname' => $newLastname,
                ':email' => $newEmail,
                ':gender' => $newGender,
                ':userId' => $userId
            );
    
            $this->queryPrepare($query, $params);
    
            return true; // Retourne true si la mise à jour est réussie
        } catch(PDOException $e) {
            // Gère l'erreur
            echo "Error: " . $e->getMessage();
            return false; // Retourne false en cas d'erreur
        }
    }

    /////////////////////////////////////////////////////////////////////
    //                      GESTION RESERVATIONS                       //
    /////////////////////////////////////////////////////////////////////

    //Méthode récupérant tous les types de place 
    public function getPlaceTypes() {
        $sql = "SELECT place_id, plaType FROM t_places";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Méthode vérifiant si la place est déjà prise ou pas
    public function isPlaceTaken($dateDeReservation, $matin, $apresMidi, $typeDePlace) {
        $sql = "SELECT COUNT(*) FROM t_reservation 
                WHERE resDate = :dateDeReservation 
                AND ((resMatin = :matin AND :matin = 1) OR (resApresMidi = :apresMidi AND :apresMidi = 1))
                AND places_fk = :typeDePlace";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':dateDeReservation' => $dateDeReservation,
            ':matin' => $matin,
            ':apresMidi' => $apresMidi,
            ':typeDePlace' => $typeDePlace
        ]);
    
        return $stmt->fetchColumn() > 0;
    }    

    //Récupère les informations d'une réservation spécifique
    public function getReservationDetailsById($reservationId) {
        $sql = "SELECT * FROM t_reservation WHERE reservation_id = :reservationId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':reservationId', $reservationId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne un tableau associatif des détails de la réservation
    }

    //Récupère le prix d'une place spécifique en se basant sur son ID
    public function getPlacePriceById($placeId) {
        $sql = "SELECT plaPrice FROM t_places WHERE place_id = :placeId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':placeId', $placeId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchColumn(); // Retourne le prix de la place
    }

    //Récupère le nom par rapport à l'id
    public function getPlaceTypeNameById($placeId) {
        $sql = "SELECT plaType FROM t_places WHERE place_id = :placeId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':placeId', $placeId, PDO::PARAM_INT);
        $stmt->execute();
    
        // Récupère la première colonne du résultat de la requête
        $plaType = $stmt->fetchColumn();
    
        return $plaType;
    }

    // Enregistre la réservation de place de parking dans la db
    public function saveReservation($typeDePlace, $dateDeReservation, $matin, $apresMidi, $resStatut, $userId) {
        try {
            // Préparation de la requête d'insertion
            $sql = "INSERT INTO t_reservation (resDate, resMatin, resApresMidi, resStatut, places_fk, user_fk) VALUES (:dateDeReservation, :matin, :apresMidi, :resStatut, :typeDePlace, :userId)";
            $stmt = $this->conn->prepare($sql);
    
            // Liaison des paramètres
            $stmt->bindParam(':dateDeReservation', $dateDeReservation);
            $stmt->bindParam(':matin', $matin, PDO::PARAM_BOOL);
            $stmt->bindParam(':apresMidi', $apresMidi, PDO::PARAM_BOOL);
            $stmt->bindParam(':resStatut', $resStatut);
            $stmt->bindParam(':typeDePlace', $typeDePlace, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    
            // Exécution de la requête
            $stmt->execute();
    
            // Retourne l'ID de la réservation insérée
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            // En cas d'erreur, retourne false
            error_log("Erreur lors de l'insertion de la réservation: " . $e->getMessage());
            return false;
        }
    }      

    /////////////////////////////////////////////////////////////////////
    //                   GESTION LISTE DES RESERVATIONS                //
    /////////////////////////////////////////////////////////////////////

    //Récupère les réservations pour la liste 
    public function getReservationsForDate($date) {
        try {
            // Préparation de la requête SQL
            $stmt = $this->conn->prepare("SELECT * FROM t_reservation WHERE resDate = :resDate");
            
            // Liaison des paramètres
            $stmt->bindParam(':resDate', $date);

            // Exécution de la requête
            $stmt->execute();

            // Récupération des résultats
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $reservations;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des réservations : " . $e->getMessage());
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }

    //Récupère le nom à partir de la foreignkey de réservation
    public function getUserNameById($userId) {
        try {
            // Préparation de la requête SQL pour récupérer le nom de l'utilisateur
            $stmt = $this->conn->prepare("SELECT useUsername FROM t_user WHERE user_id = :userId");
            
            // Liaison des paramètres
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            // Exécution de la requête
            $stmt->execute();

            // Récupération du résultat
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retourne le nom de l'utilisateur si trouvé
            return $result ? $result['useUsername'] : 'Inconnu';
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération du nom de l'utilisateur : " . $e->getMessage());
            return 'Inconnu'; // Retourne une valeur par défaut en cas d'erreur
        }
    }
}
?>
