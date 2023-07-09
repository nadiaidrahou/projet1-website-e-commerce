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

    /* fonction pour obtenir les categories existants  */
    function getCategories(){
        global $connect;
        $stmt=$connect->prepare("SELECT * FROM categories ORDER BY cat_ID ASC");
        $stmt->execute();
        $categories=$stmt->fetchAll();
        return $categories;
    }
    /* fonction pour obtenir les categories a partir de ID  */
    function catbyid($id){
        global $connect;
        $stmt=$connect->prepare("SELECT * FROM categories WHERE cat_ID=?");
        $stmt->execute(array($id));
        $categorie=$stmt->fetch();
        return $categorie;
    }

    //panier
    function panier($id){
        global $connect;
        $stmt=$connect->prepare("SELECT * FROM panier WHERE id_us=?");
        $stmt->execute(array($id));
        $panier=$stmt->fetchAll();
        return $panier;
    }



    /* fonction pour obtenir les produits existants  */
    function getProducts(){
        global $connect;
        $stmt=$connect->prepare("SELECT * FROM produits ORDER BY rand()");
        $stmt->execute();
        $produits=$stmt->fetchAll();
        return $produits;
    }
    
    //fonction pour avoir "Autres produits de même catégorie"
    function autreproduits($id){
        global $connect;
        $stmt=$connect->prepare("SELECT * FROM produits WHERE id_cat_et =? ORDER BY rand()");
        $stmt->execute(array($id));
        $autreprod=$stmt->fetchAll();
        return $autreprod;
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

    //fonction obtenir les derniers clients/produits
    function getlatest($select,$from,$order,$limit=5){
        global $connect;
        $stmt=$connect->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");
        $stmt->execute();
        $rows=$stmt->fetchAll();
        return $rows;
    }