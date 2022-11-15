<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

// On active la classe une fois pour toutes les pages suivantes
// Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.)
$pdf = new Pdf('P','mm','A4');

// Nouvelle page A4
$pdf->AddPage();
// Police
$pdf->SetFont('Arial','',11);
// Couleur par défaut : noir
$pdf->SetTextColor(0);
// Compteur de pages
$pdf->AliasNbPages();
// Sous-titre calés à gauche
$pdf->SetFont('Helvetica','B',11);
// couleur de fond de la cellule : gris clair
$pdf->setFillColor(230,230,230);
// Cellule avec les données du sous-titre sur 2 lignes, pas de bordure mais couleur de fond grise
$pdf->Cell(75,6,"test sous titre",1);    
// saut de ligne       
$pdf->Ln(10);

 // affichage à l'écran
$pdf->Output('test.pdf','I');