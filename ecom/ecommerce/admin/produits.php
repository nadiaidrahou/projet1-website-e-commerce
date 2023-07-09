<?php
    ob_start();
    session_start();
    $titre='Produits';
        if(isset($_SESSION['log'])){
            include 'abbreviations.php';
            $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
            if($do == 'manage'){//gérer
?>              <div class="container">
                    <h1 class="text-center">Gérer les produits</h1>
                        <div class="card card-default">
                            <div class="card-header">
                            <i class="fa fa-tags"></i> Les produits existants
                            <a class="btn btn-primary pull-right" href="?do=add"><i class="fa fa-plus"></i> Ajouter un produit</a>
                            </div>
                        <div class="card-body categories">
                        
<?php                           $stmt2=$connect->prepare("SELECT * FROM produits ORDER BY prod_id DESC");
                                $stmt2->execute();
                                $new_prod=$stmt2->fetchAll();
                                if(!empty($new_prod)){
                                foreach($new_prod as $new){
                                echo '<div class="cat">';
                                echo '<div class="hidden-buttons">';
                                    echo'<a class="btn btn-primary" href="?do=edit&prodid='.$new['prod_ID'].'"><i class="fa fa-edit"></i> Modifier</a>';
                                    echo' <a class="btn btn-danger confirmation" href="?do=delete&prodid='.$new['prod_ID'].'"><i class="fa fa-close"></i> Supprimer</a>'; 
                                echo '</div>';
                                    echo '<h4 class="affichag-produit">'.$new['prod_name'].'</h4>';
                                    echo '<div class="full-view">';
                                    echo $new['prod_description'];
                                    echo "<div><img src='upload/img_produits/".$new['main_image']."' width=100></div>";
                                    echo '<p>Prix : <strong>'.$new['prod_price'].' DH</strong></p>';
                                    echo '</div>';
                                echo '</div>';
                                echo '<hr>';
                                }
                                }else{
                                    echo 'Il n\'y a pas de produit à montrer';
                                }
                        ?>
                        
                        </div>
                    </div>
                 </div>

<?php       }elseif($do == 'add'){//ajout

?>                
                    <div class="card card-default">
                    <div class="card-header">
                    <h1 class="text-center">Ajouter un produit</h1>
                    </div>
                    <div class="card-body">
                    <div class="container">
                    <form class="form-horizontal" action="?do=insert" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-sm-2  control-label">Nom : </label>
                        <div class="col-sm-10 col-md-5">
                        <input type="text" name="name_prod" class="form-control form-control-lg" placeholder="Nom du produit.." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2  control-label">La marque :</label>
                        <div class="col-sm-10 col-md-5">
                        <input type="text" name="marque_prod" class="form-control form-control-lg" placeholder="La marque du produit.." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2  control-label">Catégorie :</label>
                        <div class="col-sm-10 col-md-5">
                        <select name="categories" class="custom-select">
<?php                       $stmt=$connect->prepare("SELECT * FROM categories");
                            $stmt->execute();
                            $cats=$stmt->fetchAll();
                            foreach($cats as $cat){
                                echo'<option value="'.$cat['cat_ID'].'">'.$cat['cat_name'].'</option>';
                            }
?>                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description_prod" class="col-sm-2  control-label">Description : </label>
                        <div class="col-sm-10 col-md-5">
                        <textarea name="description_prod" class="form-control" id="description_prod" rows="4" placeholder="Décrire ce produit.." required></textarea>
                        </div>
                    </div>
                    <div class="form-group row prix-prix">
                        <label class="col-sm-2  control-label">Prix : </label>
                        <div class="col-sm-1 col-md-2">
                        <input type="number" name="prix" class="form-control form-control-lg" style="position: relative;" required>
                        <span class="prix-dh"><strong>DH</strong></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2  control-label">Photo principale :</label>
                        <div class="col-sm-10 col-md-5">
                        <input type="file" name="main_photo" class="form-control form-control-lg" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2  control-label">Photo 2 :</label>
                        <div class="col-sm-10 col-md-5">
                        <input type="file" name="img2" class="form-control form-control-lg" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2  control-label">Photo 3 :</label>
                        <div class="col-sm-10 col-md-5">
                        <input type="file" name="img3" class="form-control form-control-lg" required>
                        </div>
                    </div>
                    <div class="form-group form-group-lg row">
                        <div class="offset-sm-2 col-sm-10">
                            <input type="submit" class="btn btn-primary btn-lg" value="Enregistrer">
                        </div>
                    </div>
                    </form>
                </div>
                </div>
                </div>
                    
 <?php      }elseif($do=='insert'){//insert page
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    $prod_name=$_POST['name_prod'];
                    $prod_description=$_POST['description_prod'];
                    $prod_prix=$_POST['prix'];
                    $prod_marque=$_POST['marque_prod'];
                    $categories=$_POST['categories'];
                    $img=$_FILES['main_photo']['name'];//nom de l'image principale
                    $img2=$_FILES['img2']['name'];//nom de l'image 2
                    $img3=$_FILES['img3']['name'];//nom de l'image 3
                    $tmp=$_FILES['main_photo']['tmp_name'];//directoire temporaire de l'image principale
                    $tmp2=$_FILES['img2']['tmp_name'];//directoire temporaire de l'image 2
                    $tmp3=$_FILES['img3']['tmp_name'];//directoire temporaire de l'image 3
                    $FormErrors = array();
                    if(empty($prod_name)){
                        $FormErrors[] = 'Le nom dproduit ne peut pas être <b>vide</b>';
                    }
                    if(empty($prod_description)){
                        $FormErrors[] = 'La déscription du produit ne peut pas être <b>vide</b>';
                    }
                    if(empty($prod_prix)){
                        $FormErrors[] = 'Le prix du produit ne peut pas être <b>vide</b>';
                    }
                    if(empty($img)){
                        $FormErrors[] = 'L\'image principale doit être <b>téléchargée</b>';
                    }
                    if(empty($img2)){
                        $FormErrors[] = 'L\'image 2 doit être <b>téléchargée</b>';
                    }
                    if(empty($img3)){
                        $FormErrors[] = 'L\'image 3 doit être <b>téléchargée</b>';
                    }
                    ?><div class="container"><?php
                    foreach($FormErrors as $error){
                        echo'<h1 class="text-center">Ajouter un produit</h1>';
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                    }
                    ?></div><?php
                   if(empty($FormErrors)){//verifions si y a pas d'erreurs pour acceder a Inserer les donnees dans la base de donnees
                        $photo=rand(0,1000).'_'.$img;
                        $photo2=rand(0,1000).'_'.$img2;
                        $photo3=rand(0,1000).'_'.$img3;
                        move_uploaded_file($tmp,"upload\img_produits\\".$photo);
                        move_uploaded_file($tmp2,"upload\img_produits\\".$photo2);
                        move_uploaded_file($tmp3,"upload\img_produits\\".$photo3);
                        
                        $stmt = $connect -> prepare('INSERT INTO produits(prod_name,prod_description,prod_price,prod_marque,id_cat_et,main_image,img1,img2)
                                                    VALUES(:name,:description,:prix,:marque,:cat,:img,:img2,:img3)');
                        $stmt-> execute(array(
                            'name'          =>$prod_name,
                            'description'   =>$prod_description,
                            'prix'          =>$prod_prix,
                            'marque'        =>$prod_marque,
                            'cat'           =>$categories,
                            'img'           =>$photo,
                            'img2'           =>$photo2,
                            'img3'           =>$photo3
                        ));
                        echo'<h1 class="text-center">Ajouter un produit</h1>';
                        echo "<div class='container alert alert-success' style='font-size:30px;'>Produit ajouté avec succes!</div>";
                        redirecthome("");
                        }
                }else{
                    $errormsg="<div class='container alert alert-danger'>Vous n'êtes pas le droit de voir cette page</div>";
                    redirecthome($errormsg);
                }//fin insert page
                
                }elseif($do=='edit'){//la page edit produits
                    $prodid=isset($_GET['prodid'])&&is_numeric($_GET['prodid']) ? intval($_GET['prodid']) : 0;
                    $stmt=$connect->prepare("SELECT * FROM produits WHERE prod_ID=?");
                    $stmt->execute(array($prodid));
                    $row=$stmt->fetch();
                    $count=$stmt->rowCount();
                    if($count>0){
        ?>              
                            <div class="card card-daefault">
                            <div class="card-header">
                            <h1 class="text-center">Modifier produit</h1>
                            </div>
                            <div class="card-body">
                            <div class="container">
                            <form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label class="col-sm-2  control-label">Nom : </label>
                                <div class="col-sm-10 col-md-5">
                                <input type="text" name="name_prod" class="form-control form-control-lg" value="<?php echo $row['prod_name']; ?>" required>
                                </div>
                            </div>
                            <input type="hidden" name="id_prod" value="<?php echo $prodid; ?>">
                            <div class="form-group row">
                                <label class="col-sm-2  control-label">La marque :</label>
                                <div class="col-sm-10 col-md-5">
                                <input type="text" name="marque_prod" class="form-control form-control-lg" value="<?php echo $row['prod_marque']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2  control-label">Catégorie :</label>
                                <div class="col-sm-10 col-md-5">
                                <select name="categories" class="custom-select">
<?php                       
                                    

                                    $stmt=$connect->prepare("SELECT * FROM categories");
                                    $stmt->execute();
                                    $cats=$stmt->fetchAll();
                                    foreach($cats as $cat){
                                        echo'<option value="'.$cat['cat_ID'].'"';
                                        if($cat['cat_ID']==$row['id_cat_et']){echo 'selected';}
                                        echo'>';
                                        echo $cat['cat_name'].'</option>';
                                    }
?>                              </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description_prod" class="col-sm-2  control-label">Description : </label>
                                <div class="col-sm-10 col-md-5">
                                <textarea name="description_prod" class="form-control" id="description_prod" rows="4" required><?php echo $row['prod_description']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row prix-prix">
                                <label class="col-sm-2  control-label">Prix : </label>
                                <div class="col-sm-10 col-md-2">
                                <input type="number" name="prix" class="form-control form-control-lg" style="position: relative;" value="<?php echo $row['prod_price']; ?>" required>
                                <span style="position: absolute;top: 12px;left: 185px;"><strong>DH</strong></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2  control-label">Aperçu du photo principale :</label>
                                <div class="col-sm-10 col-md-5">
                                <img src="<?php echo 'upload/img_produits/'.$row['main_image']; ?>" alt="" width="150">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2  control-label">Modifier photo principale :</label>
                                <div class="col-sm-10 col-md-5">
                                <input type="file" name="main_photo" class="form-control form-control-lg" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2  control-label">Photo 2 :</label>
                                <div class="col-sm-10 col-md-5">
                                <input type="file" name="img2" class="form-control form-control-lg" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2  control-label">Photo 3 :</label>
                                <div class="col-sm-10 col-md-5">
                                <input type="file" name="img3" class="form-control form-control-lg" required>
                                </div>
                            </div>
                            <div class="form-group form-group-lg row">
                                <div class="offset-sm-2 col-sm-10">
                                    <input type="submit" class="btn btn-primary btn-lg" value="Enregistrer">
                                </div>
                            </div>
                            </form>
                        </div>      
                        </div>      
                        </div>      

        <?php           }else{
                        redirecthome();
                    }
                    //fin la page edit produit

                }elseif($do=='update'){//la page update produit
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        echo'<h1 class="text-center">Mis à jour d\'un produit</h1>';
                        $prod_name=$_POST['name_prod'];
                        $prod_description=$_POST['description_prod'];
                        $id_prod=$_POST['id_prod'];
                        $prix_prod=$_POST['prix'];
                        $marque_prod=$_POST['marque_prod'];
                        $categories=$_POST['categories'];
                        $img=$_FILES['main_photo']['name'];
                        $img2=$_FILES['img2']['name'];
                        $img3=$_FILES['img3']['name'];
                        $tmp=$_FILES['main_photo']['tmp_name'];
                        $tmp2=$_FILES['img2']['tmp_name'];
                        $tmp3=$_FILES['img3']['tmp_name'];
                        $FormErrors = array();
                        if(empty($prod_name)){
                            $FormErrors[] = 'Le nom dproduit ne peut pas être <b>vide</b>';
                        }
                        if(empty($prod_description)){
                            $FormErrors[] = 'La déscription du produit ne peut pas être <b>vide</b>';
                        }
                        if(empty($prix_prod)){
                            $FormErrors[] = 'Le prix du produit ne peut pas être <b>vide</b>';
                        }
                        if(empty($img)){
                            $FormErrors[] = 'L\'image principale doit être <b>téléchargée</b>';
                        }
                        if(empty($img2)){
                            $FormErrors[] = 'L\'image 2 doit être <b>téléchargée</b>';
                        }
                        if(empty($img3)){
                            $FormErrors[] = 'L\'image 3 doit être <b>téléchargée</b>';
                        }
                        ?><div class="container"><?php
                        foreach($FormErrors as $error){
                            echo'<h1 class="text-center">Mis à jour d\'un produit</h1>';
                            echo '<div class="alert alert-danger">'.$error.'</div>';
                        }
                        ?></div><?php
                            if(empty($FormErrors)){//verifions si y a pas d'erreurs pour acceder a mis a jour les donnees dans la base de donnees
                            $photo=rand(0,10000).'_'.$img;
                            $photo2=rand(0,10000).'_'.$img2;
                            $photo3=rand(0,10000).'_'.$img3;
                            move_uploaded_file($tmp,"upload\img_produits\\".$photo);
                            move_uploaded_file($tmp2,"upload\img_produits\\".$photo2);
                            move_uploaded_file($tmp3,"upload\img_produits\\".$photo3);
                            $stmt = $connect -> prepare('UPDATE produits SET prod_name=?,prod_description=?,prod_price=?,prod_marque=?,id_cat_et=?, main_image=?, img1=?, img2=? WHERE prod_ID=?');
                            $stmt-> execute(array($prod_name,$prod_description,$prix_prod,$marque_prod,$categories,$photo,$photo2,$photo3,$id_prod));
                            echo "<div class='container alert alert-success' style='font-size:30px;'>Produit modifié avec succes!</div>";
                            redirecthome("");
                            
                            }
                            }else{
                                redirecthome();
                            }


                            //fin la page update produit
                }elseif($do=='delete'){
                    $prodid = isset($_GET['prodid'])&&is_numeric($_GET['prodid']) /*prodid qui est dans la barre d'URL de navigateur*/ ? intval($_GET['prodid']) : 0;
                    $stmt = $connect->prepare("SELECT * FROM produits WHERE prod_ID=? LIMIT 1");//prendre les donnees depuis prod_ID
                    $stmt-> execute(array($prodid));
                    $count=$stmt->rowCount();
                    if($count > 0){
                        $stmt = $connect->prepare("DELETE FROM produits WHERE prod_ID=?");
                        $stmt->execute(array($prodid));
                        echo '<div class="container"><h1 class="text-center">Suppression du produit</h1>';
                        echo '<div class="alert alert-success"><h3>Supprimé avec succes!</h3></div>';
                        redirecthome("");
                    }else{
                        redirecthome("<div class='container alert alert-danger'>ERREUR</div>");
                    }//fin de suppression d'une produit
                }else{
                    redirecthome("<div class='container alert alert-danger'>ERREUR</div>");
                }
            
        }else{
                redirecthome("<div class='container alert alert-danger'>ERREUR</div>");
            }
            
            include $templates.'footer.php';
    ob_end_flush();
?>