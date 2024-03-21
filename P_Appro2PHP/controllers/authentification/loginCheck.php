<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 18.03.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page check de connexion du site                                    * * * *
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
    <title>Check Login</title>
    <link rel="stylesheet" href="../../resources/css/style.css">
</head>
<body>
    <main>
        <div id="headContainer">
        <a href="../../resources/views/authentification/login.php"><button class="button-base button-74" role="button">Login</button></a>
        <a href="../../resources/views/authentification/register.php"><button class="button-base button-74" role="button">Inscription</button></a>
        </div>
        <nav class="navbar">
        <ul>
        <h1><a href="../../index.php">Accueil</a></h1>
        </ul>
        </nav>
        <br>
<?php

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier si le nom d'utilisateur est vide
    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur est requis.";
    }

    // Vérifier si le mot de passe est vide
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    }

    // Si aucun erreur n'a été détectée, vérifier les informations de connexion
    if (empty($errors)) {
        // Créer une instance de la classe Database
        $db = new Database();

        // Appeler la méthode pour vérifier le login dans database.php
        $result = $db->checkLogin($username, $password);

        // Vérifier le résultat de la vérification du login
        if ($result) {
            // Les informations de connexion sont valides, rediriger l'utilisateur vers la page d'accueil par exemple
            header("Location: ../../index.php");
            exit();
        } else {
            // Les informations de connexion sont incorrectes, ajouter un message d'erreur
            $errors[] = "Nom d'utilisateur ou mot de passe incorrect";
        }
    }
}

// Si des erreurs sont survenues, afficher les erreurs
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
        echo '<br>';
    }
}
?>
<a id="pageBefore" href="../../resources/views/authentification/login.php"><-Page précédente</a>
</main>
<footer>
    <p class="item-2">Leonar Dupuis<br><a id="mail" href="mailto:P_Appro2@gmail.com">P_Appro2@gmail.com</a></p> 
</footer>