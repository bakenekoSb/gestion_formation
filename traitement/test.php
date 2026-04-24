<?php
require('./../fpdf/fpdf.php'); // Inclure FPDF

class PDF extends FPDF
{
    function Header()
    {
        // Logo ou titre
        $this->SetFont('Arial','B',20);
        $this->Cell(0,0,'FACTURE',0,1,'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Récupérer les données POST
$numero_proforma = $_POST['proforma'] ?? 'PRO-F2026-03';
$numero_bc = $_POST['bc'] ?? 'DREECI/IOE-03.03.N0250011';
$date_facture =time();
//$date_facture = $_POST['date_facture'] ?? '2026-03-18';
$client = $_POST['nom'] ?? 'ORANGE DIGITAL CENTER';
$service = $_POST['designation'] ?? 'Formation Intelligence artificielle appliquée aux métiers';
$quantite = (int)($_POST['jours'] ?? 5);
$montant_unitaire = (int)($_POST['prix'] ?? 160000);
$indemnite = (int)($_POST['indemnite'] ?? 5000);
$date_debut = $_POST['date_debut'] ?? '2026-03-02';
$date_fin = $_POST['date_fin'] ?? '2026-03-06';
$tva = (int)($_POST['tva'] ?? 20000);
// Calculs
$montant_service = $quantite * $montant_unitaire;
$montant_indemnite = $quantite * $indemnite;
$tva_total = ($montant_service + $montant_indemnite) * ($tva / 100);
$total = $montant_service + $montant_indemnite + $tva_total;

// Fonction formatage nombre
function formatNumber($nb) {
    return number_format($nb, 0, ',', ' ');
}

// Créer PDF
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(15,15,15);
$pdf->SetAutoPageBreak(true,15);

// ====================================
// EN-TÊTE SOCIÉTÉ
// ====================================
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,5,'Entreprise:',0,1,'L');
$pdf->Cell(0,-5,'GASY TECH',0,1,'C');
$pdf->Cell(0,6,'Antananarivo',0,1,'R');
$pdf->Cell(0,10,'Adresse:',0,1,'L');
$pdf->Cell(0,-10,'Anjanahary Antananarivo, Madagascar',0,1,'C');
$pdf->Cell(0,28,'NIF/STAT:',0,1,'L');
$pdf->Cell(0,-28,'6005717692/74908',0,1,'C');
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,45,'RCS:',0,1,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,-45,'112021 007713',0,1,'C');
$pdf->Cell(0,48,'Doit',0,1,'R');
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,-33,'Email:',0,1,'L');
$pdf->SetTextColor(200,0,200);
$pdf->Cell(0,33,'contact@gasy-tech.com',0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,-33,'ORANGE DIGITAL CENTER',0,1,'R');
$pdf->Cell(0,45,'Gare Soarano',0,1,'R');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'',0,0);
$pdf->Cell(60,0,'Date de formation achevee : ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,0,$date_debut.' au '.$date_fin,0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'',0,0);
$pdf->Cell(40,15,'N° Proforma GT : ',0,0,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,15,'PRO-F'.$date_fin,0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'',0,0);
$pdf->Cell(25,0,'N° de BC : ',0,0,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,0,'DREECI/IOE-03.03.N0250011',0,1);
$pdf->Ln(10);

// ====================================
// TABLEAU PRESTATIONS
// ====================================
$pdf->SetFont('Arial','B',11);
//$pdf->SetFillColor(0,124,186);
//$pdf->SetTextColor(255,255,255);
$pdf->Cell(100,8,'Designation',1,0,'C');
$pdf->Cell(25,8,'Quantite',1,0,'C');
$pdf->Cell(30,8,'Montant',1,0,'C');
$pdf->Cell(35,8,'Total TTC',1,1,'C');

// Ligne 1 - Service
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,8,$service,1,0,'L');
$pdf->Cell(25,8,$quantite,1,0,'C');
$pdf->Cell(30,8,formatNumber($montant_unitaire),1,0,'R');
$pdf->Cell(35,8,formatNumber($montant_service),1,1,'R');

// Ligne 2 - Indemnité
$pdf->Cell(100,8,'Indemnité de repas et transport',1,0,'L');
$pdf->Cell(25,8,$quantite,1,0,'C');
$pdf->Cell(30,8,formatNumber($indemnite),1,0,'R');
$pdf->Cell(35,8,formatNumber($montant_indemnite),1,1,'R');

// Ligne TVA
$pdf->Cell(100,8,'TVA 20%',1,0,'L');
$pdf->Cell(25,8,'',1,0,'C');
$pdf->Cell(30,8,formatNumber($montant_service + $montant_indemnite),1,0,'R');
$pdf->Cell(35,8,formatNumber($tva_total),1,1,'R');

// TOTAL
$pdf->SetFont('Arial','B',12);
$pdf->Cell(155,8,'TOTAL',1,0,'R');
$pdf->SetFont('Arial','B',14);
$pdf->Cell(35,8,formatNumber($total).' Ar',1,1,'C');
$pdf->Ln(5);

// ====================================
// MONTANT EN LETTRES
// ====================================
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,'Arrete a la somme de " Neuf cent quatre-vingt-dix mille ariary "',0,1);
$pdf->Ln(9);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,'Conditions de paiement',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Les modes de paiements acceptes sont le virement bancaire et Orange Money',0,1);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,'Details bancaire',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,15,' - BANQUE : BRED Madagasikara',0,1);
$pdf->Cell(0,0,' - RIB : 00008 00024 05003023618 71',0,1);
$pdf->Cell(0,15,' - NOM : GASY TECH',0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,0,'Numero Orange money: ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,0,'032 05 504 93',0,1);

// ====================================
// OUTPUT
// ====================================
$filename = 'facture_gasy_tech_' . date('Y-m-d_His') . '.pdf';
$pdf->Output();
?>