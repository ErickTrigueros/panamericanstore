<?php
//call the FPDF library
require('../fpdf/fpdf.php');
include_once'connectdb.php';


$id=$_GET['id'];
$select=$pdo->prepare("select * from tbl_invoice where invoice_id=$id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);



//create pdf object
$pdf = new FPDF('P','mm',array(80,200));

//add new page
$pdf->AddPage();

//set font to arial, bold, 16pt
$pdf->SetFont('Arial','B',16);
//Cell(width , height , text , border , end line , [align] )
$pdf->Cell(60,8,'Panamerican Store',1,1,'C');

$pdf->SetFont('Arial','B',8);

$pdf->Cell(60,5,'Direccion : Col. España , Santa Ana - ESA',0,1,'C');
$pdf->Cell(60,5,'Telefono: +(503) 7953-7556',0,1,'C');
$pdf->Cell(60,5,'E-mail : ejerez92@hotmail.com',0,1,'C');
$pdf->Cell(60,5,'Sitio Web : www.panamericanstore.com',0,1,'C');


//Line(x1,y1,x2,y2);

$pdf->Line(7,38,72,38);


$pdf->Ln(1); // line 


$pdf->SetFont('Arial','BI',8);
$pdf->Cell(20,4,'Cliente :',0,0,'');


$pdf->SetFont('Courier','BI',8);
$pdf->Cell(40,4,$row->customer_name,0,1,'');


$pdf->SetFont('Arial','BI',8);
$pdf->Cell(20,4,'Factura N°:',0,0,'');


$pdf->SetFont('Courier','BI',8);
$pdf->Cell(40,4,$row->invoice_id,0,1,'');



$pdf->SetFont('Arial','BI',8);
$pdf->Cell(20,4,'Fecha :',0,0,'');


$pdf->SetFont('Courier','BI',8);
$pdf->Cell(40,4,$row->order_date,0,1,'');



/////////


$pdf->SetX(7);//margen
$pdf->SetFont('Courier','B',7);

$pdf->Cell(11,5,'CODIGO',1,0,'C');
$pdf->Cell(20,5,'PRODUCTO',1,0,'C');   //70
$pdf->Cell(11,5,'COLOR',1,0,'C');
$pdf->Cell(8,5,'CANT.',1,0,'C');
$pdf->Cell(8,5,'PRC.',1,0,'C');
$pdf->Cell(12,5,'TOTAL',1,1,'C');


$select=$pdo->prepare("select * from tbl_invoice_details where invoice_id=$id");
$select->execute();

while($item=$select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetX(7);
  $pdf->SetFont('Helvetica','B',5);
$pdf->Cell(11,5,$item->product_code,1,0,'L'); 
$pdf->Cell(20,5,$item->product_name,1,0,'L');  
$pdf->Cell(11,5,$item->product_color,1,0,'L');    
$pdf->Cell(8,5,$item->qty,1,0,'C');
$pdf->Cell(8, 5,$item->price,1,0,'C');
$pdf->Cell(12,5,$item->price*$item->qty,1,1,'C');  
    
}




/////////




$pdf->SetX(7);
$pdf->SetFont('courier','B',6);
$pdf->Cell(43,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(15,5,'SUBTOTAL',1,0,'C');
$pdf->Cell(12,5,$row->subtotal,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B',6);
$pdf->Cell(43,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(15,5,'IMP.(0%)',1,0,'C');
$pdf->Cell(12,5,$row->tax,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B',6);
$pdf->Cell(43,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(15,5,'DESCUENTO',1,0,'C');
$pdf->Cell(12,5,$row->discount,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->Cell(43,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(15,5,'TOTAL',1,0,'C');
$pdf->Cell(12,5,$row->total,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B',6);
$pdf->Cell(43,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(15,5,'PAGO',1,0,'C');
$pdf->Cell(12,5,$row->paid,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B',6);
$pdf->Cell(43,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(15,5,'DIF.',1,0,'C');
$pdf->Cell(12,5,$row->due,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B',6);
$pdf->Cell(43,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(15,5,'TIPO PAGO',1,0,'C');
$pdf->Cell(12,5,$row->payment_type,1,1,'C');



$pdf->Cell(20,5,'',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Courier','B',7);
$pdf->Cell(25,5,'Nota importante :',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','',4);
$pdf->Cell(75,5,'Ningun articulo sera cambiado o devuelto si no se presenta la factura. ',0,2,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','',4);
$pdf->Cell(75,5,'Puedes reembolsar dentro de dos dias despues de la compra. ',0,1,'');




$pdf->Output();
?>