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

if (isset($_GET['Apogee'])) {
    $code_apoge = $_GET['Apogee'];

    // Désactiver les vérifications de clé étrangère temporairement
    $conn->query("SET FOREIGN_KEY_CHECKS=0");

    // Récupérer les données de l'étudiant à supprimer
    $sql = "SELECT e.*, f.NomFiliere, n.Niveau
            FROM etudiant e
            LEFT JOIN filieres f ON e.idFiliere = f.idFiliere
            LEFT JOIN niveau n ON e.idNiveau = n.idNiveau
            WHERE e.Apogee = '$code_apoge'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Insérer les données dans la table `etudiants_supprimes`
        $sqlInsert = "INSERT INTO etudiants_supprimes 
                        (Nom, Prenom, Apogee, DateNaissance, Pays, Ville, NomFiliere, Niveau) 
                      VALUES 
                        ('{$row['Nom']}', '{$row['Prenom']}', '{$row['Apogee']}', 
                         '{$row['DateNaissance']}', '{$row['Pays']}', '{$row['Ville']}', 
                         '{$row['NomFiliere']}', '{$row['Niveau']}')";

        if ($conn->query($sqlInsert) === TRUE) {
            // Supprimer l'étudiant de la table `etudiant`
            $sqlDelete = "DELETE FROM etudiant WHERE Apogee = '$code_apoge'";
            if ($conn->query($sqlDelete) === TRUE) {
                echo "Étudiant supprimé avec succès.";
            } else {
                echo "Erreur lors de la suppression de l'étudiant : " . $conn->error;
            }
        } else {
            echo "Erreur lors de l'archivage de l'étudiant : " . $conn->error;
        }
    } else {
        echo "Aucun étudiant trouvé avec le code Apogée fourni.";
    }

    // Réactiver les vérifications de clé étrangère
    $conn->query("SET FOREIGN_KEY_CHECKS=1");
}

// Rediriger vers la page d'affichage
header("location: afficher.php");
exit;
?>
