<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 18.03.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page de modification de l'utilisateur                              * * * *
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
    <title>Modification profil utilisateur</title>
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
            <h2 id="secondTitle">Edition des informations</h2>
            <hr>
            <div class="userContainer">
                <form action="../../controllers/userDetailsCheck.php" id="details" method="POST">
                    <label for="username">Pseudonyme:</label>
                    <input type="text" id="username" name="username" value="<?php echo $user['useUsername']; ?>">
                    <br>
                    <label for="firstname">Prénom:</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo $user['useFirstname'] ?? ''; ?>">
                    <br>
                    <label for="lastname">Nom:</label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo $user['useLastname'] ?? ''; ?>">
                    <br>
                    <label for="email">Adresse e-mail:</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['useMail'] ?? ''; ?>">
                    <br>
                    <label for="gender">Genre:</label>
                    <select id="gender" name="gender">
                        <option value="M" <?php echo ($user['useGender'] == 'M') ? 'selected' : ''; ?>>Masculin</option>
                        <option value="F" <?php echo ($user['useGender'] == 'F') ? 'selected' : ''; ?>>Féminin</option>
                        <option value="O" <?php echo ($user['useGender'] == 'O') ? 'selected' : ''; ?>>Autre</option>
                    </select>
                    <br>
                    <br>
                        <button type="submit">Sauvegarder</button>
                </form>
            </div>
        </main>
        <br>
        <footer>
            <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
        </footer>
    </body>
</html>

