<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 18.03.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page d'accueil du site                                             * * * *
***************************************************************************************************/
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/*
session_start();
include("./models/database.php");
$db = new Database();
*/
//Vérifie si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
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
                <?php
                    if (isset($_SESSION['user'])) 
                    {
                        echo '<div class="myAccount">Mon compte</div>';
                    } 
                    else 
                    {
                        echo '<a href="./resources/views/authentification/login.php"><button class="button-74" role="button">Login</button></a>';
                        echo '<a href="./resources/views/authentification/register.php"><button class="button-74" role="button">Inscription</button></a>';
                    }
                ?>
            </div>
            <nav class="navbar">
                <ul>
                </ul>
            </nav> 
        </main>
        <footer>
            <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
        </footer>
    </body>
</html>

