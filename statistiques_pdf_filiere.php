<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestionetudiant1");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si une filière a été sélectionnée
if (isset($_GET['idFiliere'])) {
    $filiereId = intval($_GET['idFiliere']);

    // Inclure la bibliothèque TCPDF
    require_once(__DIR__ . '/TCPDF/tcpdf.php');

    // Requêtes pour récupérer les statistiques
    $queryEtudiants = "SELECT COUNT(*) AS total_etudiants FROM etudiant WHERE idFiliere = $filiereId";
    $queryMatieres = "SELECT COUNT(*) AS total_matieres FROM matieres WHERE idFiliere = $filiereId";
    $queryEnseignants = "
        SELECT COUNT(DISTINCT idEnseignant) AS total_enseignants
        FROM matieres
        WHERE idFiliere = $filiereId";

    $totalEtudiants = ($conn->query($queryEtudiants)->fetch_assoc())['total_etudiants'];
    $totalMatieres = ($conn->query($queryMatieres)->fetch_assoc())['total_matieres'];
    $totalEnseignants = ($conn->query($queryEnseignants)->fetch_assoc())['total_enseignants'];

    // Initialiser TCPDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetMargins(20, 20, 20);
    $pdf->AddPage();

    // Ajouter un titre
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Statistiques par Filière', 0, 1, 'C');
    $pdf->Ln(10);

    // Contenu du PDF
    $pdf->SetFont('helvetica', '', 12);
    $html = <<<EOD
        <h3>Statistiques :</h3>
        <ul>
            <li><strong>Nombre d'Étudiants :</strong> $totalEtudiants</li>
            <li><strong>Nombre de Matières :</strong> $totalMatieres</li>
            <li><strong>Nombre d'Enseignants :</strong> $totalEnseignants</li>
        </ul>
EOD;

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output("statistiques_filiere_$filiereId.pdf", 'D');
}
?>
