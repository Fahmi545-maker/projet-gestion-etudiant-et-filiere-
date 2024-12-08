<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des données</title>
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
            position: absolute;
            top: 22%;
            font-size: 60px;
            color: #005f7f;
        }

        .content-table {
            border-collapse: collapse;
            margin-top: 80px;
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

        .action-links a {
            color: #ffffff;
            background-color: #005f7f;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 20px;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        .action-links a:hover {
            background-color: #003f5f;
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
    <h1>Affichage des données</h1>
    <table class="content-table">
        <thead>
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
        </thead>
        <tbody>
            <?php
            // === Configuration sécurisée de la base de données ===
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gestionetudiant1";

            // Connexion sécurisée à la base de données
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérification de la connexion
            if ($conn->connect_error) {
                die("Échec de la connexion : " . htmlspecialchars($conn->connect_error));
            }

            // Préparer la requête pour éviter les injections SQL
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
            ";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->execute();
                $result = $stmt->get_result();

                // Vérifier si des données existent
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["Nom"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Prenom"]); ?></td>
                            <td><?php echo htmlspecialchars($row["DateNaissance"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Apogee"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Pays"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Ville"]); ?></td>
                            <td><?php echo htmlspecialchars($row["NomFiliere"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Niveau"]); ?></td>
                            <td class="action-links">
                                <a href="supprimer.php?Apogee=<?php echo urlencode($row["Apogee"]); ?>">Supprimer</a>
                                <a href="editer.php?Apogee=<?php echo urlencode($row["Apogee"]); ?>">Éditer</a>
                                <a href="pdf.php?Apogee=<?php echo urlencode($row["Apogee"]); ?>">Attestation</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='9'>Aucun étudiant trouvé.</td></tr>";
                }

                $stmt->close(); // Libérer les ressources
            } else {
                echo "Erreur lors de la préparation de la requête.";
            }

            // Fermer la connexion
            $conn->close();
            ?>
        </tbody>
    </table>
    <div class="add-button">
        <a href="dashboard.php">Retour</a>
    </div>
</body>

</html>
