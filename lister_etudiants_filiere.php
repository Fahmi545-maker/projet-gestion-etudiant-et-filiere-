<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestionetudiant1");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Initialisation des variables
$filiereEtudiants = [];
$filiereSelectionnee = null;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filiereSelectionnee = intval($_POST['idFiliere']);
    
    // Récupérer les étudiants de la filière sélectionnée
    $query = "
        SELECT e.Nom, e.Prenom, e.Apogee, e.DateNaissance, e.Ville, e.Pays, n.Niveau
        FROM etudiant e
        LEFT JOIN niveau n ON e.idNiveau = n.idNiveau
        WHERE e.idFiliere = $filiereSelectionnee
    ";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $filiereEtudiants = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lister Étudiants par Filière</title>
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
            background: rgba(255, 255, 255, 0.8);
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

        .table-container {
            margin: 20px auto;
            max-width: 1000px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #005f7f;
            color: white;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
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
    <h1>Lister Étudiants par Filière</h1>

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
            <button type="submit">Lister les Étudiants</button>
        </form>
    </div>

    <!-- Tableau des étudiants -->
    <?php if (!empty($filiereEtudiants)): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Apogée</th>
                        <th>Date de Naissance</th>
                        <th>Ville</th>
                        <th>Pays</th>
                        <th>Niveau</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filiereEtudiants as $etudiant): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($etudiant['Nom']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['Prenom']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['Apogee']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['DateNaissance']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['Ville']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['Pays']); ?></td>
                            <td><?php echo htmlspecialchars($etudiant['Niveau']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p style="text-align: center; color: red;">Aucun étudiant trouvé pour cette filière.</p>
    <?php endif; ?>
    <?php if (!empty($filiereSelectionnee)): ?>
    <div class="back-button">
        <a href="pdf_filiere.php?idFiliere=<?php echo $filiereSelectionnee; ?>">Télécharger en PDF</a>
    </div>
<?php endif; ?>


    <!-- Bouton retour -->
    <div class="back-button">
        <a href="dashboard_filieres.php">Retour au Dashboard</a>
    </div>
</body>
</html>
