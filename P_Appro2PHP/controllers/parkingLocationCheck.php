<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 26.03.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page check du formulaire parkingLocation                           * * * *
***************************************************************************************************/
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/

session_start();

require_once '../models/database.php';

// Créer une instance de la classe Database
$db = new Database();

// Initialiser le tableau des erreurs
$errors = [];

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
    <title>Check Inscription</title>
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Attribution des valeurs POST à des variables locales pour la validation
    $typeDePlace = $_POST['placeType'] ?? null;
    $dateDeReservation = $_POST['reservationDate'] ?? null;
    $matin = isset($_POST['morning']) ? 1 : 0;
    $apresMidi = isset($_POST['afternoon']) ? 1 : 0;

    // Validation
    if (empty($typeDePlace)) {
        $errors['typeDePlace'] = "Le type de place est requis.";
    }
    if (empty($dateDeReservation)) {
        $errors['dateDeReservation'] = "La date de réservation est requise.";
    } elseif (new DateTime($dateDeReservation) < new DateTime()) {
        $errors['dateDeReservation'] = "La date de réservation doit être dans le futur.";
    }
    if ($matin === 0 && $apresMidi === 0) {
        $errors['time'] = "Vous devez sélectionner au moins un moment de la journée.";
    }

    // Vérification de la disponibilité de la place
    if (count($errors) === 0) {
        if ($db->isPlaceTaken($dateDeReservation, $matin, $apresMidi, $typeDePlace)) {
            $errors['placeTaken'] = "La place sélectionnée pour la date et le moment choisis est : <div id='unavailable'>Indisponible</div>";
        } else {
        // Stockage des données dans la session
        $_SESSION['reservationData'] = [
            'typeDePlace' => $typeDePlace,
            'dateDeReservation' => $dateDeReservation,
            'matin' => $matin,
            'apresMidi' => $apresMidi
        ];

        // Redirection vers la page de confirmation
        header('Location: ../resources/views/parkingLocationConfirmation.php');
    }
}
    
    // S'il y a des erreurs, réafficher le formulaire avec les messages d'erreur
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo '<div id="contentContainer">';
            echo "<p>$error</p>";
        }
    }
}
?>
<br>
<a id="pageBefore" href="../resources/views/parkingLocation.php"><-Page précédente</a>
</div>
</main>
<footer>
    <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
</footer>
