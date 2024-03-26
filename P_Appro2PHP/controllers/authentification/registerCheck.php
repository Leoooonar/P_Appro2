<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 18.03.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page check d'inscription du site                                   * * * *
***************************************************************************************************/
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/

session_start();

// Inclure le fichier database.php
include("../../models/database.php");

// Initialiser le tableau des erreurs
$errors = array();

//Structure HTML
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Inscription</title>
    <link rel="stylesheet" href="../../resources/css/style.css">
</head>
<body>
    <main>
        <div id="headContainer">
            <div class="left-content">
                <a href="../../index.php"><img src="../../resources/img/etmlImg.jpg" alt="ETML logo" class="headerImage"></a>
                <a href="../../index.php"><img src="../../resources/img/carImg.png" alt="Parking logo" class="headerImage"></a>
            </div>
            <div class="right-content">
                <a href="../../resources/views/authentification/login.php"><button class="button-base button-74" role="button">Login</button></a>
                <a href="../../resources/views/authentification/register.php"><button class="button-base button-74" role="button">Inscription</button></a>
            </div>
        </div>
        <nav class="navbar">
            <ul>
                <li><h1><a href="../../resources/views/parkingLocation.php">Louer une place</a></h1></li>
                <li><h1><a href="../../index.php">Accueil</a></h1></li>
                <li><h1><a href="../../resources/views/parkingList.php">Liste des places</a></h1></li>
            </ul>
        </nav>
        <br>
<?php

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifier si le nom d'utilisateur est vide
    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur est requis";
    }

    // Vérifier si le mot de passe est vide
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis";
    }

    // Vérifier si le mot de passe de confirmation correspond
    if ($password != $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    // Si aucun erreur n'a été détectée, procéder à l'inscription
    if (empty($errors)) {
        // Créer une instance de la classe Database
        $db = new Database();

        // Appeler la méthode pour vérifier l'inscription dans database.php
        $result = $db->registerUser($username, $password);

        // Vérifier le résultat de l'inscription
        if ($result) {
            // Rediriger l'utilisateur vers la page de connexion par exemple
            header("Location: ../../index.php");
            exit();
        } else {
            // Une erreur s'est produite lors de l'inscription
            $errors[] = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
        }
    }
}

// Si des erreurs sont survenues, afficher les erreurs
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo '<div id="contentContainer">';
        echo $error . "<br>";
        echo "<br>";
    }
}
?>
<br>
<a id="pageBefore" href="../../resources/views/authentification/register.php"><-Page précédente</a>
</div>
</main>
<footer>
    <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
</footer>