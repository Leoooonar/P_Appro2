<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 18.03.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page détails de l'utilisateur                                      * * * *
***************************************************************************************************/
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/

session_start();
include("../../models/database.php");
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

    // Assurons-nous que les variables sont définies pour éviter des erreurs PHP
    $typeDePlaceId = isset($_POST['placeType']) ? $_POST['placeType'] : '';
    $dateDeReservation = isset($_POST['reservationDate']) ? $_POST['reservationDate'] : '';
    $matin = isset($_POST['morning']) ? "Oui" : "Non";
    $apresMidi = isset($_POST['afternoon']) ? "Oui" : "Non";

    // Utiliser la nouvelle méthode pour récupérer le nom du type de place
    $typeDePlaceName = $db->getPlaceTypeNameById($typeDePlaceId);

    // Récupérer le prix basé sur l'ID du type de place
    $placePrice = $db->getPlacePriceById($typeDePlaceId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation réservation parking</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
    <body>
        <main>
            <div id="headContainer">
                <div class="left-content">
                    <a href="../../index.php"><img src="../img/etmlImg.jpg" alt="ETML logo" class="headerImage"></a>
                    <a href="../../index.php"><img src="../img/carImg.png" alt="Parking logo" class="headerImage"></a>
                </div>
                <div class="right-content">
                    <?php
                        if ($isLoggedIn) {
                            echo '<li class="nav-item dropdown">';
                            echo '<div class="myAccount">Mon compte</div>';
                            echo '<a href="javascript:void(0)" class="dropbtn"></a>';
                            echo '<div class="dropdown-content">';
                            echo '<a href="userDetails.php">Détail du compte</a>';
                            echo '<a href="logout.php">Déconnexion</a>';
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
                    <li><h1><a href="parkingLocation.php" class="active">Louer une place</a></h1></li>
                    <li><h1><a href="../../index.php">Accueil</a></h1></li>
                    <li><h1><a href="parkingList.php">Liste des places</a></h1></li>
                </ul>
            </nav>
            <br>
            <h2 id="secondTitle">Réserver une place de parking</h2>
            <hr>
            <div id="contentContainer">
                <div id="textBlock">
                    <p id="secondParagraph">
                        La place de parking est :
                        <br>
                        <span id="available">Disponible</span>
                        <br>
                        Veuillez vérifier les informations avant de procéder à la confirmation.
                    </p>
                </div>
            </div>    
            <div class="parkingReservation">
                <?php
                    if (isset($_SESSION['reservationData'])) {
                        $reservationData = $_SESSION['reservationData'];
                        $typeDePlace = $reservationData['typeDePlace'];
                        $dateDeReservation = $reservationData['dateDeReservation'];
                        $matin = $reservationData['matin'];
                        $apresMidi = $reservationData['apresMidi'];

                        // Utiliser $typeDePlace pour récupérer le nom du type de place et le prix
                        $typeDePlaceName = $db->getPlaceTypeNameById($typeDePlace);
                        $placePrice = $db->getPlacePriceById($typeDePlace);

                        // Affichage des informations
                        echo "Type de place: " . htmlspecialchars($typeDePlaceName) . "<br>";
                        echo "Date de réservation: " . htmlspecialchars($dateDeReservation) . "<br>";
                        echo "Matin: " . ($matin ? "Oui" : "Non") . "<br>";
                        echo "Après-midi: " . ($apresMidi ? "Oui" : "Non") . "<br>";
                        echo "Prix à payer : " . $placePrice . " CHF<br>";
                    } else {
                        // Gérer le cas où les données ne sont pas disponibles
                        echo "Informations de réservation non disponibles.";
                    }
                ?>
                <!-- Formulaire de confirmation avec champs cachés -->
                <form action="../../controllers/parkingLocationConfirmationCheck.php" method="post">
                    <input type="hidden" name="placeType" value="<?php echo htmlspecialchars($typeDePlaceId); ?>">
                    <input type="hidden" name="reservationDate" value="<?php echo htmlspecialchars($dateDeReservation); ?>">
                    <input type="hidden" name="morning" value="<?php echo isset($_POST['morning']) ? 1 : 0; ?>">
                    <input type="hidden" name="afternoon" value="<?php echo isset($_POST['afternoon']) ? 1 : 0; ?>">

                    <button type="submit">Confirmer la réservation</button>
                </form>
            </div>
        </main>
        <br>
        <footer>
            <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
        </footer>
    </body>
</html>

