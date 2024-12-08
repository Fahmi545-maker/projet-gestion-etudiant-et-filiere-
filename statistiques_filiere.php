<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestionetudiant1");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Initialisation des variables
$filiereSelectionnee = null;
$statistiques = [];

// Traitement du formulaire de sélection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filiereSelectionnee = intval($_POST['idFiliere']);

    // Nombre d'étudiants par filière
    $queryEtudiants = "SELECT COUNT(*) AS total_etudiants FROM etudiant WHERE idFiliere = $filiereSelectionnee";
    $resultEtudiants = $conn->query($queryEtudiants);
    $totalEtudiants = ($resultEtudiants->num_rows > 0) ? $resultEtudiants->fetch_assoc()['total_etudiants'] : 0;

    // Nombre de matières enseignées
    $queryMatieres = "SELECT COUNT(*) AS total_matieres FROM matieres WHERE idFiliere = $filiereSelectionnee";
    $resultMatieres = $conn->query($queryMatieres);
    $totalMatieres = ($resultMatieres->num_rows > 0) ? $resultMatieres->fetch_assoc()['total_matieres'] : 0;

    // Nombre d'enseignants associés
    $queryEnseignants = "
        SELECT COUNT(DISTINCT idEnseignant) AS total_enseignants
        FROM matieres
        WHERE idFiliere = $filiereSelectionnee";
    $resultEnseignants = $conn->query($queryEnseignants);
    $totalEnseignants = ($resultEnseignants->num_rows > 0) ? $resultEnseignants->fetch_assoc()['total_enseignants'] : 0;

    // Ajouter les statistiques
    $statistiques = [
        'total_etudiants' => $totalEtudiants,
        'total_matieres' => $totalMatieres,
        'total_enseignants' => $totalEnseignants
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques par Filière</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('1.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #005f7f;
        }

        .form-container {
            text-align: center;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #005f7f;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #003f5f;
        }

        .stats-container {
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .stats-container h2 {
            text-align: center;
            color: #005f7f;
        }

        .stats-container p {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
        }

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #005f7f;
            color: white;
            border-radius: 5px;
        }

        .back-button a:hover {
            background-color: #003f5f;
        }
    </style>
</head>
<body>
    <h1>Statistiques par Filière</h1>

    <!-- Formulaire de sélection de filière -->
    <div class="form-container">
        <form method="POST">
            <label for="idFiliere">Sélectionnez une filière :</label>
            <select name="idFiliere" id="idFiliere" required>
                <option value="">-- Choisir une filière --</option>
                <?php
                // Récupérer toutes les filières
                $queryFilieres = "SELECT idFiliere, NomFiliere FROM filieres";
                $resultFilieres = $conn->query($queryFilieres);

                if ($resultFilieres->num_rows > 0) {
                    while ($filiere = $resultFilieres->fetch_assoc()) {
                        $selected = ($filiereSelectionnee == $filiere['idFiliere']) ? 'selected' : '';
                        echo "<option value='" . $filiere['idFiliere'] . "' $selected>" . htmlspecialchars($filiere['NomFiliere']) . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">Afficher les Statistiques</button>
        </form>
    </div>

    <!-- Affichage des statistiques -->
    <?php if (!empty($statistiques)): ?>
    <div class="stats-container">
        <h2>Statistiques pour la Filière</h2>
        <p><strong>Nombre d'Étudiants :</strong> <?php echo $statistiques['total_etudiants']; ?></p>
        <p><strong>Nombre de Matières :</strong> <?php echo $statistiques['total_matieres']; ?></p>
        <p><strong>Nombre d'Enseignants :</strong> <?php echo $statistiques['total_enseignants']; ?></p>
        <div class="back-button">
            <a href="statistiques_pdf_filiere.php?idFiliere=<?php echo $filiereSelectionnee; ?>">Télécharger PDF</a>
        </div>
    </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p style="text-align: center; color: red;">Aucune donnée disponible pour cette filière.</p>
    <?php endif; ?>

    <!-- Bouton retour -->
    <div class="back-button">
        <a href="dashboard_filieres.php">Retour au Dashboard</a>
    </div>
</body>
</html>
