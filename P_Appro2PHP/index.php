<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 18.03.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page d'accueil du site                                             * * * *
***************************************************************************************************/
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/

session_start();
include("./models/database.php");
$db = new Database();

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="./resources/css/style.css">
</head>
    <body>
        <main>
            <div id="headContainer">
                <div class="left-content">
                    <a href="#"><img src="./resources/img/etmlImg.jpg" alt="ETML logo" class="headerImage"></a>
                    <a href="#"><img src="./resources/img/carImg.png" alt="Parking logo" class="headerImage"></a>
                </div>
                <div class="right-content">
                    <?php
                        if ($isLoggedIn) {
                            echo '<li class="nav-item dropdown">';
                            echo '<div class="myAccount">Mon compte</div>';
                            echo '<a href="javascript:void(0)" class="dropbtn"></a>';
                            echo '<div class="dropdown-content">';
                            echo '<a href="./resources/views/userDetails.php">Détail du compte</a>';
                            echo '<a href="./resources/views/parkingEdit.php">Mes réservations</a>';
                            echo '<a href="./resources/views/logout.php">Déconnexion</a>';
                            echo '</div>';
                            echo '</li>';
                        } else {
                            echo '<a href="./resources/views/authentification/login.php"><div class="button-base button-74" role="button">Login</div></a>';
                            echo '<a href="./resources/views/authentification/register.php"><div class="button-base button-74" role="button">Inscription</div></a>';
                        }
                    ?>
                </div>
            </div>
            <nav class="navbar">
                <ul>
                    <li><h1><a href="./resources/views/parkingLocation.php">Louer une place</a></h1></li>
                    <li><h1><a href="#" class="active">Accueil</a></h1></li>
                    <li><h1><a href="./resources/views/parkingList.php">Liste des places</a></h1></li>
                </ul>
            </nav>
            <div id="contentContainer">
                <div id="textBlock">
                    <p id="paragraph">
                        ETML Parking offre la flexibilité de réserver une place de stationnement<br>
                        pour une demi-journée ou pour l'intégralité de la journée,<br>
                        en fonction des places disponibles.
                    </p>
                    <hr>
                    <br>
                    <p id="secondParagraph">
                        La <a href="./resources/views/authentification/register.php" id="list">création d'un compte</a> est nécessaire<br>
                        pour pouvoir louer une place.
                    </p>
                </div>
                <br>
                <div id="map" style="height:350px; width:35%;"></div>
            </div>
            <br>
        </main>
        <footer>
            <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
        </footer>
        <script src="./resources/js/script.js"></script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByDn1WH69c8R4s2oah7If_Rrl4UG4eayw&callback=initMap">
        </script>
    </body>
</html>

