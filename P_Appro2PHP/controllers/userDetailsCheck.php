<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 19.03.2024  // ETML - Lausanne - Vennes                 *   *  *  *   *  *  *  * *
*  *  *   * Description : page check du formulaire userEditDetails                           * * * *
***************************************************************************************************/
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/

session_start();

// Inclure le fichier database.php
include("../models/database.php");

// Initialiser le tableau des erreurs
$errors = array();

// Créer une instance de la classe Database
$db = new Database();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: ../resources/views/authentification/login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

$user = $_SESSION['user'];

// Récupérer les données du formulaire soumis
$newUsername = $_POST['username'];
$newFirstname = $_POST['firstname'];
$newLastname = $_POST['lastname'];
$newEmail = $_POST['email'];
$newGender = $_POST['gender'];

// Validation des données
/*
if (strpos($newEmail, '@') === false) {
    $errors[] = "Adresse e-mail invalide";
}

*/
if (!preg_match("/^[a-zA-Z]*$/", $newFirstname)) {
    $errors[] = "Le prénom ne doit contenir que des lettres";
}

if (!preg_match("/^[a-zA-Z]*$/", $newLastname)) {
    $errors[] = "Le nom ne doit contenir que des lettres";
}

// Si des erreurs sont détectées, afficher les messages d'erreur
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
} else {
    // Met à jour les informations de l'utilisateur dans la base de données
    $db->updateUserInfo($user['user_id'], $newUsername, $newFirstname, $newLastname, $newEmail, $newGender);

    $_SESSION['user']['useUsername'] = $newUsername;
    $_SESSION['user']['useFirstname'] = $newFirstname;
    $_SESSION['user']['useLastname'] = $newLastname;
    $_SESSION['user']['useGender'] = $newGender;
    $_SESSION['user']['useMail'] = $newEmail;

    // Redirige l'utilisateur vers sa page de profil après la mise à jour
    header("Location: ../resources/views/userDetails.php");
    exit(); 
}
?>
