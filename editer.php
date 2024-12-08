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

if (isset($_GET['Apogee'])) {
    $apogee = $_GET['Apogee'];

    // Récupérer les données de l'étudiant à éditer, y compris la filière et le niveau
    $query = "SELECT e.*, f.Nomfiliere, n.Niveau 
              FROM etudiant e
              LEFT JOIN filieres f ON e.idFiliere = f.idFiliere
              LEFT JOIN niveau n ON e.idNiveau = n.idNiveau
              WHERE e.Apogee = '$apogee'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Récupérer toutes les options disponibles pour les filières et les niveaux
        $filiereResult = $conn->query("SELECT * FROM filieres");
        $niveauResult = $conn->query("SELECT * FROM niveau");
        ?>

<html>

<head>
    <title>Éditer les données</title>
    <style>
        * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
    }

    body {
      background-image: url(1.jpg);
      padding: 0 10px;
      background-position: center;
      background-size: cover;
      font-family: sans-serif;
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

.wrapper .form .inputfield .input{

width: 100%;
outline: none;
border: 1px solid #d5dbd9;
font-size: 15px;
padding: 8px 10px;
border-radius: 3px;
transition: all 0.3s ease;
color: #000000;
}



.wrapper .form .inputfield .custom_select {
position: relative;
width: 100%;
height: 37px;
}

.wrapper .form .inputfield .custom_select:before {
content: "";
position: absolute;
top: 12px;
right: 10px;
border: 8px solid;
border-color: #c8caca transparent transparent transparent;
pointer-events: none;
}

.wrapper .form .inputfield .custom_select select {
-webkit-appearance: none;
-moz-appearance: none;
appearance: none;
outline: none;
width: 100%;
height: 100%;
border: 0px;
padding: 8px 10px;
font-size: 15px;
border: 2px solid #d5dbd9;
border-radius: 3px;
}


.wrapper .form .inputfield .input:focus,
.wrapper .form .inputfield .textarea:focus,
.wrapper .form .inputfield .custom_select select:focus {
border: 1px solid #005f7f;
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

.btn:hover {
background: rgb(61, 121, 161);
}

.wrapper .form .inputfield .btn:hover {
background: rgb(56, 103, 134);
}

.wrapper .form .inputfield:last-child {
margin-bottom: 0;
}
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="title">
            Éditer les données
        </div>
        <div class="form">
            <form action="editer.php" method="POST">
                <div>
                    <input type="hidden" name="Apogee" value="<?php echo $row['Apogee']; ?>">
                </div>
                <div class="inputfield">
                    <label for="Nom">Nom :</label>
                    <input type="text" class="input" name="Nom" value="<?php echo $row['Nom']; ?>">
                </div>
                <div class="inputfield">
                    <label for="Prenom">Prénom :</label>
                    <input type="text" class="input" name="Prenom" value="<?php echo $row['Prenom']; ?>">
                </div>
                <div class="inputfield">
                    <label for="DateNaissance">Date de Naissance :</label>
                    <input type="date" class="input" name="DateNaissance" value="<?php echo $row['DateNaissance']; ?>">
                </div>
                <div class="inputfield">
                    <label for="Pays">Pays :</label>
                    <div class="custom_select">
                        <select name="Pays">
                            <option value="Marocain(e)" <?php echo ($row['Pays'] == 'Marocain(e)') ? 'selected' : ''; ?>>
                                Marocain(e)</option>
                            <option value="étrangèr(e)" <?php echo ($row['Pays'] == 'étrangèr(e)') ? 'selected' : ''; ?>>
                                étrangèr(e)</option>
                        </select>
                    </div>
                </div>
                <div class="inputfield">
                    <label for="Ville">Ville :</label>
                    <input type="text" class="input" name="Ville" value="<?php echo $row['Ville']; ?>">
                </div>
                <div class="inputfield">
                    <label for="idFiliere">Filière :</label>
                    <div class="custom_select">
                        <select name="idFiliere">
                            <?php while ($filiereRow = $filiereResult->fetch_assoc()) { ?>
                                <option value="<?php echo $filiereRow['idFiliere']; ?>"
                                    <?php echo ($row['idFiliere'] == $filiereRow['idFiliere']) ? 'selected' : ''; ?>>
                                    <?php echo $filiereRow['Nomfiliere']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="inputfield">
                    <label for="idNiveau">Niveau :</label>
                    <div class="custom_select">
                        <select name="idNiveau">
                            <?php while ($niveauRow = $niveauResult->fetch_assoc()) { ?>
                                <option value="<?php echo $niveauRow['idNiveau']; ?>"
                                    <?php echo ($row['idNiveau'] == $niveauRow['idNiveau']) ? 'selected' : ''; ?>>
                                    <?php echo $niveauRow['Niveau']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="inputfield">
                    <button type="submit" name="Envoyer" class="btn">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php
    }
}

// Vérifier si des données ont été envoyées pour mise à jour
if (isset($_POST['Envoyer'])) {
    $apogee = $_POST['Apogee'];
    $nom = $_POST['Nom'];
    $prenom = $_POST['Prenom'];
    $dateNaissance = $_POST['DateNaissance'];
    $pays = $_POST['Pays'];
    $ville = $_POST['Ville'];
    $idFiliere = $_POST['idFiliere'];
    $idNiveau = $_POST['idNiveau'];

    // Requête de mise à jour
    $updateQuery = "UPDATE etudiant
                    SET Nom = '$nom',
                        Prenom = '$prenom',
                        DateNaissance = '$dateNaissance',
                        Pays = '$pays',
                        Ville = '$ville',
                        idFiliere = $idFiliere,
                        idNiveau = $idNiveau
                    WHERE Apogee = '$apogee'";

    if ($conn->query($updateQuery) === TRUE) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Erreur : " . $conn->error;
    }
}

// Fermer la connexion
$conn->close();
?>