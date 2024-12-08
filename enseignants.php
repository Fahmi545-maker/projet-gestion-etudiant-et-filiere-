<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Enseignants</title>
    <style>
        body {
            height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url(1.jpg);
            background-position: center;
            background-size: cover;
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
    <h1>Gestion des Enseignants</h1>
    <table class="content-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Spécialité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
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

            // Requête SQL pour récupérer les données des enseignants
            $sql = "
                SELECT 
                    idEnseignant, 
                    Nom, 
                    Prenom, 
                    Email, 
                    Telephone, 
                    Specialite
                FROM enseignants
            ";

            $result = $conn->query($sql);

            // Vérifier si des données existent
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["Nom"]); ?></td>
                        <td><?php echo htmlspecialchars($row["Prenom"]); ?></td>
                        <td><?php echo htmlspecialchars($row["Email"]); ?></td>
                        <td><?php echo htmlspecialchars($row["Telephone"]); ?></td>
                        <td><?php echo htmlspecialchars($row["Specialite"]); ?></td>
                        <td class="action-links">
                            <a href="editer_enseignant.php?id=<?php echo $row["idEnseignant"]; ?>">Éditer</a>
                            <a href="supprimer_enseignant.php?id=<?php echo $row["idEnseignant"]; ?>">Supprimer</a>
                            <!-- Bouton pour générer le PDF -->
                            <a href="generer_pdf_enseignant.php?id=<?php echo $row['idEnseignant']; ?>">Télécharger PDF</a>
                        </td>
                     

                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='6'>Aucun enseignant trouvé.</td></tr>";
            }

            // Fermer la connexion
            $conn->close();
            ?>
        </tbody>
    </table>
    <div class="add-button">
        <a href="ajouter_enseignant.php">Ajouter Enseignant</a>
        <a href="dashboard_filieres.php">Retour Acceuil</a>
    </div>
</body>

</html>
