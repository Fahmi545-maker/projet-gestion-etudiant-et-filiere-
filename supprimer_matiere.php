<?php
// Connexion à la base de données
// Utilisation de MySQLi pour sécuriser l'accès à la base de données
$conn = new mysqli("localhost", "root", "", "gestionetudiant1");

// Vérification de la connexion
if ($conn->connect_error) {
    // En cas d'échec de la connexion, afficher un message d'erreur sécurisé
    die("Échec de la connexion à la base de données. Veuillez réessayer plus tard.");
}

// Vérification si un ID a été passé dans l'URL
if (isset($_GET['id'])) {
    // Conversion de l'ID en entier pour éviter les injections SQL
    $idMatiere = intval($_GET['id']);

    // Préparation de la requête SQL pour supprimer la matière
    $query = $conn->prepare("DELETE FROM matieres WHERE idMatiere = ?");
    $query->bind_param("i", $idMatiere);

    // Exécution de la requête
    if ($query->execute()) {
        // Si la suppression réussit, redirection avec un message de succès
        header("Location: afficher_matieres.php?message=success");
        exit();
    } else {
        // En cas d'erreur, redirection avec un message d'erreur
        header("Location: afficher_matieres.php?message=error");
        exit();
    }
} else {
    // Si aucun ID n'est fourni, redirection avec un message d'ID invalide
    header("Location: afficher_matieres.php?message=invalid");
    exit();
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
