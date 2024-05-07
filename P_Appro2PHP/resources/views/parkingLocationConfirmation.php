<?php
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

// On stock dans la session les informations de réservations
$reservationData = $_SESSION['reservationData'] ?? null;
if (!$reservationData) {
    header("Location: parkingLocation.php"); // Rediriger si aucune donnée de réservation n'est disponible
    exit();
}
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
        <!-- Contenu du headContainer et navbar -->
        <h2 id="secondTitle">Confirmation de votre réservation</h2>
        <hr>
        <div id="contentContainer">
            <p id="secondParagraph">
                Vérifiez les détails de votre réservation avant de confirmer :
            </p>
        </div>    
        <div class="parkingReservation">
            <?php
                $typeDePlace = $reservationData['typeDePlace'];
                $dateDeReservation = $reservationData['dateDeReservation'];
                $startTime = $reservationData['startTime'];
                $endTime = $reservationData['endTime'];

                // Utiliser $typeDePlace pour récupérer le nom du type de place et le prix
                $typeDePlaceName = $db->getPlaceTypeNameById($typeDePlace);
                $placePrice = $db->getPlacePriceById($typeDePlace);

                echo "Type de place: " . htmlspecialchars($typeDePlaceName) . "<br>";
                echo "Date de réservation: " . htmlspecialchars($dateDeReservation) . "<br>";
                echo "Heure de début: " . htmlspecialchars($startTime) . "<br>";
                echo "Heure de fin: " . htmlspecialchars($endTime) . "<br>";
                echo "Prix à payer : " . htmlspecialchars($placePrice) . " CHF<br>";
            ?>
        </div>
        <!-- Formulaire de confirmation avec champs cachés -->
        <form action="../../controllers/parkingLocationConfirmationCheck.php" method="post" id="confirmButton">
            <input type="hidden" name="placeType" value="<?= htmlspecialchars($reservationData['typeDePlace']) ?>">
            <input type="hidden" name="reservationDate" value="<?= htmlspecialchars($reservationData['dateDeReservation']) ?>">
            <input type="hidden" name="startTime" value="<?= htmlspecialchars($reservationData['startTime']) ?>">
            <input type="hidden" name="endTime" value="<?= htmlspecialchars($reservationData['endTime']) ?>">
            <br>
            <button type="submit">Confirmer la réservation</button>
        </form>
    </main>
    <footer>
        <p>Leonar Dupuis<br><a href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
    </footer>
</body>
</html>
