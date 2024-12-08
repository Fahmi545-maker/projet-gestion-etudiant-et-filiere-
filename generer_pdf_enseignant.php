<?php
// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionetudiant1";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérification si l'ID de l'enseignant est passé
if (isset($_GET['id'])) {
    $idEnseignant = intval($_GET['id']);

    // Inclure la bibliothèque TCPDF
    require_once(__DIR__ . '/TCPDF/tcpdf.php');

    // Requête pour récupérer les données de l'enseignant
    $query = "SELECT Nom, Prenom, Email, Telephone, Specialite FROM enseignants WHERE idEnseignant = $idEnseignant";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom = $row['Nom'];
        $prenom = $row['Prenom'];
        $email = $row['Email'];
        $telephone = $row['Telephone'];
        $specialite = $row['Specialite'];

        // Initialisation du PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetMargins(20, 20, 20);
        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->AddPage();

        // Contenu du PDF
        $pdf->SetFont('helvetica', '', 12);
        $html = <<<EOD
        <h2>Informations sur l'Enseignant</h2>
        <table cellspacing="5" cellpadding="5" border="1">
            <tr>
                <td><strong>Nom :</strong></td>
                <td>{$nom}</td>
            </tr>
            <tr>
                <td><strong>Prénom :</strong></td>
                <td>{$prenom}</td>
            </tr>
            <tr>
                <td><strong>Email :</strong></td>
                <td>{$email}</td>
            </tr>
            <tr>
                <td><strong>Téléphone :</strong></td>
                <td>{$telephone}</td>
            </tr>
            <tr>
                <td><strong>Spécialité :</strong></td>
                <td>{$specialite}</td>
            </tr>
        </table>
        <br>
        <p>Ce document contient les informations actuelles de l'enseignant dans notre base de données.</p>
        EOD;

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output("enseignant_{$idEnseignant}.pdf", 'D');
    } else {
        die("Enseignant introuvable.");
    }
} else {
    die("ID non spécifié.");
}

// Fermeture de la connexion
$conn->close();
?>
