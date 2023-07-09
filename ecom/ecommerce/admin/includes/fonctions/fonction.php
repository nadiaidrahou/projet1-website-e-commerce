<?php
    //cette fonction pour les tites
    function Titles(){
       global $titre ;
       if(isset($titre)){
           echo $titre; 
       }else{
           echo 'Store';
       }
    }

    //cette fonction pour redirect a la page index
    function redirecthome($msg="<div class='container alert alert-danger'>ERREUR!</div>", $url= null, $seconds=3){
        $url=isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
        echo $msg;
        echo'<div class="container alert alert-primary">vous serez redirigé dans '.$seconds.'s.</div>';
        header("refresh:$seconds;url=$url");
        exit();
    }

    //verification si le Nom d'utilisateur ou email existe déja
    function check($select,$from,$value){
    global $connect;
    $stmt=$connect->prepare("SELECT $select FROM $from WHERE $select=?");
    $stmt->execute(array($value));
    $count=$stmt->rowCount();
    return $count;
    }

    //fonction pour compter le nombre d'utilisateurs
    function compter($item,$table){
        global $connect;
        $stmt=$connect->prepare("SELECT COUNT($item) FROM $table");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //fonction obtenir les derniers membres/articles
    function getlatest($select,$from,$order,$limit=5){
        global $connect;
        $stmt=$connect->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");
        $stmt->execute();
        $rows=$stmt->fetchAll();
        return $rows;
    }