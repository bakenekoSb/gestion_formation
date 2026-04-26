<?php
require('./../fpdf/fpdf.php'); // Inclure FPDF

class PDF extends FPDF
{
    function Header(){
    $this->Ln(5);
    }
    // Largeurs des colonnes
    var $widths;

    // Définir les largeurs
    function SetWidths($w) {
        $this->widths = $w;
    }

    // Fonction principale pour afficher une ligne
    function Row($data,$test) {
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

            if($data[$i]!= "" && $test == true){
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

//conversion nombre en lettre
function nombreEnLettres($nombre){

    if($nombre == 0){
        return "zéro";
    }

    $unites = [
        0=>"zéro",1=>"un",2=>"deux",3=>"trois",4=>"quatre",
        5=>"cinq",6=>"six",7=>"sept",8=>"huit",9=>"neuf",
        10=>"dix",11=>"onze",12=>"douze",13=>"treize",
        14=>"quatorze",15=>"quinze",16=>"seize"
    ];

    $dizaines = [
        20=>"vingt",30=>"trente",40=>"quarante",
        50=>"cinquante",60=>"soixante"
    ];

    // --- < 17 ---
    if($nombre < 17){
        return $unites[$nombre];
    }

    // --- < 20 ---
    if($nombre < 20){
        return "dix-".$unites[$nombre-10];
    }

    // --- < 70 ---
    if($nombre < 70){
        $dizaine = floor($nombre/10)*10;
        $reste = $nombre % 10;

        if($reste == 1){
            return $dizaines[$dizaine]." et un";
        } elseif($reste > 0){
            return $dizaines[$dizaine]."-".$unites[$reste];
        } else {
            return $dizaines[$dizaine];
        }
    }

    // --- < 80 ---
    if($nombre < 80){
        return "soixante-".nombreEnLettres($nombre-60);
    }

    // --- < 100 ---
    if($nombre < 100){
        return "quatre-vingt".($nombre==80 ? "s" : "-".nombreEnLettres($nombre-80));
    }

    // --- < 1000 ---
    if($nombre < 1000){
        $centaine = floor($nombre/100);
        $reste = $nombre % 100;

        $texte = ($centaine == 1) ? "cent" : $unites[$centaine]." cent";

        if($reste == 0 && $centaine > 1){
            $texte .= "s"; // deux cents
        }

        if($reste > 0){
            $texte .= " ".nombreEnLettres($reste);
        }

        return $texte;
    }

    // --- < 1 000 000 ---
    if($nombre < 1000000){
        $mille = floor($nombre/1000);
        $reste = $nombre % 1000;

        $texte = ($mille == 1) ? "mille" : nombreEnLettres($mille)." mille";

        if($reste > 0){
            $texte .= " ".nombreEnLettres($reste);
        }

        return $texte;
    }

    // --- < 1 000 000 000 ---
    if($nombre < 1000000000){
        $million = floor($nombre/1000000);
        $reste = $nombre % 1000000;

        $texte = ($million == 1) ? "un million" : nombreEnLettres($million)." millions";

        if($reste > 0){
            $texte .= " ".nombreEnLettres($reste);
        }

        return $texte;
    }

    // --- milliards ---
    if($nombre < 1000000000000){
        $milliard = floor($nombre/1000000000);
        $reste = $nombre % 1000000000;

        $texte = ($milliard == 1) ? "un milliard" : nombreEnLettres($milliard)." milliards";

        if($reste > 0){
            $texte .= " ".nombreEnLettres($reste);
        }

        return $texte;
    }

    return "nombre trop grand";
}

// Récupérer les données POST
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
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,5,'Entreprise:',0,1);
$pdf->Cell(0,-5,'GASY TECH',0,1,'C');
$pdf->Cell(0,6,'Antananarivo le '.$date_facture,0,0,'R');
$pdf->SetFont('Arial','U',11);
$pdf->Cell(0,6,$date_facture,0,1,'R');
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,10,'Adresse:',0,1);
$pdf->Cell(0,-10,'Anjanahary Antananarivo, Madagascar',0,1,'C');
$pdf->Cell(0,28,'NIF/STAT:',0,1);
$pdf->Cell(0,-28,'6005717692/74908',0,1,'C');
$pdf->SetFont('Arial','U',11);
$pdf->Cell(0,45,'RCS:',0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,-45,'112021 007713',0,1,'C');
$pdf->Cell(0,48,'Doit',0,1,'R');
$pdf->SetFont('Arial','U',11);
$pdf->Cell(0,-33,'Email:',0,1,);
$pdf->SetTextColor(200,0,200);
$pdf->Cell(0,33,'contact@gasy-tech.com',0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,-33,$client,0,1,'R');
$pdf->Cell(0,45,$adresse,0,1,'R');

//prendre position de y
$y = $pdf->GetY();
//Rect(x,y,w,h) → bordure rectangle ;  et y (coordonnées du coin supérieur gauche), width (largeur) et height (hauteur)
$pdf->Rect(50,$y-18, 120, 28);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(39,0,'',0,0);
$pdf->Cell(55,-25,'Date de formation achevee : ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,-25,$date_debut.' au '.$date_fin,0,1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,0,'',0,0);
$pdf->Cell(40,40,'Num Proforma GT : ',0,0,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,40,'PRO-F'.$date1,0,1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(41,0,'',0,0);
$pdf->Cell(25,-25,'Num de BC : ',0,0,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,-25,'DREECI/IOE-03.03.N0250011',0,1);
$pdf->Ln(25);

// ====================================
// TABLEAU PRESTATIONS
// ====================================
// Définir les largeurs
$pdf->SetWidths([100, 25, 30, 35]);
$test = true;
$pdf->SetFont('Arial','B',11);
// En-tête
$pdf->Row(["Designation", "Quantite (Nb de jours)", "Montant en ariary", "Montant Total (TTC)"],$test);

$pdf->SetFont('Arial','',11);
//Données
$pdf->Row([$service, $quantite, formatNumber($montant_unitaire), formatNumber($montant_service)],$test);
$pdf->Row(['Indeminite de repas et transport', $quantite, formatNumber($indemnite), formatNumber($montant_indemnite)],$test);
$pdf->Row(['TVA', $tva.'%', formatNumber($tva_total), formatNumber($tva_total)],$test);
$pdf->Row(['','','Total', formatNumber($total)],$test);
$pdf->Ln(5);
// ====================================
// MONTANT EN 
//ucfirst(); pour faire en majuscule la première lettre
// ====================================
$lettre = nombreEnLettres((int)$total);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(43,8,'Arrete a la somme de ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,8,'" '.ucfirst($lettre).' ariary "',0);
$pdf->Ln(9);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,'Conditions de paiement',0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,10,'Les modes de paiements accptes sont le virement bancaire et Orange Money',0,1);
$pdf->Ln(10);

//prendre position de y
$y = $pdf->GetY();

$pdf->Rect(10,$y-5, 195, 45);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,'Details bancaire',0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,15,' - BANQUE : BRED Madagasikara',0,1);
$pdf->Cell(0,0,' - RIB : 00008 00024 05003023618 71',0,1);
$pdf->Cell(0,15,' - NOM : GASY TECH',0,1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50,0,'Numero Orange money: ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,0,'032 05 504 93',0,1);
$pdf->Ln(20);

// ====================================
// FOOTER
// ====================================
$x = $pdf->GetX();
$pdf->SetWidths([$x,55,40, 75]);
$test = false;
$pdf->SetFont('Arial','U',11);
$pdf->Row(['','Le Client','','Le Fournisseur'],$test);
$pdf->Ln(15);
//$pdf->Row(['','','','']);
$pdf->SetFont('Arial','',11);
$pdf->Row(['','','','RAMAHEFARITOLOTRA Rafaly Antoni CEO et Gerant de Gasy Tech'],$test);

// ====================================
// OUTPUT
// ====================================
$filename = 'facture_gasy_tech_' . date('Y-m-d_His') . '.pdf';
if(isset($_POST['btn_apercu'])){
    $pdf->Output();//Affiche
}else if(isset($_POST['btn_telecharge'])){
    $pdf->Output('D',$filename); // télécharger
}
?>