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

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
    header("Location: ./authentification/login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

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
                <?php
                    if ($isLoggedIn) {
                        echo '<li class="nav-item dropdown">';
                        echo '<div class="myAccount">Mon compte</div>';
                        echo '<a href="javascript:void(0)" class="dropbtn"></a>';
                        echo '<div class="dropdown-content">';
                        echo '<a href="../resources/views/userDetails.php">Détail du compte</a>';
                        echo '<a href="../resources/views/logout.php">Déconnexion</a>';
                        echo '</div>';
                        echo '</li>';
                    } else {
                        echo '<a href="./authentification/login.php"><button class="button-base button-74" role="button">Login</button></a>';
                        echo '<a href="./authentification/register.php"><button class="button-base button-74" role="button">Inscription</button></a>';
                    }
                ?>
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
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['reservationData'])) {
            $reservationData = $_SESSION['reservationData'];
            $userId = $_SESSION['user']['user_id']; // Assure-toi que c'est bien stocké comme ça
        
            $result = $db->saveReservation(
                $reservationData['typeDePlace'],
                $reservationData['dateDeReservation'],
                $reservationData['matin'],
                $reservationData['apresMidi'],
                "En attente", // Statut par défaut
                $userId
            );
            echo '<div id="contentContainer">';
            if ($result) {
                echo "Réservation confirmée avec succès. ID de réservation: $result";
                unset($_SESSION['reservationData']); // Nettoyer les données de session
            } else {
                echo "Erreur lors de la confirmation de la réservation.";
            }
        } else {
            // Gérer le cas d'erreur ou de tentative d'accès direct à ce script
            echo "Accès non autorisé ou données manquantes.";
        }
        ?>
        <br>
        <a id="pageBefore" href="../index.php">Retour à l'accueil</a>
    </div>
    </main>
    <footer>
        <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
    </footer>
</body>
</html>

