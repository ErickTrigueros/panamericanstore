<?php

include_once'connectdb.php';

$id=$_POST['pidd'];// obtengo el piid de ajax (id del pedido)

// DELETE T1, T2 FROM T1 INNER JOIN T2 ON T1.key = T2.key  WHERE condition T1.key=id;
 
 

$sql="DELETE tbl_outbound , tbl_outbound_details FROM tbl_outbound INNER JOIN tbl_outbound_details ON tbl_outbound.invoice_id = tbl_outbound_details.invoice_id where tbl_outbound.invoice_id=$id";
//$sql="delete from tbl_product where pid=$id";


$delete=$pdo->prepare($sql);


if($delete->execute()){
 
}else{
    
  echo'Error al eliminar';  
}

?>