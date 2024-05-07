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

//Récupère les places dans la base de donnée
$placeTypes = $db->getPlaceTypes();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation parking</title>
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
            <h2 id="secondTitle">Réserver une place de parking</h2>
            <hr>
            <div id="contentContainer">
                <div id="textBlock">
                    <p id="secondParagraph">
                        Veuillez remplir le formulaire ci-dessous pour louer votre place de parc.<br>
                        voir la <a href="parkingList.php" id="list">liste des places</a> disponibles.
                    </p>
                </div>
            </div>    
            <div class="userContainer">
                <form action="../../controllers/parkingLocationCheck.php" method="post">
                    <div class="form-group">
                        <label for="placeType">Type de place :</label>
                        <select name="placeType" id="placeType">
                            <?php foreach ($placeTypes as $type): ?>
                                <option value="<?php echo htmlspecialchars($type['place_id']); ?>">
                                    <?php echo htmlspecialchars($type['plaType']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reservationDate">Date de réservation :</label>
                        <input type="date" name="reservationDate" id="reservationDate">
                    </div>
                    <div class="form-group">
                        <label for="startTime">Heure de début :</label>
                        <input type="time" name="startTime" id="startTime" min="07:00" max="18:00" required>
                    </div>
                    <div class="form-group">
                        <label for="endTime">Heure de fin :</label>
                        <input type="time" name="endTime" id="endTime" min="07:00" max="18:00" required>
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

