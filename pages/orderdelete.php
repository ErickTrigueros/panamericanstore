<?php

include_once'connectdb.php';

$id=$_POST['pidd'];// obtengo el piid de ajax (id del pedido)

// DELETE T1, T2 FROM T1 INNER JOIN T2 ON T1.key = T2.key  WHERE condition T1.key=id;
 //Actualizando stock
 $select=$pdo->prepare("SELECT tbl_product.idp, tbl_product.pstock, tbl_invoice_details.qty FROM tbl_product JOIN tbl_invoice_details ON tbl_product.idp =tbl_invoice_details.product_id WHERE tbl_invoice_details.invoice_id = $id ");
 $select->execute();//ejecuto la query
 while($row=$select->fetch(PDO::FETCH_OBJ)){//Recorro los registros los valores, el ip de producto y el stock de acuerdo al id del pedido pidd
  $db_stock=$row->pstock;
  $idp=$row->idp;
  $qty=$row->qty;

  $update=$pdo->prepare("UPDATE tbl_product SET pstock ='".($db_stock + $qty)."' where idp=$idp");
       
  $update->execute();// ejecuto query para actualizar stock

   }
//Fin Actualizando stock
 

$sql="DELETE tbl_invoice , tbl_invoice_details FROM tbl_invoice INNER JOIN tbl_invoice_details ON tbl_invoice.invoice_id = tbl_invoice_details.invoice_id where tbl_invoice.invoice_id=$id";
//$sql="delete from tbl_product where pid=$id";


$delete=$pdo->prepare($sql);


if($delete->execute()){
 
}else{
    
  echo'Error al eliminar';  
}

?>