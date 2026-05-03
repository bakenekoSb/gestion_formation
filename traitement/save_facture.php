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
$numero_bc = $_POST['bc'];
$date_facture = date('d/m/Y');
$date1 = date('Y-m');
$client = $_POST['nom'];
$client = $_POST['nom'];
$adresse = $_POST['adresse'];
$service = $_POST['designation'] ?? 'Formation Intelligence artificielle appliquée aux métiers';
$montant_unitaire = (double)($_POST['prix']);
$indemnite = (double)($_POST['indemnite']);
$date_debut = $_POST['date_debut'];
$date_fin = $_POST['date_fin'];
$tva = (int)($_POST['tva']);

// Calculs
if($date_debut && $date_fin){
    $d1 = new DateTime($date_debut);
    $d2 = new DateTime($date_fin);
    $interval = $d1->diff($d2);
    $quantite = $interval->days + 1;//pour inclure les 2 dates
}else{
    $quantite = 0;
}
$montant_service = $quantite * $montant_unitaire;
$montant_indemnite = $quantite * $indemnite;
$tva_total = ($montant_service + $montant_indemnite) * ($tva / 100);
$total = $montant_service + $montant_indemnite + $tva_total;

// Fonction formatage nombre
function formatNumber($nb) {
    return number_format($nb, 2, ',', ' ');
}

/*
    $pdf->Image('logo.png',10,10,30); //ajouter une image (logo) : chemin, position x, position y, largeur/taille (hauteur auto)
    $pdf->Cell(largeur, hauteur, texte, bordure, saut_ligne, alignement); pour ecrire un texte dans le 
    $pdf->MultiCell(0,10,'Texte très long...'); pour texte long qui peut occuper plusieurs lignes
    $pdf->Ln(5); //saut de ligne

    Couleur
    texte: $pdf->SetTextColor(255,0,0); // rouge
    fond: $pdf->SetFillColor(200,220,255); // bleu clair
    bordure: $pdf->SetDrawColor(0,0,0);
    
    Generer/afficher le pdf
    $pdf->Output('D','facture.pdf'); // télécharger
    $pdf->Output('F','facture.pdf'); // sauvegarder
    $pdf->Output();//s'ouvre dans le navigateur selon la configuration

*/

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
$pdf->Cell(0,5,'Entreprise:',0,1);
$pdf->Cell(0,-5,'GASY TECH',0,1,'C');
$pdf->Cell(0,6,'Antananarivo le '.$date_facture,0,1,'R');
$pdf->Cell(0,10,'Adresse:',0,1);
$pdf->Cell(0,-10,'Anjanahary Antananarivo, Madagascar',0,1,'C');
$pdf->Cell(0,28,'NIF/STAT:',0,1);
$pdf->Cell(0,-28,'6005717692/74908',0,1,'C');
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,45,'RCS:',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,-45,'112021 007713',0,1,'C');
$pdf->Cell(0,48,'Doit',0,1,'R');
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,-33,'Email:',0,1,);
$pdf->SetTextColor(200,0,200);
$pdf->Cell(0,33,'contact@gasy-tech.com',0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,-33,$client,0,1,'R');
$pdf->Cell(0,45,$adresse,0,1,'R');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(39,0,'',0,0);
$pdf->Cell(60,0,'Date de formation achevee : ',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,0,$date_debut.' au '.$date_fin,0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,0,'',0,0);
$pdf->Cell(40,15,'Num Proforma GT : ',0,0,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,15,'PRO-F'.$date1,0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(41,0,'',0,0);
$pdf->Cell(25,0,'Num de BC : ',0,0,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,0,$numero_bc,0,1);
$pdf->Ln(10);

// ====================================
// TABLEAU PRESTATIONS
// ====================================
//Largeurs des colonnes
$w = [85, 35, 35, 35];
$designation = $service."\n\nIndeminite de repas et transport lkjhg-iolpsdgdfhfjyj\n\nTVA";
$qtt = $quantite."\n\n".$quantite."\n\n".$tva."%";
$prix = formatNumber($montant_unitaire)."\n\n".formatNumber($indemnite)."\n\n".$tva_total;
$ttc = formatNumber($montant_service)."\n\n".formatNumber($montant_indemnite)."\n\n".$tva_total;

// =====================
// 🔹 CALCUL HAUTEUR
// =====================
$lineHeight = 6;

$nb = max(
    substr_count($designation, "\n"),
    substr_count($qtt, "\n"),
    substr_count($prix, "\n"),
    substr_count($ttc, "\n")
) + 1;

$h = $lineHeight * $nb;

// Position de départ
$x = $pdf->GetX();
$y = $pdf->GetY();

// =====================
// 🔹 En-tête
// =====================
$pdf->Cell(85,10,'Designation',1,0,'C');
$pdf->Cell(35,10,'Quantite(Nb Jour)',1,0,'C');
$pdf->Cell(35,10,'Montant Ariary',1,0,'C');
$pdf->Cell(35,10,'Montant Total TTC',1,1,'C');

// =====================
// 🔹 COLONNE 1
// =====================
/*
    Rect(x,y,w,h) → bordure  ;  et y (coordonnées du coin supérieur gauche), width (largeur) et height (hauteur)
    SetXY() → éviter le décalage
*/
$pdf->Rect($x, $y, $w[0], $h+60);
$pdf->MultiCell($w[0], $lineHeight, $designation, 0, 'C');

// =====================
// 🔹 COLONNpdf->E 2
// =====================
$x += $w[0];
$y = $y+10;
$pdf->SetXY($x, $y);
$pdf->Rect($x, $y, $w[1], $h+50);
$pdf->MultiCell($w[1], $lineHeight, $qtt, 0, 'C');

// =====================
// 🔹 COLONNE 3
// =====================
$x += $w[1];
$pdf->SetXY($x, $y);
$pdf->Rect($x, $y, $w[2], $h+50);
$pdf->MultiCell($w[2], $lineHeight, $prix, 0, 'R');

// =====================
// 🔹 COLONNE 4
// =====================
$x += $w[2];
$pdf->SetXY($x, $y);
$pdf->Rect($x, $y, $w[3], $h+50);
$pdf->MultiCell($w[3], $lineHeight, $ttc, 0, 'R');

// =====================
// 🔹 LIGNE TOTAL
// =====================
$pdf->Ln($h+20);

$pdf->SetFont('Arial','B',11);

// cellule vide (fusion visuelle)
$pdf->Cell($w[0] + $w[1], 8, "", 0);

// Total
$pdf->Cell($w[2], 8, "Total", 1, 0, 'C');
$pdf->Cell($w[3], 8, number_format($total, 2, ',', ' '), 1, 0, 'R');
$pdf->Ln(10);

// ====================================
// MONTANT EN LETTRES
// ====================================
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,'Arrete a la somme de " Neuf cent quatre-vingt-dix mille ariary "',0,1);
$pdf->Ln(9);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,'Conditions de paiement',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Les modes de paiements accptes sont le virement bancaire et Orange Money',0,1);
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