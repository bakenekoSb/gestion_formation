<?php

require('./../fpdf/fpdf.php');

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['btn_facture'])){

    $nom=$_POST['nom'];
    $entreprise=$_POST['entreprise'];
    $adresse=$_POST['adresse'];

    $designation=$_POST['designation'];
    $jours=$_POST['jours'];
    $prix=$_POST['prix'];

    $indemnite=$_POST['indemnite'];
    $tva=$_POST['tva'];

    $totalFormation = $jours * $prix;
    $total = $totalFormation + $indemnite + $tva;

    $pdf=new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,'FACTURE',0,1,'C');

    $pdf->Ln(5);

    /* CLIENT */
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,8,"Client: $nom",0,1);
    $pdf->Cell(0,8,"Entreprise: $entreprise",0,1);
    $pdf->Cell(0,8,"Adresse: $adresse",0,1);

    $pdf->Ln(5);

    /* TABLE */
    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(80,10,'Designation',1);
    $pdf->Cell(30,10,'Jours',1);
    $pdf->Cell(40,10,'Prix',1);
    $pdf->Cell(40,10,'Total',1);

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

    $pdf->Output();
}