<?php

    try {
         //Don't write blank spaces in the databae connection
        $pdo = new PDO('mysql:host=localhost;dbname=u422793738_panamerican','u422793738_panam','Panam2020');//Production
        //$pdo = new PDO('mysql:host=localhost;dbname=panamericanstore_db','root','');//Develop
        //echo 'Connection Succesfull';
    } catch (PDOException $f) {
        echo $f->getmessage();
    }
   
?>
