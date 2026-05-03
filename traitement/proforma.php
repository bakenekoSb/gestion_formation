<?php
require('./../fpdf/fpdf.php');

class PDF extends FPDF {
    /*function Header() {
        $this->Ln(70);
        $this->Image('./../img/Logo.png',85,70,30);
        $this->SetFont('Arial','I',10);
        $this->SetTextColor(128,128,128);
        $this->Cell(0,5,'"Ny Fahaizana no ampinga enti-miady"',0,1,'C');
        $this->Ln(15);
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(240,100,10);
        $this->SetDrawColor(240,100,10);
        $this->Cell(0,0,' ',0,1,'C');
        $this->MultiCell(0,8,"FACTURE PROFORMA
                         ",1,'C');
        $this->Ln(1);
    }*/

    // Largeurs des colonnes
    var $widths;

    // Définir les largeurs
    function SetWidths($w) {
        $this->widths = $w;
    }

    // Fonction principale pour afficher une ligne
    function Row($data) {
        $nb = 0;

        // Calcul du nombre de lignes max
        for($i=0; $i<count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 6 * $nb;//5=hauteur de texte

        // Saut de page si nécessaire
        $this->CheckPageBreak($h);

        // Dessin des cellules
        for($i=0; $i<count($data); $i++) {
            $w = $this->widths[$i];
            $x = $this->GetX();
            $y = $this->GetY();

            if($data[$i]!= ""){
                // Bordure
                $this->Rect($x, $y, $w, $h);
            }

            // Texte
            $this->MultiCell($w, 5, $data[$i], 0,'C');

            // Repositionnement
            $this->SetXY($x + $w, $y);
        }

        // Aller à la ligne suivante
        $this->Ln($h);
    }

    // Vérifier saut de page
    function CheckPageBreak($h) {
        if($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    // Calcul nombre de lignes d'un texte
    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];

        if($w == 0)
            $w = $this->w - $this->rMargin - $this->x;

        $wmax = ($w - 2*$this->cMargin) * 1000 / $this->FontSize;

        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);

        if($nb > 0 && $s[$nb-1] == "\n")
            $nb--;

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;

        while($i < $nb) {
            $c = $s[$i];

            if($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }

            if($c == ' ')
                $sep = $i;

            $l += $cw[$c];

            if($l > $wmax) {
                if($sep == -1) {
                    if($i == $j)
                        $i++;
                } else {
                    $i = $sep + 1;
                }

                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }

        return $nl;
    }
}

$pdf = new PDF();
$pdf->AddPage();
// =====================
// EN TETE
// =====================
$pdf->Ln(70);
$pdf->Image('./../img/Logo.png',85,70,30);
$pdf->SetFont('Arial','I',10);
$pdf->SetTextColor(128,128,128);
$pdf->Cell(0,5,'"Ny Fahaizana no ampinga enti-miady"',0,1,'C');
$pdf->Ln(15);
$pdf->SetFont('Arial','B',20);
$pdf->SetTextColor(240,100,10);
$pdf->SetDrawColor(240,100,10);
$pdf->Cell(0,0,' ',0,1,'C');
$pdf->MultiCell(0,8,"FACTURE PROFORMA
                ",1,'C');
$pdf->Ln(1);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,'Numero : PRO-F2026-03',0,1,'C');
$pdf->Cell(0,5,'Date : 05/02/2026',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','B',19);
$pdf->SetTextColor(240,100,10);
$pdf->Cell(0,0,'Formation Intelligence artificielle appliquee aux metiers',0,1,'C');
$pdf->Ln(20);

// =====================
// BLOC ENTREPRISE
// =====================
$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->Rect($x-3,$y,95,65);
$pdf->Rect($x+97,$y,95,65);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,10,'Gasy Tech',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,10,'Destinataire :',0,1);
$pdf->Cell(17,0,'Adresse : ',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(83,0,'Anjanahary, Antananarivo',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(11,0,'Nom : ',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,0,'Orange Digitale Center',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(13,10,'Email : ',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(87,10,'contact@gasy-tech.com',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(17,10,'Adresse : ',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,10,'Gare Soarano',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,0,'Telephone : ',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,0,'034 68 994 76',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(9,10,'NIF : ',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,10,'6005717692',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(12,0,'STAT : ',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,0,'74908 11 2021 0 07713',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,10,'RCS : ',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,10,'2024 A 01833',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(17,0,'Site web : ',0,0);
$pdf->SetFont('Arial','U',10);
$pdf->SetTextColor(0,100,255);
$pdf->Cell(0,0,'www.gasy-tech.com',0,1);
$pdf->Ln(75);

// =====================
// TITRE TABLEAU
// =====================
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,6,'DETAILS DE LA FORMATION',0,1);
$pdf->Ln(2);

// =====================
// TABLEAU
// =====================
$pdf->SetWidths([40, 60, 20, 30, 30]);

$pdf->SetFont('Arial','B',11);
// En-tête
$pdf->Row(["Ref.", "Description", "Duree", "Prix (Ar)", "Total (Ar)"]);

$pdf->SetFont('Arial','',10);
//données
$pdf->Row(["IA", "Formation: l'IA appliquee aux metiers", "5 jours", "160 000", "800 000"]);
$pdf->Row(["REPAS/TRANSPORT", "Indemnite de repas et transport", "5 jours", "5 000", "25 000"]);
/*
$pdf->SetFont('Arial','B',9);

$w = [20, 70, 20, 30, 30];

$pdf->Cell($w[0],8,'Ref',1);
$pdf->Cell($w[1],8,'Description',1);
$pdf->Cell($w[2],8,'Duree',1);
$pdf->Cell($w[3],8,'Prix (Ar)',1);
$pdf->Cell($w[4],8,'Total (Ar)',1);
$pdf->Ln();

// =====================
// LIGNE 1 (MultiCell PROPRE)
// =====================
$pdf->SetFont('Arial','',9);

$y = $pdf->GetY();

$pdf->MultiCell($w[0],8,'IA',1);
$x = $pdf->GetX();
$pdf->SetXY(10 + $w[0], $y);

$pdf->MultiCell($w[1],8,"Formation : l'IA appliquee aux metiers",1);
$pdf->SetXY(10 + $w[0] + $w[1], $y);

$pdf->MultiCell($w[2],8,'5 jours',1);
$pdf->SetXY(10 + $w[0] + $w[1] + $w[2], $y);

$pdf->MultiCell($w[3],8,'160 000',1);
$pdf->SetXY(10 + $w[0] + $w[1] + $w[2] + $w[3], $y);

$pdf->MultiCell($w[4],8,'800 000',1);

// =====================
// LIGNE 2
// =====================
$y = $pdf->GetY();

$pdf->MultiCell($w[0],8,'REPAS',1);
$pdf->SetXY(10 + $w[0], $y);

$pdf->MultiCell($w[1],8,"Indemnite de repas et transport",1);
$pdf->SetXY(10 + $w[0] + $w[1], $y);

$pdf->MultiCell($w[2],8,'5 jours',1);
$pdf->SetXY(10 + $w[0] + $w[1] + $w[2], $y);

$pdf->MultiCell($w[3],8,'5 000',1);
$pdf->SetXY(10 + $w[0] + $w[1] + $w[2] + $w[3], $y);

$pdf->MultiCell($w[4],8,'25 000',1);

$pdf->Ln(5);
*/
// =====================
// TOTAL
// =====================
$pdf->Ln(15);
$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,0,'TOTAL GENERAL',0,1);

$pdf->Cell(0,5,'Montant total HT :',0,0);
$pdf->Cell(0,5,'825 000 Ar',0,1);
/*
$pdf->Cell(120,8,'',0);
$pdf->Cell(40,8,'TVA (20%) :',0);
$pdf->Cell(30,8,'165 000 Ar',0,1);

$pdf->Cell(120,8,'',0);
$pdf->Cell(40,8,'Montant total TTC :',0);
$pdf->Cell(30,8,'990 000 Ar',0,1);

$pdf->Ln(5);

// =====================
// CONDITIONS
// =====================
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,6,'CONDITIONS',0,1);

$pdf->SetFont('Arial','',8);

$pdf->MultiCell(0,4,
"1. Cette facture proforma ne constitue pas une facture definitive.

2. Si le nombre de participants depasse 25 personnes, un supplement sera facture.

3. 100% du montant doit etre regle sous 60 jours.

4. Penalite de 40 000 Ar par jour de retard.

5. Validation par email obligatoire avant la formation.

6. Modes de paiement :
- Virement bancaire (BRED Madagasikara)
- Orange Money

7. Annulation : paiement obligatoire meme en cas de non-participation.

8. Formation assuree a l'Orange Digital Center."
);

$pdf->Ln(10);

// =====================
// SIGNATURE
// =====================
$pdf->Cell(0,5,'Signature',0,1,'R');
*/
$pdf->Output();
?>