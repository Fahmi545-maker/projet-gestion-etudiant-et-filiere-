<?php
// Démarrer la session
session_start();

// Vérifier si une session existe
if (isset($_SESSION)) {
    // Détruire toutes les variables de session
    session_unset();

    // Détruire la session
    session_destroy();

    // Rediriger vers la page de connexion
    header("Location: login.php");
    exit;
}
?>
