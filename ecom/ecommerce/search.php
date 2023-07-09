<?php
    ob_start();
    session_start();
    include 'abbreviations.php';
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $search=$_POST['search'];
        $stmt=$connect->prepare("SELECT * FROM produits WHERE prod_name LIKE '%$search%'");
        $stmt->execute();
        $rows=$stmt->fetchAll();
        echo'<br>';
        echo'<div class="container alert alert-info"><h5>Voici les produits lié avec votre recherche de "<b>'.$search.'</b>"</h5></div>';
        echo'<div class="row bg-light">';
            foreach($rows as $prod){
            
              echo'<div class="col-lg-3 col-md-6 mb-4">';
              echo'<form action="?add=';
                echo $prod['prod_ID'];
                echo'" method="POST">';
                    echo'<div class="card h-100">';
                        echo'<a href="produit.php?id='.$prod['prod_ID'].'&name='.str_replace(' ','-',$prod['prod_name']).'"><img class="card-img-top" src="'.$prod_img.$prod['main_image'].'" alt=""></a>';
                        echo'<input type="hidden" name="pr_img" value="'.$prod_img.$prod['main_image'].'">';
                        echo'<input type="hidden" name="id_pr" value="'.$prod['prod_ID'].'">';
                        echo'<div class="card-body bg-light">';
                            echo'<h6 class="card-title">';
                                echo'<a href="produit.php?id='.$prod['prod_ID'].'&name='.$prod['prod_name'].'">'.$prod['prod_name'].'</a>';
                                echo'<input type="hidden" name="pr_nom" value="'.$prod['prod_name'].'">';
                            echo'</h6>';
                            echo'<h4><strong>'.$prod['prod_price'].' DH'.'</strong></h4>';
                            echo'<input type="hidden" name="pr_prix" value="'.$prod['prod_price'].'">';
                        echo'</div>
                        </div>
                    </div>';
             echo'</form>';
             }
        echo'</div>';
        echo'</div>';
    }else{
        header('location: index.php');
    }
    ob_end_flush();
?>