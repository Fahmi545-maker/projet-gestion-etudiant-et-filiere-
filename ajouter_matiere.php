<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Matière</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('1.jpg');
            background-position: center;
            background-size: cover;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        .container h1 {
            text-align: center;
            color: #005f7f;
            margin-bottom: 20px;
        }

        .container label {
            display: block;
            margin: 10px 0 5px;
            font-size: 14px;
            color: #333;
        }

        .container input,
        .container select,
        .container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .container button {
            background-color: #005f7f;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .container button:hover {
            background-color: #003f5f;
        }

        .back-button {
            text-align: center;
            margin-top: 10px;
        }

        .back-button a {
            text-decoration: none;
            color: #005f7f;
            font-weight: bold;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Ajouter Matière</h1>

        <?php
        // Connexion à la base de données
        $conn = new mysqli("localhost", "root", "", "gestionetudiant1");

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        $message = "";

        // Gestion du formulaire d'ajout
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nomMatiere = $conn->real_escape_string($_POST['nomMatiere']);
            $coefficient = $conn->real_escape_string($_POST['coefficient']);
            $idFiliere = intval($_POST['idFiliere']);
            $idEnseignant = intval($_POST['idEnseignant']);

            $query = "INSERT INTO matieres (NomMatiere, Coefficient, idFiliere, idEnseignant)
                      VALUES ('$nomMatiere', '$coefficient', '$idFiliere', '$idEnseignant')";

            if ($conn->query($query) === TRUE) {
                $message = "<div class='message success'>Matière ajoutée avec succès.</div>";
            } else {
                $message = "<div class='message error'>Erreur : " . $conn->error . "</div>";
            }
        }
        ?>

        <!-- Message -->
        <?php echo $message; ?>

        <form method="POST">
            <!-- Nom de la Matière -->
            <label for="nomMatiere">Nom de la Matière</label>
            <input type="text" name="nomMatiere" id="nomMatiere" placeholder="Entrez le nom de la matière" required>

            <!-- Coefficient -->
            <label for="coefficient">Coefficient</label>
            <input type="number" step="0.1" name="coefficient" id="coefficient" placeholder="Entrez le coefficient" required>

            <!-- Filière -->
            <label for="idFiliere">Filière</label>
            <select name="idFiliere" id="idFiliere" required>
                <option value="">Sélectionnez une filière</option>
                <?php
                $filiereQuery = "SELECT idFiliere, NomFiliere FROM filieres";
                $filiereResult = $conn->query($filiereQuery);
                while ($row = $filiereResult->fetch_assoc()) {
                    echo "<option value='" . $row['idFiliere'] . "'>" . htmlspecialchars($row['NomFiliere']) . "</option>";
                }
                ?>
            </select>

            <!-- Enseignant -->
            <label for="idEnseignant">Enseignant</label>
            <select name="idEnseignant" id="idEnseignant" required>
                <option value="">Sélectionnez un enseignant</option>
                <?php
                $enseignantQuery = "SELECT idEnseignant, Nom, Prenom FROM enseignants";
                $enseignantResult = $conn->query($enseignantQuery);
                while ($row = $enseignantResult->fetch_assoc()) {
                    echo "<option value='" . $row['idEnseignant'] . "'>" . htmlspecialchars($row['Nom'] . " " . $row['Prenom']) . "</option>";
                }
                ?>
            </select>

            <!-- Bouton Ajouter -->
            <button type="submit">Ajouter</button>
        </form>

        <!-- Bouton Retour -->
        <div class="back-button">
            <a href="dashboard_filieres.php">Retour au Dashboard</a>
        </div>
    </div>
</body>

</html>
