<?php
    ob_start();
    session_start();
    if(isset($_GET['name'])){
        $titre=str_replace('-',' ',$_GET['name']);
        $pagename=$_GET['name'];
    }
    include 'abbreviations.php';
    $idprod= isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    $stmt=$connect->prepare("SELECT * FROM produits WHERE prod_ID=?");
    $stmt->execute(array($idprod));
    $row=$stmt->fetch();
    
?> 

    <div class="container page-produits">
        <div class="row bg-light">
            <div id="carouselExampleIndicators" class="col-lg-5 carousel slide my-4" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block img" src="<?php echo $prod_img.$row['main_image']; ?>" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img" src="<?php echo $prod_img.$row['img1']; ?>" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img" src="<?php echo $prod_img.$row['img2']; ?>" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                    <span class="sr-only">Précédent</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                    <span class="sr-only">Suivant</span>
                </a>
            </div>
            <div class="col-lg-4 prod-desc">
                <h3 class="card-title"><?php echo $row['prod_name']; ?></h3>
                <p class="card-text">La marque : <?php echo $row['prod_marque']; ?></p>
                <p class="card-text"><?php echo $row['prod_description']; ?></p>
                <hr>
                <h4><?php echo $row['prod_price']; ?> DH</h4>
                <br><hr>
                <a type="button" class="btn btn-warning btn-block" href="cont_achat.php">J'achète <i class="fa fa-cart"></i></a>
            </div>
            <div class="col-lg-3 brdr-lft-prod">
                <h3 class="my-4">Catégories</h3>
                <div class="list-group">
                    <?php $categories=getCategories();
                    foreach($categories as $cat){?>
                    <a href="categories.php?pageid=<?php echo $cat['cat_ID'].'&name='.str_replace(' ','-',$cat['cat_name']); ?>" class="list-group-item bg-dark text-white"><?php echo $cat['cat_name']. ' <i class="fa fa-spin fa-'.$cat['cat_icon'].'"></i></a>';}?>
                </div>
            </div>
        </div>
        <hr>
        <div class="bg-light">
            <?php $autreproduits= autreproduits($row['id_cat_et']);
            echo'<h3>Autres produits de même catégorie</h3>';
            echo'<div class="row">';
            foreach($autreproduits as $prod){ 
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
            }?>
        </div>
        </div>
    </div>








<?php
    include $templates.'footer.php';
    ob_end_flush();
?>