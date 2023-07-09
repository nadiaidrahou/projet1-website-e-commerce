
<?php
    ob_start();
    session_start();
    include 'abbreviations.php';
    if(isset($_GET['name'])){
    $titre=str_replace('-',' ',$_GET['name']);
    $pagename=$_GET['name'];
    
    
    $pageid = isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']) : 0;
    echo'<div class="container bg-light">';
    echo "<h1 class='display-4 font-weight-bold text-center text-uppercase'>".str_replace('-',' ',$pagename)."</h1>";
    $cate=catbyid($pageid);
    echo '<br><p><h2 class="text-center">'.$cate['cat_description'].'</h2></p>';
    echo'</div><hr>';
    echo'<div class="bg-light">';
    echo'<div class="row">';
    $stmt=$connect->prepare("SELECT * FROM produits WHERE id_cat_et=?");
    $stmt->execute(array($pageid));
    $produits=$stmt->fetchAll();
    foreach($produits as $prod){
        echo'<div class="col-lg-3 col-md-6 mb-4">';
        echo'<div class="card h-100">';
            echo'<a href="produit.php?id='.$prod['prod_ID'].'&name='.str_replace(' ','-',$prod['prod_name']).'"><img class="card-img-top" src="'.$prod_img.$prod['main_image'].'" alt=""></a>';
            echo'<div class="card-body bg-light">';
                echo'<h6 class="card-title">';
                    echo'<a href="produit.php?id='.$prod['prod_ID'].'&name='.$prod['prod_name'].'">'.$prod['prod_name'].'</a>';
                echo'</h6>';
                echo'<h4><strong>'.$prod['prod_price'].' DH'.'</strong></h4>';
            echo'</div>
            </div>
        </div>';
    }
    echo'</div>';
    echo'</div>';
   







   
    }else{
    echo'<div class="bg-light brdleft" style="margin-top:70px;">
    <h2 class="my-4">Découvrez nos catégories<hr></h2>
    <div class="row separation-tabledecat">';
        $categories=getCategories();
        foreach($categories as $cat){
            echo"<a href='categories?pageid=".$cat['cat_ID']."&name=".str_replace(' ','-',$cat['cat_name'])."'>";
            echo'<div class="tabledecat">';
            echo $cat['cat_name'];
            echo ' <i class="fa fa-spin fa-'.$cat['cat_icon'].' "></i>';
            echo'</div>';
            echo'</a>';
        }
        
    echo'</div>
    </div>';
    }



    include $templates.'footer.php';
    ob_end_flush();
?>