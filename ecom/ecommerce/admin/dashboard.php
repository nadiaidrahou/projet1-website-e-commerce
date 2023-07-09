<?php
    session_start();

    if(isset($_SESSION['log'])){
        $titre='Tableau de bord';
        include 'abbreviations.php';
?>      <div class="container text-center">
        <h1>Tableau de bord</h1>
        <div class="row">
           <div class="col-md-6">
                <div class="dashtable tab-membres">
                    <i class="fa fa-users"></i> clients au totale
                <a href="membres.php"><span><?php $stmt=$connect->prepare("SELECT COUNT(userID) FROM users WHERE grpID=0");
                                                  $stmt->execute();
                                                  echo $stmt->fetchColumn(); ?></span></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashtable tab-articles">
                <i class="fa fa-tags"></i> Produits au total
                <a href="produits.php"><span><?php echo compter('prod_ID','produits'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="card card-default">
                    <div class="card-header">
                    <i class="fa fa-users"></i> clients récents
                    <span class="tog-info pull-right">
                    <i class="fa fa-chevron-circle-up"></i> 
                    </span>
                    </div>
                    <div class="card-body categories">
<?php                       $limitusers=4;//nombre d'utilisateurs a afficher dans latest users
                            $stmt=$connect->prepare('SELECT * FROM users WHERE grpID=0');
                            $stmt->execute();
                            $newusers=$stmt->fetchAll();
                            if(empty($newusers)){
                                echo'Pas de clients à afficher !';
                            }else{
                            foreach($newusers as $user){
                                echo '<div class="cat">';
                                echo '<div class="hidden-buttons">';
                                echo'<a class="btn btn-primary" href="membres.php?do=edit&userid='.$user['userID'].'"><i class="fa fa-edit"></i> Modifier</a>';
                                echo'<a class="btn btn-danger confirmation" href="membres.php?do=delete&userid='.$user['userID'].'"><i class="fa fa-close"></i> Supprimer</a>';
                                echo '</div>';
                                
                                echo '<strong>'.$user['Prenom'].' '.$user['Nom'].'</strong>';
                                
                            echo '</div>';
                            echo '<hr>';
                            }}
?>
                    </div>
                </div>
                        
            </div>
            <div class="col-sm-6">
                <div class="card card-default">
                    <div class="card-header">
                    <i class="fa fa-tags"></i> Produits récents
                    <span class="tog-info pull-right">
                    <i class="fa fa-chevron-circle-up"></i> 
                    </span>
                    </div>
                    <div class="card-body categories">
<?php                       $limitprod=4;//nombre de produit a afficher dans dashboard
                            $newprod=getlatest("*","produits","prod_ID",$limitprod);
                            if(!empty($newprod)){
                            foreach($newprod as $new){
                            echo '<div class="cat">';
                            echo '<div class="hidden-buttons">';
                                echo'<a class="btn btn-primary" href="produits.php?do=edit&prodid='.$new['prod_ID'].'"><i class="fa fa-edit"></i> Modifier</a>';
                                echo'<a class="btn btn-danger confirmation" href="produits.php?do=delete&prodid='.$new['prod_ID'].'"><i class="fa fa-close"></i> Supprimer</a>';
                                echo '</div>';
                                echo '<strong>'.$new['prod_name'].'</strong>';
                            echo '</div>';
                            echo '<hr>';
                            }}else{
                                echo 'Il n\'y a pas de produit à montrer';
                            }
?>
                    </div>
                </div>
            </div>
        </div>
    </div>

        

<?php    }else{
        header('location: index.php');
        exit(); 
    }
    include $templates.'footer.php';
?>