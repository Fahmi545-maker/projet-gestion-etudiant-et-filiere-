<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionetudiant1";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $idEnseignant = $_GET['id'];

    // Désactiver les vérifications de clé étrangère temporairement
    $conn->query("SET FOREIGN_KEY_CHECKS=0");

    // Supprimer l'enseignant
    $sqlDelete = "DELETE FROM enseignants WHERE idEnseignant = '$idEnseignant'";
    if ($conn->query($sqlDelete) === TRUE) {
        echo "Enseignant supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'enseignant : " . $conn->error;
    }

    // Réactiver les vérifications de clé étrangère
    $conn->query("SET FOREIGN_KEY_CHECKS=1");
}

// Rediriger vers la page d'affichage
header("Location: enseignants.php");
exit;
?>
