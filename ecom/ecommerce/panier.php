<?php
    session_start();
    include 'abbreviations.php';
    $titre = "Panier";
    $rows=panier($_SESSION['ID']);
    $prodid = isset($_GET['delete'])&&is_numeric($_GET['delete']) ? intval($_GET['delete']) : 0;
    $stmt=$connect->prepare("DELETE FROM panier WHERE id_pr=?");
    $stmt->execute(array($prodid));
    if(isset($_GET['delete'])&&is_numeric($_GET['delete'])){
        header('location: panier.php');
    }
?>
<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">Panier</h1>
     </div>
</section>
<?php                  if(empty($rows)){
    echo'<div class="panierpage container text-center alert alert-warning">Votre panier <i class="fa fa-shopping-cart"></i> est <b>vide!</b><br><br>';
                            echo '<img class="imgpanier" src="empty-cart.png"><br><br><span>Ajouter des produits à votre panier</span></div>';
                        }else{  ?>
<div class="container mb-4 panier">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Produit</th>
                            <th scope="col" class="text-right">Prix</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
<?php                   
                        foreach($rows as $row){
                            
                        
?>                        <tr>
                            <td><img src="<?php echo $row['img_pr']; ?>"/> </td>
                            <td class=" font-weight-bold"><?php echo $row['nom_pr']; ?></td>
                            <td class="text-right font-weight-bold"><?php echo $row['prix']; ?> DH</td>
                            <td class="text-right"><a href="?delete=<?php echo $row['id_pr'] ?>" class="confirmation btn btn-sm btn-danger"><i class="fa fa-trash"></i> </a> </td>
                        </tr>
<?php                        } ?>
                    </tbody>
                    <tfoot>
                        <td></td>
                        <td class="text-right"><b>Total TTC :</b></td>
                        <td class="text-right">
                        <?php   
                        $sum = 0;                
                        foreach($rows as $row){
                            $sum += $row['prix'];

                        }
                        echo "<b>".$sum . " DH</b>"; }
                        ?> 
                        </td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
    include $templates.'footer.php';
?>