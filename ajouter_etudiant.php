<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionetudiant1";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $conn->real_escape_string($_POST['Nom']);
    $prenom = $conn->real_escape_string($_POST['Prenom']);
    $apogee = $conn->real_escape_string($_POST['Apogee']);
    $dateNaissance = $conn->real_escape_string($_POST['DateNaissance']);
    $ville = $conn->real_escape_string($_POST['Ville']);
    $pays = $conn->real_escape_string($_POST['Pays']);
    $idFiliere = intval($_POST['idFiliere']);
    $idNiveau = intval($_POST['idNiveau']);
    $accord = isset($_POST['accord']) ? 1 : 0;

    // Valider que la case à cocher est cochée
    if (!$accord) {
        echo "<p style='color: red; text-align: center;'>Vous devez accepter l'utilisation des données personnelles.</p>";
    } else {
        $sql = "INSERT INTO etudiant (Nom, Prenom, Apogee, DateNaissance, Ville, Pays, idFiliere, idNiveau, accord) 
                VALUES ('$nom', '$prenom', '$apogee', '$dateNaissance', '$ville', '$pays', '$idFiliere', '$idNiveau', '$accord')";

        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Erreur lors de l'ajout de l'étudiant : " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Étudiant</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url('1.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .wrapper {
            max-width: 600px;
            width: 90%;
            background: rgba(255, 255, 255, 0.95);
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .wrapper h1 {
            text-align: center;
            color: #005f7f;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-container label {
            font-weight: bold;
            color: #005f7f;
            margin-bottom: 5px;
        }

        .form-container input,
        .form-container select,
        .form-container button {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-container input:focus,
        .form-container select:focus {
            border-color: #005f7f;
            box-shadow: 0 0 8px rgba(0, 95, 127, 0.5);
            outline: none;
        }

        .form-container button {
            background-color: #005f7f;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .form-container button:hover {
            background-color: #003f5f;
            transform: translateY(-3px);
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-container input[type="checkbox"] {
            transform: scale(1.2);
            cursor: pointer;
        }

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            text-decoration: none;
            background-color: #005f7f;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back-button a:hover {
            background-color: #003f5f;
            transform: translateY(-3px);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h1>Ajouter un Étudiant</h1>
        <form class="form-container" action="ajouter_etudiant.php" method="POST">
            <div>
                <label for="Nom">Nom :</label>
                <input type="text" id="Nom" name="Nom" required>
            </div>
            <div>
                <label for="Prenom">Prénom :</label>
                <input type="text" id="Prenom" name="Prenom" required>
            </div>
            <div>
                <label for="Apogee">Apogée :</label>
                <input type="text" id="Apogee" name="Apogee" required>
            </div>
            <div>
                <label for="DateNaissance">Date de Naissance :</label>
                <input type="date" id="DateNaissance" name="DateNaissance" required>
            </div>
            <div>
                <label for="Ville">Ville :</label>
                <input type="text" id="Ville" name="Ville" required>
            </div>
            <div>
                <label for="Pays">Pays :</label>
                <input type="text" id="Pays" name="Pays" required>
            </div>
            <div>
                <label for="idFiliere">Filière :</label>
                <select id="idFiliere" name="idFiliere" required>
                    <option value="83">Génie Informatique</option>
                    <option value="84">Génie Logiciel</option>
                </select>
            </div>
            <div>
                <label for="idNiveau">Niveau :</label>
                <select id="idNiveau" name="idNiveau" required>
                    <option value="83">Première année</option>
                    <option value="84">Deuxième année</option>
                </select>
            </div>
            <div class="checkbox-container">
                <input type="checkbox" id="accord" name="accord" required>
                <label for="accord">J'accepte que mes données soient utilisées uniquement à des fins administratives de l'école.</label>
            </div>
            <button type="submit">Ajouter</button>
        </form>
        <div class="back-button">
            <a href="dashboard.php">Retour au Dashboard</a>
        </div>
    </div>
</body>

</html>
