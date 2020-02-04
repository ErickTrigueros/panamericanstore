<?php


//call the FPDF library
require('fpdf/fpdf.php');


//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=199mm

//create pdf object
$pdf = new FPDF('P','mm','A4');
//String orientation (P or L) — portrait or landscape 
//String unit (pt,mm,cm and in) — measure unit
//Mixed format (A3, A4, A5, Letter and Legal) — format of pages






//add new page
$pdf->AddPage();
//$pdf->SetFillColor(123,255,234);

//set font to arial, bold, 16pt
$pdf->SetFont('Arial','B',16);

//Cell(width , height , text , border , end line , [align] )
$pdf->Cell(80,10,'Panamerican Store',0,0,'');


$pdf->SetFont('Arial','B',13);
$pdf->Cell(112,10,'FACTURA',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Direccion : Col. España , Santa Ana - ESA',0,0,'');


$pdf->SetFont('Arial','',10);
$pdf->Cell(112,5,'Pedido : #12345',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Telefono: +(503) 7953-7556',0,0,'');


$pdf->SetFont('Arial','',10);
$pdf->Cell(112,5,'Fecha : 24-01-2020',0,1,'C');


$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'E-mail : ejerez92@hotmail.com',0,1,'');
$pdf->Cell(80,5,'Sitio Web : www.panamericanstore.com',0,1,'');

//Line(x1,y1,x2,y2);

$pdf->Line(5,45,205,45);// doble linea
$pdf->Line(5,46,205,46);

$pdf->Ln(10); // line break


$pdf->SetFont('Arial','BI',12);
$pdf->Cell(20,10,'Cliente :',0,0,'');


$pdf->SetFont('Courier','BI',14);
$pdf->Cell(50,10,'Erick Trigueros',0,1,'');

//Imprimedo productos
$pdf->Cell(50,5,'',0,1,'');



$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(45,8,'CODIGO',1,0,'C',true);
$pdf->Cell(60,8,'PRODUCTO',1,0,'C',true);
$pdf->Cell(30,8,'COLOR',1,0,'C',true);   //190
$pdf->Cell(20,8,'CANT.',1,0,'C',true);
$pdf->Cell(20,8,'PRECIO',1,0,'C',true);
$pdf->Cell(20,8,'TOTAL',1,1,'C',true);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,8,'RGBJKL1-RGLD',1,0,'L');
$pdf->Cell(60,8,'Reloj 1',1,0,'L');
$pdf->Cell(30,8,'ROSE GOLD',1,0,'L');     //190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(20,8,'800',1,0,'C');
$pdf->Cell(20,8,'800',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,8,'RGBJKL2-WH',1,0,'L');
$pdf->Cell(60,8,'Reloj 2',1,0,'L');
$pdf->Cell(30,8,'WHYTE',1,0,'L');     //190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(20,8,'800',1,0,'C');
$pdf->Cell(20,8,'800',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,8,'RGBJKL3-BL',1,0,'L');
$pdf->Cell(60,8,'Reloj 3',1,0,'L');
$pdf->Cell(30,8,'BLUE',1,0,'L');     //190
$pdf->Cell(20,8,'1',1,0,'C');
$pdf->Cell(20,8,'800',1,0,'C');
$pdf->Cell(20,8,'800',1,1,'C');



$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,8,'',0,0,'L'); 
$pdf->Cell(60,8,'',0,0,'L'); 
$pdf->Cell(30,8,'',0,0,'L');   //190

$pdf->Cell(40,8,'SubTotal',1,0,'C',true);
$pdf->Cell(20,8,'600',1,1,'C');


$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,8,'',0,0,'L'); 
$pdf->Cell(60,8,'',0,0,'L'); 
$pdf->Cell(30,8,'',0,0,'L');    //190

$pdf->Cell(40,8,'Inpuesto',1,0,'C',true);
$pdf->Cell(20,8,'60',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,8,'',0,0,'L'); 
$pdf->Cell(60,8,'',0,0,'L'); 
$pdf->Cell(30,8,'',0,0,'L');    //190

$pdf->Cell(40,8,'Descuento',1,0,'C',true);
$pdf->Cell(20,8,'30',1,1,'C');

$pdf->SetFont('Arial','B',14);
$pdf->Cell(45,8,'',0,0,'L'); 
$pdf->Cell(60,8,'',0,0,'L'); 
$pdf->Cell(30,8,'',0,0,'L');    //190

$pdf->Cell(40,8,'Suma Total',1,0,'C',true);
$pdf->Cell(20,8,'$'.'6600',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,8,'',0,0,'L'); 
$pdf->Cell(60,8,'',0,0,'L'); 
$pdf->Cell(30,8,'',0,0,'L');    //190

$pdf->Cell(40,8,'Pago',1,0,'C',true);
$pdf->Cell(20,8,'7000',1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,8,'',0,0,'L'); 
$pdf->Cell(60,8,'',0,0,'L'); 
$pdf->Cell(30,8,'',0,0,'L');    //190

$pdf->Cell(40,8,'Diferencia',1,0,'C',true);
$pdf->Cell(20,8,'400',1,1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,8,'',0,0,'L'); 
$pdf->Cell(60,8,'',0,0,'L'); 
$pdf->Cell(30,8,'',0,0,'L');   //190

$pdf->Cell(40,8,'Tipo de pago',1,0,'C',true);
$pdf->Cell(20,8,'Cash',1,1,'C');


$pdf->Cell(50,10,'',0,1,'');


$pdf->SetFont('Arial','B',10);
$pdf->Cell(32,10,'Nota importante :',0,0,'',true);


$pdf->SetFont('Arial','',8);
$pdf->Cell(148,10,'Ningun articulo sera reemplazado o devuelto si no se cuenta con esta factura. Tu puedes hacer una devolucion, limite dos dias despues de tu compra.',0,0,'');

//output the result
$pdf->Output();






?>