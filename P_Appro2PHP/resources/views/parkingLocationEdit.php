<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 23.04.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page de modification de l'utilisateur                              * * * *
***************************************************************************************************/
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/

session_start();
include("../../models/database.php");
$db = new Database();

if (!isset($_SESSION['user'])) {
    header("Location: ./authentification/login.php"); // Rediriger si l'utilisateur n'est pas connecté
    exit();
}

// Vérifie si un ID de réservation a été passé
$reservation_id = isset($_GET['edit']) ? $_GET['edit'] : null;
$reservation = null;
if ($reservation_id) {
    $reservation = $db->getReservationById($reservation_id); // Méthode fictive pour récupérer la réservation
}

$placeTypes = $db->getPlaceTypes();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'une réservation</title>
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
                            echo '<a href="parkingEdit.php">Mes réservations</a>';
                            echo '<a href="logout.php">Déconnexion</a>';
                            echo '</div>';
                            echo '</li>';
                        } else {
                            echo '<a href="./authentification/login.php"><div class="button-base button-74" role="button">Login</div></a>';
                            echo '<a href="./authentification/register.php"><div class="button-base button-74" role="button">Inscription</div></a>';
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
            <h2 id="secondTitle">Modifier la réservation</h2>
            <hr>
            <div id="contentContainer">
                <div id="textBlock">
                    <p id="secondParagraph">
                        Veuillez remplir le formulaire ci-dessous pour modifier votre réservation.<br>
                        voir la <a href="parkingList.php" id="list">liste des places</a> disponibles.
                    </p>
                </div>
            </div>    
            <div class="userContainer">
                <form action="../../controllers/parkingLocationEditCheck.php" method="post">
                    <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['reservation_id']); ?>">
                    <div class="form-group">
                        <label for="placeType">Type de place :</label>
                        <select name="placeType" id="placeType">
                            <?php foreach ($placeTypes as $type): ?>
                            <option value="<?php echo htmlspecialchars($type['place_id']); ?>" <?php if ($type['place_id'] == $reservation['places_fk']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($type['plaType']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reservationDate">Date de réservation :</label>
                        <input type="date" name="reservationDate" id="reservationDate" value="<?php echo $reservation['resDate']; ?>">
                    </div>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="morning" id="morning" <?php if ($reservation['resMatin']) echo 'checked'; ?>>
                            Le matin
                        </label>
                        <label>
                            <input type="checkbox" name="afternoon" id="afternoon" <?php if ($reservation['resApresMidi']) echo 'checked'; ?>>
                            L'après-midi
                        </label>
                        <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['reservation_id']); ?>">
                    </div>
                    <button type="submit">Suivant</button>
                </form>
            </div>
        </main>
        <br>
        <footer>
            <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
        </footer>
    </body>
</html>

