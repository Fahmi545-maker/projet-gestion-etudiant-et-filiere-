<?php
session_start();
$conn = new mysqli("localhost", "root", "", "gestionetudiant1");

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$error = "";

// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Vérifier l'existence de l'utilisateur
    $query = "SELECT * FROM employes WHERE Email='$email'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Vérification du mot de passe
        if (hash('sha256', $password) === $user['MotDePasse']) {
            // Enregistrement dans la session
            $_SESSION['employe_id'] = $user['idEmploye'];
            $_SESSION['employe_nom'] = $user['Nom'];
            $_SESSION['employe_prenom'] = $user['Prenom'];
            $_SESSION['role'] = $user['Role'];

            // Redirection en fonction du rôle
            if ($user['Role'] == 'gestion_etudiants') {
                header("Location: dashboard.php");
            } elseif ($user['Role'] == 'gestion_filieres') {
                header("Location: dashboard_filieres.php");
            } else {
                $error = "Rôle non reconnu.";
            }
            exit;
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Utilisateur non trouvé.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .login-form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-form h2 {
            margin-bottom: 20px;
            color: #005f7f;
            text-align: center;
        }
        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #005f7f;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-form button:hover {
            background-color: #003f5f;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form class="login-form" method="POST">
        <h2>Connexion</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
</body>
</html>
