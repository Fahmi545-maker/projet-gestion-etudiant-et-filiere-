<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chercher Étudiants</title>
    <style>
        body {
            height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url(1.jpg);
            background-position: center;
            background-size: 125%;
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 40px;
            color: #005f7f;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        .search-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #005f7f;
            border-radius: 5px;
            margin-right: 10px;
            width: 300px;
        }

        .search-bar button {
            background-color: #005f7f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-bar button:hover {
            background-color: #003f5f;
        }

        .content-table {
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 0.9em;
            min-width: 600px;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .content-table thead tr {
            background-color: #005f7f;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }

        .content-table th,
        .content-table td {
            padding: 12px 15px;
        }

        .content-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .content-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .content-table tbody tr:last-of-type {
            border-bottom: 2px solid #005f7f;
        }

        .add-button {
            text-align: center;
            margin-top: 20px;
        }

        .add-button a {
            background-color: #005f7f;
            color: #ffffff;
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 30px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-button a:hover {
            background-color: #ffffff;
            color: #005f7f;
        }
    </style>
</head>

<body>
    <h1>Rechercher un Étudiant</h1>
    <div class="search-bar">
        <form action="chercher.php" method="GET">
            <input type="text" name="recherche" placeholder="Nom, Prénom ou Apogée..." required>
            <button type="submit">Chercher</button>
        </form>
    </div>

    <?php
    // Configuration de la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestionetudiant1";

    // Connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Vérifier si une recherche a été soumise
    if (isset($_GET['recherche'])) {
        $recherche = $conn->real_escape_string($_GET['recherche']);

        // Requête SQL pour la recherche
        $sql = "
            SELECT 
                e.Nom, 
                e.Prenom, 
                e.DateNaissance, 
                e.Apogee, 
                e.Pays, 
                e.Ville, 
                f.NomFiliere, 
                n.Niveau
            FROM etudiant e
            LEFT JOIN filieres f ON e.idFiliere = f.idFiliere
            LEFT JOIN niveau n ON e.idNiveau = n.idNiveau
            WHERE e.Nom LIKE '%$recherche%' 
                OR e.Prenom LIKE '%$recherche%' 
                OR e.Apogee LIKE '%$recherche%'
        ";

        $result = $conn->query($sql);

        echo '<table class="content-table">';
        echo '<thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Apogée</th>
                    <th>Pays</th>
                    <th>Ville</th>
                    <th>Filière</th>
                    <th>Niveau</th>
                    <th>Actions</th>
                </tr>
              </thead>';
        echo '<tbody>';

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Nom']}</td>
                        <td>{$row['Prenom']}</td>
                        <td>{$row['DateNaissance']}</td>
                        <td>{$row['Apogee']}</td>
                        <td>{$row['Pays']}</td>
                        <td>{$row['Ville']}</td>
                        <td>{$row['NomFiliere']}</td>
                        <td>{$row['Niveau']}</td>
                        <td>
                            <a href='editer.php?Apogee={$row['Apogee']}'>Éditer</a>
                            <a href='supprimer.php?Apogee={$row['Apogee']}'>Supprimer</a>
                            <a href='pdf.php?Apogee={$row['Apogee']}'>Attestation</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Aucun étudiant trouvé.</td></tr>";
        }

        echo '</tbody>';
        echo '</table>';
    }

    $conn->close();
    ?>

    <div class="add-button">
        <a href="dashboard.php">Retour au Dashboard</a>
    </div>
</body>

</html>
