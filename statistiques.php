<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Étudiants</title>
    <style>
        body {
            height: 100vh;
            background-image: url(1.jpg);
            background-position: center;
            background-size: cover;
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            font-size: 50px;
            color: #005f7f;
        }

        h2 {
            text-align: center;
            margin-top: 40px;
            font-size: 30px;
            color: #005f7f;
        }

        .content-table {
            border-collapse: collapse;
            margin: 20px auto;
            font-size: 1em;
            width: 80%;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .content-table thead tr {
            background-color: #005f7f;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
        }

        .content-table th,
        .content-table td {
            padding: 12px 15px;
            text-align: center;
        }

        .content-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .content-table tbody tr:nth-of-type(even) {
            background-color: #f9f9f9;
        }

        .content-table tbody tr:last-of-type {
            border-bottom: 2px solid #005f7f;
        }

        .add-button {
            text-align: center;
            margin: 30px 0;
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
    <h1>Statistiques des Étudiants</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestionetudiant1";

    // Connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Requête pour les statistiques par filière
    $sqlFiliere = "
        SELECT f.NomFiliere, COUNT(e.idEtudiants) AS nombre_etudiants
        FROM etudiant e
        LEFT JOIN filieres f ON e.idFiliere = f.idFiliere
        GROUP BY f.NomFiliere
    ";
    $resultFiliere = $conn->query($sqlFiliere);

    // Requête pour les statistiques par niveau
    $sqlNiveau = "
        SELECT n.Niveau, COUNT(e.idEtudiants) AS nombre_etudiants
        FROM etudiant e
        LEFT JOIN niveau n ON e.idNiveau = n.idNiveau
        GROUP BY n.Niveau
    ";
    $resultNiveau = $conn->query($sqlNiveau);

    // Requête pour les statistiques par ville
    $sqlVille = "
        SELECT e.Ville, COUNT(*) AS nombre_etudiants
        FROM etudiant e
        GROUP BY e.Ville
    ";
    $resultVille = $conn->query($sqlVille);
    ?>

    <h2>Par Filière</h2>
    <table class="content-table">
        <thead>
            <tr>
                <th>Filière</th>
                <th>Nombre d'Étudiants</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultFiliere->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['NomFiliere']); ?></td>
                    <td><?= htmlspecialchars($row['nombre_etudiants']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Par Niveau</h2>
    <table class="content-table">
        <thead>
            <tr>
                <th>Niveau</th>
                <th>Nombre d'Étudiants</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultNiveau->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Niveau']); ?></td>
                    <td><?= htmlspecialchars($row['nombre_etudiants']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Par Ville</h2>
    <table class="content-table">
        <thead>
            <tr>
                <th>Ville</th>
                <th>Nombre d'Étudiants</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultVille->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Ville']); ?></td>
                    <td><?= htmlspecialchars($row['nombre_etudiants']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="add-button">
        <a href="dashboard.php">Retour</a>
    </div>

    <?php
    $conn->close();
    ?>
</body>

</html>
