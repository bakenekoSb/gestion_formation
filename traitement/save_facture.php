<?php

require('./../fpdf/fpdf.php');

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['btn_facture'])){

    //données du formulaire
    $nom=$_POST['nom'];
    $entreprise=$_POST['entreprise'];
    $adresse=$_POST['adresse'];
    $nif = $_POST['nif'];
    $rcs = $_POST['rcs'];
    $email = $_POST['email'];
    $proforma = $_POST['proforma'];
    $bc = $_POST['bc'];
    $designation=$_POST['designation'];

    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    $jours=(int)$_POST['jours'];
    $prix=(float)$_POST['prix'];
    $indemnite=(float)$_POST['indemnite'];
    $tva=(float)$_POST['tva'];

    $totalFormation = $jours * $prix;
    $total = $totalFormation + $indemnite + $tva;

    //creer un pdf
    $pdf=new FPDF();
    $pdf->AddPage();

    /*HEADER*/
    //$pdf->Image('logo.png',10,10,30); //ajouter une image (logo) : chemin, position x, position y, largeur/taille (hauteur auto)
    $pdf->SetFont('Arial','B',16); //definir police; '': normal, 'B': gras, 'I' : italique ,'U' : souligné
    /*$pdf->Cell(largeur, hauteur, texte, bordure, saut_ligne, alignement); pour ecrire un texte dans le 
    $pdf->MultiCell(0,10,'Texte très long...'); pour texte long qui peut occuper plusieurs lignes*/
    $pdf->Cell(0,10,'FACTURE',0,1,'C'); //0 = toute la largeur, 1 = retour à la ligne, C = centré

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,6,'Adresse: '.$adresse,0,1);
    $pdf->Cell(0,6,'NIF: '.$nif,0,1);
    $pdf->Cell(0,6,'RCS: '.$rcs,0,1);
    $pdf->Cell(0,6,'Email: '.$email,0,1);

    $pdf->Ln(5); //saut de ligne

    /* CLIENT */
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(95,10,'Le Client',1,0);
    $pdf->Cell(95,10,'Le Fournisseur',1,1);

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(95,8,$nom,1,0);
    $pdf->Cell(95,8,'GASY TECH',1,1);
    /*$pdf->Cell(95,8,"Adresse: $adresse",1,1);
    $pdf->Cell(95,8,"NIF/STAT: $nif",0,1);
    $pdf->Cell(95,8,"RCS: $rcs",0,1);
    $pdf->Cell(0,8,"Email: $email",0,1);*/
    $pdf->Cell(95,8,"Proforma: $proforma",1,1);
    $pdf->Cell(95,8,"BC: $bc",1,1);

    $pdf->Ln(5);

    /* TABLE */
    $pdf->SetFont('Arial','B',12);
    //creer tableau ; 1 = bordure visible
    $pdf->Cell(80,10,'Designation',1);
    $pdf->Cell(30,10,'Jours',1);
    $pdf->Cell(40,10,'Prix',1);
    $pdf->Cell(40,10,'Total',1);

    /*Couleur
    texte: $pdf->SetTextColor(255,0,0); // rouge
    fond: $pdf->SetFillColor(200,220,255); // bleu clair
    bordure: $pdf->SetDrawColor(0,0,0);
    */
    $pdf->Ln();

    $pdf->SetFont('Arial','',12);

    $pdf->Cell(80,10,$designation,1);
    $pdf->Cell(30,10,$jours,1);
    $pdf->Cell(40,10,$prix,1);
    $pdf->Cell(40,10,$totalFormation,1);

    $pdf->Ln();

    /* Indemnité */
    $pdf->Cell(150,10,'Indemnite',1);
    $pdf->Cell(40,10,$indemnite,1);

    $pdf->Ln();

    /* TVA */
    $pdf->Cell(150,10,'TVA',1);
    $pdf->Cell(40,10,$tva,1);

    $pdf->Ln();

    /* TOTAL */
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(150,10,'TOTAL',1);
    $pdf->Cell(40,10,$total,1);

    /*generer/afficher le pdf
    $pdf->Output('D','facture.pdf'); // télécharger
    $pdf->Output('F','facture.pdf'); // sauvegarder
    */
    $pdf->Output();
}