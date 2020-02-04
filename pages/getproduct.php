<?php

include_once'connectdb.php';

$id = $_GET["id"];

$select=$pdo->prepare("select * from tbl_product where idp = :ppid");
$select->bindParam(':ppid',$id);
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$respone=$row;

header('Content-Type: application/json');//vamos a enviar el Json

echo json_encode($respone);

?>