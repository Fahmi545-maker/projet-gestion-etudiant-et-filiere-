<?php
// === DÉBUT DU SCRIPT PHP ===

// Connexion à la base de données avec vérification
$conn = new mysqli("localhost", "root", "", "gestionetudiant1");

// Vérification de la connexion (message générique pour éviter de révéler des détails)
if ($conn->connect_error) {
    error_log("Erreur de connexion : " . $conn->connect_error); // Log l'erreur côté serveur
    die("Erreur de connexion. Veuillez réessayer plus tard."); // Message générique
}

// Initialisation de variables
$message = ""; // Message pour informer l'utilisateur

// Vérifier si un ID a été passé en GET (paramètre dans l'URL)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idMatiere = intval($_GET['id']); // S'assurer que l'ID est un entier

    // Préparer une requête sécurisée pour récupérer les données de la matière
    $stmt = $conn->prepare("SELECT * FROM matieres WHERE idMatiere = ?");
    $stmt->bind_param("i", $idMatiere); // Liaison du paramètre (protection contre SQL Injection)
    $stmt->execute(); // Exécution de la requête
    $result = $stmt->get_result(); // Récupération des résultats

    // Vérifier si la matière existe
    if ($result && $result->num_rows > 0) {
        $matiere = $result->fetch_assoc(); // Récupérer les données de la matière
    } else {
        die("Matière non trouvée."); // Message si la matière n'existe pas
    }
    $stmt->close(); // Fermer la requête préparée
} else {
    die("ID de la matière non spécifié ou invalide."); // Message en cas d'ID manquant ou incorrect
}

// Traitement du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et nettoyer les données envoyées par l'utilisateur
    $nomMatiere = htmlspecialchars(trim($_POST['nomMatiere']));
    $coefficient = floatval($_POST['coefficient']);
    $idFiliere = intval($_POST['idFiliere']);
    $idEnseignant = intval($_POST['idEnseignant']);

    // Vérifier que tous les champs sont remplis
    if (empty($nomMatiere) || $coefficient <= 0 || $idFiliere <= 0 || $idEnseignant <= 0) {
        $message = "<p style='color: red;'>Tous les champs sont obligatoires et doivent être valides.</p>";
    } else {
        // Préparer une requête sécurisée pour la mise à jour
        $stmt = $conn->prepare("
            UPDATE matieres 
            SET NomMatiere = ?, Coefficient = ?, idFiliere = ?, idEnseignant = ?
            WHERE idMatiere = ?
        ");
        $stmt->bind_param("sdiii", $nomMatiere, $coefficient, $idFiliere, $idEnseignant, $idMatiere);

        // Exécuter la mise à jour et afficher un message approprié
        if ($stmt->execute()) {
            $message = "<p style='color: green;'>Matière mise à jour avec succès.</p>";
        } else {
            $message = "<p style='color: red;'>Erreur lors de la mise à jour : " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close(); // Fermer la requête préparée
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer Matière</title>
    <style>
        /* === DESIGN DE LA PAGE === */
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url('1.jpg');
            background-position: center;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 36px;
            color: #005f7f;
            margin-bottom: 20px;
        }

        .form-container {
            width: 400px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .form-container label {
            font-size: 14px;
            color: #005f7f;
            margin-bottom: 8px;
            display: block;
        }

        .form-container input,
        .form-container select,
        .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-container button {
            background-color: #005f7f;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-container button:hover {
            background-color: #003f5f;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
        }

        .back-button {
            text-align: center;
            margin-top: 10px;
        }

        .back-button a {
            text-decoration: none;
            color: #005f7f;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Conteneur du formulaire -->
    <div class="form-container">
        <h1>Éditer Matière</h1>

        <!-- Message d'information -->
        <div class="message"><?php echo $message; ?></div>

        <!-- Formulaire de mise à jour -->
        <form method="POST">
            <label for="nomMatiere">Nom de la Matière</label>
            <input type="text" name="nomMatiere" id="nomMatiere" 
                   value="<?php echo htmlspecialchars($matiere['NomMatiere']); ?>" required>

            <label for="coefficient">Coefficient</label>
            <input type="number" step="0.1" name="coefficient" id="coefficient" 
                   value="<?php echo htmlspecialchars($matiere['Coefficient']); ?>" required>

            <label for="idFiliere">Filière</label>
            <select name="idFiliere" id="idFiliere" required>
                <?php
                // Charger la liste des filières
                $filiereQuery = "SELECT idFiliere, NomFiliere FROM filieres";
                $filiereResult = $conn->query($filiereQuery);
                while ($row = $filiereResult->fetch_assoc()) {
                    $selected = ($matiere['idFiliere'] == $row['idFiliere']) ? "selected" : "";
                    echo "<option value='" . $row['idFiliere'] . "' $selected>" . htmlspecialchars($row['NomFiliere']) . "</option>";
                }
                ?>
            </select>

            <label for="idEnseignant">Enseignant</label>
            <select name="idEnseignant" id="idEnseignant" required>
                <?php
                // Charger la liste des enseignants
                $enseignantQuery = "SELECT idEnseignant, Nom, Prenom FROM enseignants";
                $enseignantResult = $conn->query($enseignantQuery);
                while ($row = $enseignantResult->fetch_assoc()) {
                    $selected = ($matiere['idEnseignant'] == $row['idEnseignant']) ? "selected" : "";
                    echo "<option value='" . $row['idEnseignant'] . "' $selected>" . htmlspecialchars($row['Nom'] . " " . $row['Prenom']) . "</option>";
                }
                ?>
            </select>

            <button type="submit">Mettre à Jour</button>
        </form>

        <div class="back-button">
            <a href="afficher_matieres.php">Retour à la Liste</a>
        </div>
    </div>
</body>
</html>
