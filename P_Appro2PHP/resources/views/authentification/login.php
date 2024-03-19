<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 18.03.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page de connexion du site                                          * * * *
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
    <title>Connexion</title>
    <link rel="stylesheet" href="../../../resources/css/style.css">
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
                        echo '<a href="#"><button class="button-74" role="button">Login</button></a>';
                        echo '<a href="register.php"><button class="button-74" role="button">Inscription</button></a>';
                    }
                ?>
            </div>
            <nav class="navbar">
                <ul>
                </ul>
            </nav>
            <br>
            <div class="form-content">
                <form action="../../../controllers/authentification/loginCheck.php" method="POST">
                    <div class="login-png">    
                        <img src="../../../resources/img/login.png" alt="">
                    </div>
                    <h1 class="form-title">Connexion</h1> 
                    <div class="label-content">
                        <label><b>Nom d'utilisateur</b></label>
                        <br>
                        <input type="text" placeholder="Entrer le nom d'utilisateur" name="username">
                    </div>
                    <br>
                    <div class="label-content">
                        <label><b>Mot de passe</b></label>
                        <br>
                        <input type="password" placeholder="Entrer le mot de passe" name="password">
                        <br>
                    </div>
                    <div class="label-content">
                        <input type="submit" id='submit' value='LOGIN' >
                    </div>
                </form>
                <a href="register.php"><h4 class="inscription">S'inscrire</h4></a>
            </div>  
        </main>
        <footer>
            <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
        </footer>
    </body>
</html>

