<?php
    ob_start();
    session_start();
    include "abbreviations.php";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_SESSION['userlog'])){
            $img=$_POST['pr_img'];
            $nom=$_POST['pr_nom'];
            $prix=$_POST['pr_prix'];
            $idus=$_SESSION['ID'];
            $idpr=$_POST['id_pr'];
            echo'<div class="container alert alert-success">Ajouté dans le panier</div>';
            $stmt=$connect->prepare("INSERT INTO panier(img_pr,nom_pr,prix,id_us,id_pr) VALUES(:img,:nom,:prix,:idus,:idpr)");
            $stmt->execute(array('img'=>$img,'nom'=>$nom,'prix'=>$prix,'idus'=>$idus,'idpr'=>$idpr));
        }else{
            header('location: login.php');
        }
    }
?> 
 
    <div class="container">         
        <div id="carouselExampleIndicators1" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators1" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators1" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators1" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img class="d-block img" src="layout/img/img1.png" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block img" src="layout/img/img2.png" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block img" src="layout/img/9.jpg" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Précédent</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Suivant</span>
            </a>
        </div>
        <div class="bg-light brdleft">
        <h2 class="my-4">Découvrez nos catégories<hr></h2>
        <div class="row separation-tabledecat">
            <?php $categories=getCategories();
            foreach($categories as $cat){
                echo"<a href='categories?pageid=".$cat['cat_ID']."&name=".str_replace(' ','-',$cat['cat_name'])."'>";
                echo'<div class="tabledecat">';
                echo $cat['cat_name'];
                echo ' <i class="fa fa-spin fa-'.$cat['cat_icon'].' "></i>';
                echo'</div>';
                echo'</a>';
            }
            ?>
        </div>
        </div>
        <hr>
        <div class="row bg-light">
            <?php $produits = getProducts();
            foreach($produits as $prod){
            
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
                            echo "<input type='submit' name='add_cart' class='btn btn-secondary' value='ajouter dans le panier'>";
                        echo'</div>
                        </div>
                    </div>';
             echo'</form>';
             }?>
        </div>
    </div>
    

<?php
    include $templates. "footer.php";
    ob_end_flush();
?>