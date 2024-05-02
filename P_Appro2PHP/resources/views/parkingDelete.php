<?php
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/
/***************************************************************************************************
*  *  *   * Auteurs: Leonar                                               *   *  *  *   *  *  *  * *
*  *  *   * Date: 19.04.2024  // ETML - Lausanne - Sébeillon              *   *  *  *   *  *  *  * *
*  *  *   * Description : permet de supprimer une réservation                                * * * *
***************************************************************************************************/
/**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**/

session_start();
include("../../models/database.php");
$db = new Database();

// Vérifie si l'utilisateur est connecté et si l'ID de suppression est transmis
if (isset($_SESSION['user'], $_GET['delete'])) {
    $reservationId = $_GET['delete'];
    $userId = $_SESSION['user']['user_id'];  // Assurez-vous que cet ID est bien stocké lors de la connexion

    // Appel à la méthode de suppression
    if ($db->deleteReservation($reservationId, $userId)) {
        // Redirection avec un message de succès
        header("Location: parkingEdit.php?status=success&message=Réservation supprimée");
    } else {
        // Redirection avec un message d'erreur
        header("Location: parkingEdit.php?status=error&message=Erreur lors de la suppression");
    }
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté ou si aucun ID n'est transmis
    header("Location: ./authentification/login.php");
    exit();
}