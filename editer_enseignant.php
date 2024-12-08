<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionetudiant1";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $idEnseignant = $_GET['id'];

    // Récupérer les données de l'enseignant à éditer
    $query = "SELECT * FROM enseignants WHERE idEnseignant = '$idEnseignant'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        ?>
<html>

<head>
    <title>Éditer un Enseignant</title>
    <style>
        body {
            background-image: url(1.jpg);
            padding: 0 10px;
            background-position: center;
            background-size: cover;
            font-family: 'Montserrat', sans-serif;
            margin-top: 40px;
        }

        .wrapper {
            max-width: 500px;
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            margin: 20px auto;
            box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.125);
            padding: 30px;
        }

        .wrapper .title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #005f7f;
            text-transform: uppercase;
            text-align: center;
        }

        .wrapper .form {
            width: 100%;
        }

        .wrapper .form .inputfield {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .wrapper .form .inputfield label {
            width: 200px;
            color: #000000;
            margin-right: 10px;
            font-size: 14px;
        }

        .wrapper .form .inputfield .input {
            width: 100%;
            outline: none;
            border: 1px solid #d5dbd9;
            font-size: 15px;
            padding: 8px 10px;
            border-radius: 3px;
            transition: all 0.3s ease;
            color: #000000;
        }

        .wrapper .form .inputfield .btn {
            width: 100%;
            padding: 8px 10px;
            font-size: 15px;
            border: 0px;
            background: #005f7f;
            color: #fff;
            cursor: pointer;
            border-radius: 3px;
            outline: none;
        }

        .wrapper .form .inputfield .btn:hover {
            background: rgb(56, 103, 134);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="title">Éditer un Enseignant</div>
        <div class="form">
            <form action="editer_enseignant.php" method="POST">
                <input type="hidden" name="idEnseignant" value="<?php echo $row['idEnseignant']; ?>">
                <div class="inputfield">
                    <label for="Nom">Nom :</label>
                    <input type="text" class="input" name="Nom" value="<?php echo $row['Nom']; ?>">
                </div>
                <div class="inputfield">
                    <label for="Prenom">Prénom :</label>
                    <input type="text" class="input" name="Prenom" value="<?php echo $row['Prenom']; ?>">
                </div>
                <div class="inputfield">
                    <label for="Email">Email :</label>
                    <input type="email" class="input" name="Email" value="<?php echo $row['Email']; ?>">
                </div>
                <div class="inputfield">
                    <label for="Telephone">Téléphone :</label>
                    <input type="text" class="input" name="Telephone" value="<?php echo $row['Telephone']; ?>">
                </div>
                <div class="inputfield">
                    <label for="Specialite">Spécialité :</label>
                    <input type="text" class="input" name="Specialite" value="<?php echo $row['Specialite']; ?>">
                </div>
                <div class="inputfield">
                    <button type="submit" class="btn">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php
    }
}

// Mise à jour des données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEnseignant = $_POST['idEnseignant'];
    $nom = $_POST['Nom'];
    $prenom = $_POST['Prenom'];
    $email = $_POST['Email'];
    $telephone = $_POST['Telephone'];
    $specialite = $_POST['Specialite'];

    $updateQuery = "UPDATE enseignants
                    SET Nom = '$nom',
                        Prenom = '$prenom',
                        Email = '$email',
                        Telephone = '$telephone',
                        Specialite = '$specialite'
                    WHERE idEnseignant = '$idEnseignant'";

    if ($conn->query($updateQuery) === TRUE) {
        header("Location: enseignants.php");
        exit;
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }
}

$conn->close();
?>
