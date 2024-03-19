<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 18.03.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page check d'inscription du site                                   * * * *
***************************************************************************************************/
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: ../resources/views/authentification/login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Inclure le fichier database.php
include("../../models/database.php");

// Initialiser le tableau des erreurs
$errors = array();

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
        echo $error . "<br>";
    }
}
?>