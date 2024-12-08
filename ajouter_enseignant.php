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
    $email = $conn->real_escape_string($_POST['Email']);
    $telephone = $conn->real_escape_string($_POST['Telephone']);
    $specialite = $conn->real_escape_string($_POST['Specialite']);
    $accord = isset($_POST['accord']) ? 1 : 0;

    // Valider que la case à cocher est cochée
    if (!$accord) {
        echo "<p style='color: red; text-align: center;'>Vous devez accepter l'utilisation des données personnelles.</p>";
    } else {
        $sql = "INSERT INTO enseignants (Nom, Prenom, Email, Telephone, Specialite, accord) 
                VALUES ('$nom', '$prenom', '$email', '$telephone', '$specialite', '$accord')";

        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard_filieres.php");
            exit;
        } else {
            echo "Erreur lors de l'ajout de l'enseignant : " . $conn->error;
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
    <title>Ajouter un Enseignant</title>
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
        .form-container button {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-container input:focus {
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
        <h1>Ajouter un Enseignant</h1>
        <form class="form-container" action="ajouter_enseignant.php" method="POST">
            <div>
                <label for="Nom">Nom :</label>
                <input type="text" id="Nom" name="Nom" required>
            </div>
            <div>
                <label for="Prenom">Prénom :</label>
                <input type="text" id="Prenom" name="Prenom" required>
            </div>
            <div>
                <label for="Email">Email :</label>
                <input type="email" id="Email" name="Email" required>
            </div>
            <div>
                <label for="Telephone">Téléphone :</label>
                <input type="text" id="Telephone" name="Telephone" required>
            </div>
            <div>
                <label for="Specialite">Spécialité :</label>
                <input type="text" id="Specialite" name="Specialite" required>
            </div>
            <div class="checkbox-container">
                <input type="checkbox" id="accord" name="accord" required>
                <label for="accord">J'accepte que mes données soient utilisées uniquement à des fins administratives de l'école.</label>
            </div>
            <button type="submit">Ajouter</button>
        </form>
        <div class="back-button">
            <a href="dashboard_filieres.php">Retour au Dashboard</a>
        </div>
    </div>
</body>

</html>
