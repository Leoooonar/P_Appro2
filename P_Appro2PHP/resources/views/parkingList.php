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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des places</title>
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
                    <li><h1><a href="parkingLocation.php">Louer une place</a></h1></li>
                    <li><h1><a href="../../index.php">Accueil</a></h1></li>
                    <li><h1><a href="parkingList.php" class="active">Liste des places</a></h1></li>
                </ul>
            </nav>
            <br>
            <h2 id="secondTitle">Disponibilités des places</h2>
            <hr>
            <form method="post">
                <br>
                <div id="refreshSection">
                    <label for="week">Sélectionner une semaine :</label>
                    <br>
                    <input type="week" id="week" name="week" value="<?php echo date('Y-\WW'); ?>">
                </div>
                    <br>
                <div id="refreshSection">
                    <button type="submit" name="refresh">Actualiser</button>
                </div>   
                <br>    
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Nom</th>
                        <th>Quand</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Vérifie si une semaine a été envoyée via POST
                        if (isset($_POST['refresh']) && !empty($_POST['week'])) {
                            $selectedWeek = $_POST['week'];
                            // Convertir le format de la semaine sélectionnée en une plage de dates
                            $startDate = date("Y-m-d", strtotime($selectedWeek));
                            $endDate = date("Y-m-d", strtotime($selectedWeek . " +6 days"));
                            $reservations = $db->getReservationsForWeek($startDate, $endDate);
                        } else {
                            // Si aucune semaine n'est sélectionnée, utiliser la semaine actuelle
                            $currentDate = date("Y-m-d");
                            $startDate = date("Y-m-d", strtotime("last Monday", strtotime($currentDate)));
                            $endDate = date("Y-m-d", strtotime("next Sunday", strtotime($currentDate)));
                            $reservations = $db->getReservationsForWeek($startDate, $endDate); 
                        }
                        foreach ($reservations as $reservation) {
                            if ($reservation['places_fk'] == 1){
                                $placeType = "Voiture";
                            }
                            elseif ($reservation['places_fk'] == 2){
                                $placeType = "Camion";
                            }
                            elseif ($reservation['places_fk'] == 3){
                                $placeType = "Vélo électrique";
                            }
                            elseif ($reservation['places_fk'] == 4){
                                $placeType = "Place de direction";
                            }
                            else {
                                $placeType = "Salle de conférence";
                            }
                            $name = $db->getUserNameById($reservation['user_fk']);
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($reservation['resDate']) . "</td>";
                            echo "<td>" . htmlspecialchars($placeType) . "</td>";
                            echo "<td>" . htmlspecialchars($name) . "</td>"; 
                            echo "<td>";
                            if ($reservation['resMatin']) {
                                echo "Matin";
                            }
                            if ($reservation['resMatin'] && $reservation['resApresMidi']) {
                                echo " / ";
                            }
                            if ($reservation['resApresMidi']) {
                                echo "Après-midi";
                            }
                            if (!$reservation['resMatin'] && !$reservation['resApresMidi']) {
                                echo "Non spécifié";
                            }
                            echo "</td>";                        
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </main>
        <footer>
            <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
        </footer>
    </body>
</html>

