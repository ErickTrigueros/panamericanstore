<?php

    try {
         //Don't write blank spaces in the databae connection
        $pdo = new PDO('mysql:host=localhost;dbname=panamericanstore_db','root','');
        //echo 'Connection Succesfull';
    } catch (PDOException $f) {
        echo $f->getmessage();
    }
   
?>