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
    $apogee = $conn->real_escape_string($_GET['Apogee']); // Sécuriser la donnée

    // Inclure la bibliothèque TCPDF
    require_once(__DIR__ . '/TCPDF/tcpdf.php');



    // Récupérer les informations de l'étudiant
    $query = "SELECT e.Nom, e.Prenom, e.Apogee, e.DateNaissance, e.Ville, e.Pays, 
                     f.Nomfiliere, n.Niveau
              FROM etudiant e
              LEFT JOIN filieres f ON e.idFiliere = f.idFiliere
              LEFT JOIN niveau n ON e.idNiveau = n.idNiveau
              WHERE e.Apogee = '$apogee'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom = $row['Nom'];
        $prenom = $row['Prenom'];
        $code_apogee = $row['Apogee'];
        $date_naissance = $row['DateNaissance'];
        $ville = $row['Ville'];
        $pays = $row['Pays'];
        $filiere = $row['Nomfiliere'] ?? "Non spécifiée";
        $niveau = $row['Niveau'] ?? "Non spécifié";

        // Initialiser le document PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Paramètres du PDF
        $pdf->SetMargins(20, 20, 20); // Marges
        $pdf->SetHeaderMargin(10);    // Marge d'en-tête
        $pdf->SetFooterMargin(10);    // Marge de pied de page
        $pdf->SetAutoPageBreak(TRUE, 20); // Coupure automatique des pages

        $pdf->AddPage();

        // Ajouter un en-tête esthétique
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->SetTextColor(0, 51, 153); // Bleu foncé
        $pdf->Cell(0, 15, 'Attestation de Scolarité', 0, 1, 'C');
        $pdf->Ln(10);

        // Contenu du PDF
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(0, 0, 0); // Noir

        $html = <<<EOD
        <style>
            .info { font-weight: bold; color: #003366; }
            .value { color: #000000; }
        </style>
        <h4 style="color: #003366;">Informations sur l'étudiant :</h4>
        <table cellspacing="5" cellpadding="5" border="0">
            <tr>
                <td class="info">Nom :</td>
                <td class="value">{$nom}</td>
            </tr>
            <tr>
                <td class="info">Prénom :</td>
                <td class="value">{$prenom}</td>
            </tr>
            <tr>
                <td class="info">Code Apogée :</td>
                <td class="value">{$code_apogee}</td>
            </tr>
            <tr>
                <td class="info">Date de Naissance :</td>
                <td class="value">{$date_naissance}</td>
            </tr>
            <tr>
                <td class="info">Ville :</td>
                <td class="value">{$ville}</td>
            </tr>
            <tr>
                <td class="info">Pays :</td>
                <td class="value">{$pays}</td>
            </tr>
            <tr>
                <td class="info">Filière :</td>
                <td class="value">{$filiere}</td>
            </tr>
            <tr>
                <td class="info">Niveau :</td>
                <td class="value">{$niveau}</td>
            </tr>
        </table>
        <br><br>
        <p>Cette attestation certifie que l'étudiant mentionné ci-dessus est inscrit dans notre établissement pour l'année en cours.</p>
        <br><br>
        <p><i>Fait à Valenciennes, le {date('d/m/Y')}.</i></p>
        EOD;

        // Écrire le HTML dans le PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Sortir le PDF (téléchargement direct)
        $pdf->Output("attestation_{$code_apogee}.pdf", 'D');
    } else {
        echo "<h2>Aucun étudiant trouvé avec le code Apogée : {$apogee}</h2>";
    }
}
?>
