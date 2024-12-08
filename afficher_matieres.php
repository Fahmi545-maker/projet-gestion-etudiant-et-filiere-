<?php
// === DÉBUT DU SCRIPT PHP ===
// On commence par activer les sessions pour utiliser des fonctionnalités avancées comme les jetons CSRF
session_start();

// === GÉNÉRATION D'UN TOKEN CSRF ===
// Le jeton CSRF (Cross-Site Request Forgery) est utilisé pour éviter les attaques provenant de sites externes.
// Il est généré une fois par session et utilisé dans les formulaires ou actions sensibles.
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Génère une chaîne aléatoire de 32 octets
}

// === CONFIGURATION DE LA BASE DE DONNÉES ===
// Les informations de connexion sont ici (cela peut être remplacé par des variables d'environnement pour plus de sécurité)
$servername = "localhost"; // Nom du serveur
$username = "root";        // Nom d'utilisateur de la base de données
$password = "";            // Mot de passe de la base de données
$dbname = "gestionetudiant1"; // Nom de la base de données

// === CONNEXION À LA BASE DE DONNÉES ===
// On utilise `new mysqli` pour se connecter à la base de données MySQL.
$conn = new mysqli($servername, $username, $password, $dbname);

// === VÉRIFICATION DE LA CONNEXION ===
// Si la connexion échoue, un message d'erreur générique est affiché et les détails sont enregistrés dans un fichier journal.
if ($conn->connect_error) {
    error_log("Erreur de connexion : " . $conn->connect_error); // Enregistre l'erreur dans un fichier journal
    die("Une erreur s'est produite. Veuillez réessayer plus tard."); // Affiche un message générique
}

// === REQUÊTE SÉCURISÉE POUR RÉCUPÉRER LES MATIÈRES ===
// La requête SQL utilise une jointure pour récupérer les informations nécessaires.
$sql = "
    SELECT 
        m.NomMatiere, 
        m.Coefficient, 
        f.NomFiliere, 
        CONCAT(e.Nom, ' ', e.Prenom) AS Enseignant, 
        m.idMatiere
    FROM matieres m
    JOIN filieres f ON m.idFiliere = f.idFiliere
    JOIN enseignants e ON m.idEnseignant = e.idEnseignant
";

// Prépare la requête (protection contre les injections SQL)
$stmt = $conn->prepare($sql);
$stmt->execute(); // Exécute la requête
$result = $stmt->get_result(); // Récupère les résultats
?>
<!-- === FIN DU SCRIPT PHP === -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Matières</title>
    <style>
        /* === STYLES CSS POUR LE DESIGN === */
        body {
            height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url('1.jpg'); /* Image d'arrière-plan */
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
    <!-- === TITRE PRINCIPAL === -->
    <h1>Gestion des Matières</h1>

    <!-- === TABLEAU POUR AFFICHER LES MATIÈRES === -->
    <table class="content-table">
        <thead>
            <tr>
                <th>Nom de la Matière</th>
                <th>Coefficient</th>
                <th>Filière</th>
                <th>Enseignant</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // === AFFICHAGE DES MATIÈRES ===
            if ($result && $result->num_rows > 0): // Vérifie si des matières sont trouvées
                while ($row = $result->fetch_assoc()): // Parcourt chaque ligne des résultats
            ?>
                    <tr>
                        <!-- Sécurise les données affichées avec htmlspecialchars -->
                        <td><?php echo htmlspecialchars($row['NomMatiere']); ?></td>
                        <td><?php echo htmlspecialchars($row['Coefficient']); ?></td>
                        <td><?php echo htmlspecialchars($row['NomFiliere']); ?></td>
                        <td><?php echo htmlspecialchars($row['Enseignant']); ?></td>
                        <td class="action-links">
                            <!-- Liens sécurisés avec urlencode pour éviter les injections -->
                            <a href="editer_matiere.php?id=<?php echo urlencode($row['idMatiere']); ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>">Éditer</a>
                            <a href="supprimer_matiere.php?id=<?php echo urlencode($row['idMatiere']); ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?');">Supprimer</a>
                        </td>
                    </tr>
            <?php
                endwhile; // Fin de la boucle
            else: // Si aucune matière n'est trouvée
                echo "<tr><td colspan='5'>Aucune matière trouvée.</td></tr>";
            endif;
            $conn->close(); // Ferme la connexion à la base de données
            ?>
        </tbody>
    </table>

    <!-- === BOUTONS POUR AJOUTER UNE MATIÈRE OU RETOURNER À L'ACCUEIL === -->
    <div class="add-button">
        <a href="ajouter_matiere.php">Ajouter Matière</a>
        <a href="dashboard_filieres.php">Retour Accueil</a>
    </div>
</body>
</html>

