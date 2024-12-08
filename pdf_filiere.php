<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionetudiant1";

// Connexion sécurisée à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['idFiliere'])) {
    $idFiliere = intval($_GET['idFiliere']); // Sécurisation des données

    // Inclure la bibliothèque TCPDF
    require_once(__DIR__ . '/TCPDF/tcpdf.php');

    // Récupérer les informations des étudiants par filière
    $query = "
        SELECT e.Nom, e.Prenom, e.Apogee, e.DateNaissance, e.Ville, e.Pays, n.Niveau
        FROM etudiant e
        LEFT JOIN niveau n ON e.idNiveau = n.idNiveau
        WHERE e.idFiliere = $idFiliere
    ";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Initialiser le PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Paramètres du PDF
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->AddPage();

        // Titre du document
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Liste des étudiants par filière', 0, 1, 'C');
        $pdf->Ln(10);

        // Contenu de la table
        $pdf->SetFont('helvetica', '', 12);
        $html = '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Apogée</th>
                            <th>Date de Naissance</th>
                            <th>Ville</th>
                            <th>Pays</th>
                            <th>Niveau</th>
                        </tr>
                    </thead>
                    <tbody>';

        while ($row = $result->fetch_assoc()) {
            $html .= "<tr>
                        <td>{$row['Nom']}</td>
                        <td>{$row['Prenom']}</td>
                        <td>{$row['Apogee']}</td>
                        <td>{$row['DateNaissance']}</td>
                        <td>{$row['Ville']}</td>
                        <td>{$row['Pays']}</td>
                        <td>{$row['Niveau']}</td>
                      </tr>";
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');

        // Sortir le PDF
        $pdf->Output("liste_etudiants_filiere_$idFiliere.pdf", 'D');
    } else {
        echo "<h2>Aucun étudiant trouvé pour cette filière.</h2>";
    }
}
?>
