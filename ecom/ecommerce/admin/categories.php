<?php
    ob_start();
    session_start();
    $titre='Catégories';
    if(isset($_SESSION['log'])){
        include 'abbreviations.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
        if($do == 'manage'){//gérer
?>          <div class="container">
                <h1 class="text-center">Gérer les catégories</h1>
                    <div class="card card-default">
                        <div class="card-header">
                        <i class="fa fa-list"></i> Les catégories existants
                        <a class="btn btn-primary pull-right" href="?do=add"><i class="fa fa-plus"></i> Ajouter une catégorie</a>
                        </div>
                        <div class="card-body categories">
                        
                        <?php   $limitusers=compter("cat_ID","categories");//nombre de categories a afficher dans la page categories
                                $new_cat=getlatest("*","categories","cat_ID",$limitusers);
                                foreach($new_cat as $new){
                                echo '<div class="cat">';
                                echo '<div class="hidden-buttons">';
                                    echo'<a class="btn btn-primary" href="?do=edit&catid='.$new['cat_ID'].'"><i class="fa fa-edit"></i> Modifier</a>';
                                    echo' <a class="btn btn-danger confirmation" href="?do=delete&catid='.$new['cat_ID'].'"><i class="fa fa-close"></i> Supprimer</a>'; 
                                echo '</div>';
                                    echo '<h4>'.$new['cat_name'];
                                    echo '</h4><span>'.$new['cat_description'].'</span>';
                                echo '</div>';
                                echo '<hr>';
                                }
                        ?>
                        
                        </div>
                    </div>
            </div>

<?php         }elseif($do == 'add'){//ajout
?>
                <div class="card card-default">
                <div class="card-header">
                <h1 class="text-center">Ajouter une catégorie</h1>
                </div>
                <div class="card-body">
                <div class="container">
                    <form class="form-horizontal" action="?do=insert" method="POST">
                    <div class="form-group row">
                        <label class="col-sm-2  control-label">Nom : </label>
                        <div class="col-sm-10 col-md-5">
                        <input type="text" name="name_cat" class="form-control form-control-lg" placeholder="Nom de catégorie.." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description_cat" class="col-sm-2  control-label">Description : </label>
                        <div class="col-sm-10 col-md-5">
                        <textarea name="description_cat" class="form-control" id="description_cat" rows="4" placeholder="Décrire cette catégorie.." required></textarea>
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
            
<?php       }elseif($do=='insert'){//la page de insert
                echo'<h1 class="text-center">Ajouter une catégorie</h1>';
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    $cat_name=$_POST['name_cat'];
                    $cat_description=$_POST['description_cat'];
                    $FormErrors = array();
                    if(empty($cat_name)){
                        $FormErrors[] = 'Le nom de la catégorie ne peut pas être <b>vide</b>';
                    }
                    if(empty($cat_description)){
                        $FormErrors[] = 'La déscription de la catégorie ne peut pas être <b>vide</b>';
                    }
                    ?><div class="container"><?php
                    foreach($FormErrors as $error){
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                    }
                    ?></div><?php
                   if(empty($FormErrors)){//verifions si y a pas d'erreurs pour acceder a Inserer les donnees dans la base de donnees
    
                        $check_cat_name=check("cat_name","categories",$cat_name);//verifier si categorie déja existe
                        if($check_cat_name==1){
                            echo"<div class='container alert alert-danger' style='font-size:2em'>Catégorie existe déja !!!<br></div>";
                        }else{
                        $stmt = $connect -> prepare('INSERT INTO categories(cat_name,cat_description)
                                                    VALUES(:name,:description)');
                        $stmt-> execute(array(
                            'name'=>$cat_name,
                            'description'=>$cat_description
                        ));
                        echo "<div class='container alert alert-success' style='font-size:30px;'>Catégorie ajouté avec succes!</div>";
                        redirecthome("");
                        }
                        }
                }else{
                    $errormsg="<div class='container alert alert-danger'>Vous n'êtes pas le droit de voir cette page</div>";
                    redirecthome($errormsg);
                } 
            //fin de la page de insert
            }elseif($do=='edit'){//la page edit categories
                $catid=isset($_GET['catid'])&&is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
                $stmt=$connect->prepare("SELECT * FROM categories WHERE cat_ID=?");
                $stmt->execute(array($catid));
                $row=$stmt->fetch();
                $count=$stmt->rowCount();
                if($count>0){
?>                    
                        <div class="card card-default">
                        <div class="card-header">
                        <h1 class="text-center">Modifier catégorie</h1>
                        </div>
                        <div class="card-body">
                        <div class="container">
                        <form class="form-horizontal" action="?do=update" method="POST">
                            <div class="form-group row">
                                <input type="hidden" name="catid" value="<?php echo $catid ?>"> <!-- pour renvoyer l'ID dans la form -->
                                <label class="col-sm-2  control-label">Nom : </label>
                                <div class="col-sm-10 col-md-5">
                                <input type="text" name="name_cat" class="form-control form-control-lg" value="<?php echo $row['cat_name'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description_cat" class="col-sm-2  control-label">Description : </label>
                                <div class="col-sm-10 col-md-5">
                                <textarea name="description_cat" class="form-control" id="description_cat" rows="4" required><?php echo $row['cat_description'] ?></textarea>
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
                //fin la page edit categories

            }elseif($do=='update'){//la page update categorie
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    echo'<h1 class="text-center">Mis à jour d\'une catégorie</h1>';
                    $cat_name=$_POST['name_cat'];
                    $cat_description=$_POST['description_cat'];
                    $id_cat=$_POST['catid'];
                    $FormErrors = array();
                    if(empty($cat_name)){
                        $FormErrors[] = 'Le nom de la catégorie ne peut pas être <b>vide</b>';
                    }
                    if(empty($cat_description)){
                        $FormErrors[] = 'La déscription de la catégorie ne peut pas être <b>vide</b>';
                    }
                    ?><div class="container"><?php
                    foreach($FormErrors as $error){
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                    }
                    ?></div><?php
                   if(empty($FormErrors)){//verifions si y a pas d'erreurs pour acceder a mis a jour les donnees dans la base de donnees
    
                        $check_cat_name=check("cat_name","categories",$cat_name);//verifier si ce nom est déja existe
                        if($check_cat_name==1){
                            echo"<div class='container alert alert-danger' style='font-size:2em'>Catégorie existe déja !!!<br>";
                            redirecthome("Essayer d'inserer une autre catégorie!</div>");
                        }else{
                        $stmt = $connect -> prepare('UPDATE categories SET cat_name=?,cat_description=? WHERE cat_ID=?');
                        $stmt-> execute(array($cat_name,$cat_description,$id_cat));
                        echo "<div class='container alert alert-success' style='font-size:30px;'>Catégorie modifié avec succes!</div>";
                        redirecthome("");
                        }
                        }
                }else{
                    redirecthome();
                }


            //fin la page update categorie
            }elseif($do=='delete'){
                $catid = isset($_GET['catid'])&&is_numeric($_GET['catid']) /*catid qui est dans la barre d'URL de navigateur*/ ? intval($_GET['catid']) : 0;
                $stmt = $connect->prepare("SELECT * FROM categories WHERE cat_ID=? LIMIT 1");//prendre les donnees depuis cat_ID
                $stmt-> execute(array($catid));
                $count=$stmt->rowCount();
                if($count > 0){
                    $stmt = $connect->prepare("DELETE FROM categories WHERE cat_ID=?");
                    $stmt->execute(array($catid));
                    echo '<div class="container"><h1>Suppression du catégorie</h1>';
                    echo '<div class="alert alert-success"><h3>Supprimé avec succes!</h3></div>';
                    redirecthome("");
                }else{
                    redirecthome("<div class='container alert alert-danger'>ERREUR</div>");
                }//fin de suppression d'une catégorie
            }else{
                redirecthome("<div class='container alert alert-danger'>ERREUR</div>");
            }
            
        }else{

            header('location: index.php');
                    }
            
            include $templates.'footer.php';
    ob_end_flush();
?>