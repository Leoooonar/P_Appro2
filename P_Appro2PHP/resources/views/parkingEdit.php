<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 16.04.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page détails de la réservation                                     * * * *
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

if ($isLoggedIn) {
    $userId = $user['user_id'];  // Assurez-vous que cet ID est bien stocké lors de la connexion
    $reservations = $db->getUserReservations($userId);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations réservations</title>
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
                    <li><h1><a href="parkingList.php">Liste des places</a></h1></li>
                </ul>
            </nav>
            <br>
            <h2 id="secondTitle">Détails de réservation</h2>
            <hr>   
            <br>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Plage horaire</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($isLoggedIn && isset($reservations)) {
                        foreach ($reservations as $reservation) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($reservation['resDate']) . "</td>";
                            echo "<td>" . htmlspecialchars($reservation['plaType']) . "</td>";
                            echo "<td>";
                            // Affichage des plages horaires 
                            if (isset($reservation['resStartTime']) && isset($reservation['resEndTime'])) {
                                $startTime = date('H:i', strtotime($reservation['resStartTime'])); 
                                $endTime = date('H:i', strtotime($reservation['resEndTime'])); 
                                echo htmlspecialchars($startTime) . " - " . htmlspecialchars($endTime);
                            } else {
                                echo "Non spécifié";
                            }
                            echo "</td>";
                            echo '<td>';
                            echo '<button onclick="window.location.href=\'parkingLocationEdit.php?edit=' . $reservation['reservation_id'] . '\'">Modifier</button>';
                            echo '<button class="delete-button" onclick="if(confirm(\'Êtes-vous sûr de vouloir supprimer cette réservation?\')) window.location.href=\'parkingDelete.php?delete=' . $reservation['reservation_id'] . '\';">Supprimer</button>';
                            echo '</td>';
                            echo "</tr>";
                        }
                    }
                ?>
                </tbody>
            </table>
        </main>
        <br>
        <footer>
            <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
        </footer>
    </body>
</html>

