<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>École Supérieure EST - Gestion Filières</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('1.jpg');
            background-position: center;
            background-size: cover;
            color: #333;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #005f7f;
            padding: 15px 20px;
            color: white;
        }

        .navbar h1 {
            font-size: 26px;
            margin: 0;
        }

        .navbar a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar a:hover {
            background-color: #003f5f;
        }

        .content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
        }

        .content h2 {
            font-size: 36px;
            color: #005f7f;
            margin-bottom: 20px;
        }

        .content h4 {
            font-size: 24px;
            color: #333;
            margin-bottom: 40px;
        }

        .section {
            margin-bottom: 40px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .section h3 {
            font-size: 28px;
            color: #005f7f;
            margin-bottom: 20px;
        }

        .links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .links a {
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            background-color: #005f7f;
            color: white;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .links a:hover {
            background-color: #003f5f;
            transform: scale(1.05);
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 10px;
            background-color: #005f7f;
            color: white;
            font-size: 14px;
        }

        .footer a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <h1>École Supérieure - Gestion Filières</h1>
        <div>
            <a href="logout.php">Déconnexion</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Bienvenue à l'École Supérieure</h2>

        <!-- Bienvenue personnalisé -->
        <h4>
            <?php
            session_start();
            if (isset($_SESSION['employe_nom'])) {
                echo "Bienvenue, " . htmlspecialchars($_SESSION['employe_nom']) . "!";
            } else {
                echo "Bienvenue, cher employé!";
            }
            ?>
        </h4>

        <!-- Section Gestion des Enseignants -->
        <div class="section">
            <h3>Gestion des Enseignants</h3>
            <div class="links">
                <a href="ajouter_enseignant.php">Ajouter Enseignant</a>
                <a href="chercher_enseignant.php">Chercher Enseignant</a>
                <a href="enseignants.php">Afficher Enseignants</a>
            </div>
        </div>

        <!-- Section Gestion des Matières -->
        <div class="section">
            <h3>Gestion des Matières</h3>
            <div class="links">
                <a href="ajouter_matiere.php">Ajouter Matière</a>
                <a href="afficher_matieres.php">Afficher Matières</a>
                
            </div>
        </div>


        <!-- Section Étudiants par Filière -->
        <div class="section">
            <h3>Étudiants par Filière</h3>
            <div class="links">
                <a href="lister_etudiants_filiere.php">Lister Étudiants</a>
            </div>
        </div>

        <!-- Section Statistiques -->
        <div class="section">
            <h3>Statistiques par Filière</h3>
            <div class="links">
                <a href="statistiques_filiere.php">Voir Statistiques</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 École Supérieure - Tous droits réservés. <a href="#">Mentions légales</a></p>
    </div>
</body>

</html>
