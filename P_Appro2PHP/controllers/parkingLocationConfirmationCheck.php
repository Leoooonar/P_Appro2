<?php
/** Auteurs: Leonar
 * Date: 26.03.2024 // ETML - Lausanne - Vennes
 * Description: Page de validation du formulaire de réservation de parking
 */

// Démarrage de la session
session_start();
// Inclusion du fichier de connexion à la base de données
require_once '../models/database.php';
// Création d'une instance de la classe Database
$db = new Database();

$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalisation réservation</title>
    <link rel="stylesheet" href="../resources/css/style.css">
</head>
<body>
    <main>
        <div id="headContainer">
            <div class="left-content">
                <a href="../index.php"><img src="../resources/img/etmlImg.jpg" alt="ETML logo" class="headerImage"></a>
                <a href="../index.php"><img src="../resources/img/carImg.png" alt="Parking logo" class="headerImage"></a>
            </div>
            <div class="right-content">
                <a href="../resources/views/authentification/login.php"><button class="button-base button-74" role="button">Login</button></a>
                <a href="../resources/views/authentification/register.php"><button class="button-base button-74" role="button">Inscription</button></a>
            </div>
        </div>
        <nav class="navbar">
            <ul>
                <li><h1><a href="../resources/views/parkingLocation.php">Louer une place</a></h1></li>
                <li><h1><a href="../index.php">Accueil</a></h1></li>
                <li><h1><a href="../resources/views/parkingList.php">Liste des places</a></h1></li>
            </ul>
        </nav>
        <br>
        <?php
        // Vérification de la méthode de requête
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupération des données du formulaire
            $typeDePlace = $_POST['placeType'];
            $dateDeReservation = $_POST['reservationDate'];
            $matin = $_POST['morning'];
            $apresMidi = $_POST['afternoon'];

            // ID de l'utilisateur connecté
            $userId = $_SESSION['user']['user_id'];
            // Statut par défaut de la réservation
            $resStatut = "En attente";

            // Insertion des données dans la base de données
            $reservationId = $db->saveReservation($typeDePlace, $dateDeReservation, $matin, $apresMidi, $resStatut, $userId);

            // Affichage du résultat de la réservation
            echo '<div id="contentContainer">';
            if ($reservationId) {
                echo "Réservation confirmée. ID de réservation: " . $reservationId;
            } else {
                echo "Erreur lors de la réservation.";
                echo '<br>';
                echo $typeDePlace;
                echo '<br>';
                echo $dateDeReservation;
                echo '<br>';
                echo $matin;
                echo '<br>';
                echo $apresMidi;
            }
        }
        ?>
        <br>
        <a id="pageBefore" href="../resources/views/parkingLocation.php">Retour à l'accueil</a>
    </div>
    </main>
    <footer>
        <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
    </footer>
</body>
</html>
