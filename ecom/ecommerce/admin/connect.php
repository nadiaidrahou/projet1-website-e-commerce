<?php
    $dsn = 'mysql:host=localhost;dbname=ecommerce'; //dsn = data source name
    $user='root';
    $pass='';
    $options=array(
        PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
    );
    try{
    $connect=new PDO($dsn,$user,$pass, $options);
    $connect ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo 'Erreur > '.$e ->getMessage();
    }
?>