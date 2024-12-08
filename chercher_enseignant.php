<?php
// === Connexion à la base de données ===
// Les paramètres de connexion
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionetudiant1";

// Créer une connexion sécurisée à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez si la connexion a échoué
if ($conn->connect_error) {
    die("Échec de la connexion : " . htmlspecialchars($conn->connect_error));
}

// Initialisation des variables pour les résultats de recherche et les messages
$searchResults = [];
$message = "";

// === Rechercher un enseignant si le formulaire est soumis ===
if (isset($_GET['search'])) {
    $searchTerm = $conn->real_escape_string($_GET['searchTerm']); // Échapper les caractères spéciaux pour éviter les injections SQL

    // Requête sécurisée pour chercher les enseignants en fonction du terme saisi
    $sql = "
        SELECT * 
        FROM enseignants 
        WHERE Nom LIKE '%$searchTerm%' 
           OR Prenom LIKE '%$searchTerm%' 
           OR Email LIKE '%$searchTerm%' 
           OR Specialite LIKE '%$searchTerm%'
    ";

    // Exécuter la requête
    $result = $conn->query($sql);

    // Vérifier les résultats
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row; // Stocker les résultats dans un tableau
        }
    } else {
        $message = "Aucun enseignant trouvé pour : " . htmlspecialchars($searchTerm);
    }
}

// Fermer la connexion à la base de données à la fin
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher Enseignant</title>
    <style>
        /* === Style général de la page === */
        body {
            font-family: Arial, sans-serif;
            background-image: url('1.jpg'); /* Image d'arrière-plan */
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #005f7f;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 70%;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #005f7f;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #003f5f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            text-align: left;
            padding: 10px;
        }

        th {
            background-color: #005f7f;
            color: white;
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

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            text-decoration: none;
            background-color: #005f7f;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .back-button a:hover {
            background-color: #003f5f;
        }

        .message {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Rechercher Enseignant</h1>

        <!-- Formulaire de recherche -->
        <form method="GET">
            <input type="text" name="searchTerm" placeholder="Entrez un Nom, Prénom, Email ou Spécialité" required>
            <button type="submit" name="search">Rechercher</button>
        </form>

        <!-- Affichage du message si aucun résultat -->
        <?php if (isset($message)) : ?>
            <p class="message"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Affichage des résultats sous forme de table -->
        <?php if (!empty($searchResults)) : ?>
            <table>
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
                    <?php foreach ($searchResults as $enseignant) : ?>
                        <tr>
                            <td><?= htmlspecialchars($enseignant['Nom']); ?></td>
                            <td><?= htmlspecialchars($enseignant['Prenom']); ?></td>
                            <td><?= htmlspecialchars($enseignant['Email']); ?></td>
                            <td><?= htmlspecialchars($enseignant['Telephone']); ?></td>
                            <td><?= htmlspecialchars($enseignant['Specialite']); ?></td>
                            <td class="action-links">
                                <!-- Bouton Éditer -->
                                <a href="editer_enseignant.php?id=<?= urlencode($enseignant['idEnseignant']); ?>">Éditer</a>
                                <!-- Bouton Supprimer -->
                                <a href="supprimer_enseignant.php?id=<?= urlencode($enseignant['idEnseignant']); ?>"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?');">Supprimer</a>
                                <!-- Bouton Télécharger PDF -->
                                <a href="generer_pdf_enseignant.php?id=<?= urlencode($enseignant['idEnseignant']); ?>">PDF</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Bouton retour à l'accueil -->
        <div class="back-button">
            <a href="dashboard_filieres.php">Retour à Accueil</a>
        </div>
    </div>
</body>

</html>
