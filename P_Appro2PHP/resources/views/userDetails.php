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
    <title>Profil utilisateur</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
    <body>
        <main>
            <div id="headContainer">
                <?php
                    if ($isLoggedIn) {
                        echo '<li class="nav-item dropdown">';
                        echo '<div class="myAccount">Mon compte</div>';
                        echo '<a href="javascript:void(0)" class="dropbtn"></a>';
                        echo '<div class="dropdown-content">';
                        echo '<a href=#>Détail du compte</a>';
                        echo '<a href="logout.php">Déconnexion</a>';
                        echo '</div>';
                        echo '</li>';
                    } else {
                        echo '<a href="./resources/views/authentification/login.php"><button class="button-base button-74" role="button">Login</button></a>';
                        echo '<a href="./resources/views/authentification/register.php"><button class="button-base button-74" role="button">Inscription</button></a>';
                    }
                ?>
            </div>
            <nav class="navbar">
                <ul>
                    <h1><a href="../../index.php"><- Accueil</a></h1>
                </ul>
            </nav>
            <br>
            <?php
                if ($isLoggedIn) {
                    echo '<div class="userContainer">';
                        echo '<p><strong>Nom d\'utilisateur:</strong> ' . $user['useUsername'] . '</p>';
                        echo '<br>';
                        echo '<p><strong>Prénom:</strong> ' . ($user['useFirstname'] ?? 'Non renseigné') . '</p>';
                        echo '<br>';
                        echo '<p><strong>Nom:</strong> ' . ($user['useLastname'] ?? 'Non renseigné') . '</p>';
                        echo '<br>';
                        echo '<p><strong>Adresse e-mail:</strong> ' . ($user['useMail'] ?? 'Non renseignée') . '</p>';
                        echo '<br>';
                        echo '<p><strong>Genre:</strong> ' . ($user['useGender'] ?? 'Non renseigné') . '</p>';
                        echo '<br>';

                        // Bouton d'ajouts/modifications d'informations
                        echo '<div class="userButton">';
                            echo '<a href="userEditDetails.php" class="button-base button-73">Modifier</a>';
                        echo '</div>';
                    echo '</div>';
                }
            ?> 
        </main>
        <footer>
            <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
        </footer>
    </body>
</html>

