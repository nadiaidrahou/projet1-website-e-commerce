<?php
    session_start();
    $titre='Les clients';
    if(isset($_SESSION['log'])){
        include 'abbreviations.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

        if($do == 'manage'){//start manage page

            $stmt = $connect -> prepare('SELECT * FROM users WHERE grpID!=1 ORDER BY userID DESC');//selection de tout les utilisateurs sauf les admins
            $stmt->execute();
            $rows = $stmt->fetchAll();

?>
        <div class="container">
            <h1 class="text-center">Gérer les clients</h1>
            <a class="btn btn-primary" href="?do=add"><i class="fa fa-user-plus"></i> Ajouter un nouveau client</a><br/><br/>
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Nom complet</td>
                        <td>Email</td>
                        <td>Date de création</td>
                        <td>contrôle</td>
                    </tr>
                        
 <?php                  if(empty($rows)){
                            echo '<tr>
                                <td colspan="5"><div class="container alert alert-warning font-weight-bold"> Pas de clients à afficher</div></td>
                                </tr>';
                        }else{
                        foreach($rows as $row){
                        
                        echo'<tr>';
                        echo'<td>'.$row['userID'].'</td>';
                        echo'<td>'.$row['Prenom'].' '.$row['Nom'] .'</td>';
                        echo'<td>'.$row['email'].'</td>';
                        echo'<td>'.$row['datecreation'].'</td>';
                        echo'<td>';
                        echo'<a class="btn btn-primary" href="?do=edit&userid='.$row['userID'].'"><i class="fa fa-edit"></i> Modifier</a>';
                        echo' <a class="btn btn-danger confirmation" href="?do=delete&userid='.$row['userID'].'"><i class="fa fa-user-times"></i> Supprimer</a>';
                        echo'</td>';
                        echo'</tr>';
                        }}
?>                    
                </table>

            </div>
        </div>


            
    
<?php        }elseif($do == 'add'){//ajout des clients

    ?>         
                <div class="card card-default">    
                <div class="card-header">   
                <h1 class="text-center">Ajouter un client</h1>
                </div>
                <div class="card-body">
                <div class="container">

                <form class="form-horizontal" action="?do=insert" method="POST">
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Email : </label>
                    <div class="col-sm-10 col-md-5">
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email doit être valide" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-md-2">Mot de passe : </label>
                    <div class="col-sm-10 col-md-5">
                    <input type="password" name="pwd" class="password form-control form-control-lg" autocomplete="new-password" maxlength="20" minlength="6" placeholder="mot de passe doit être complexe" required>
                    <i class="show-pass fa fa-eye"></i>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Nom : </label>
                    <div class="col-sm-10 col-md-5">
                    <input type="text" name="lastname" class="form-control form-control-lg" placeholder="Ce nom sera affiché dans le profile" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Préom : </label>
                    <div class="col-sm-10 col-md-5">
                    <input type="text" name="firstname" class="form-control form-control-lg" placeholder="Ce prenom sera affiché dans le profile" required>
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
<?php
        }elseif($do == 'insert'){//apres l'ajout d'un client on va inserer les donnees de ce client dans la base de sonnees
            echo'<h1 class="text-center">Ajouter un client</h1>';
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $email=$_POST['email'];
                $Nom=$_POST['lastname'];
                $Prenom=$_POST['firstname'];
                $pwd=$_POST['pwd'];
                $hashPass=sha1($_POST['pwd']);
                $FormErrors = array();
                if(empty($pwd)){
                    $FormErrors[] = 'Le mot de passe ne peut pas être <b>vide</b>';
                }
                if(strlen($pwd)<6 || strlen($pwd)>20){
                    $FormErrors[] = 'Le mot de passe doit contenir <b>entre 6 et 20 caractères</b>';
                }
                if(empty($Nom)){
                    $FormErrors[] = 'Le Nom ne peut pas être <b>vide</b>';
                }
                if(empty($Prenom)){
                    $FormErrors[] = 'Le prenom ne peut pas être <b>vide</b>';
                }
                if(empty($email)){
                    $FormErrors[] = 'L\'email ne peut pas être <b>vide</b>';
                }?><div class="container"><?php
                foreach($FormErrors as $error){
                    echo '<div class="alert alert-danger container">'.$error.'</div>';
                }?></div><?php
                if(empty($FormErrors)){//verifions si y a pas d'erreurs pour acceder a Inserer les donnees dans la base de donnees

                    $checkemail=check("email","users",$email);//verifier si l'email déja existe
                    if($checkemail==1){
                        echo"<div class='container alert alert-danger' style='font-size:2em'>Email existe déja !!!<br>";
                        redirecthome("Ressayer avec un autre Email!</div>");
                    }else{
                    $stmt = $connect -> prepare('INSERT INTO users(email, password, Nom, Prenom)
                                                VALUES(:omail, :ohashPass, :oNom, :oPrenom )');
                    $stmt-> execute(array(
                        'omail'=>$email,
                        'ohashPass'=>$hashPass,
                        'oNom'=>$Nom,
                        'oPrenom'=>$Prenom
                    ));
                    echo "<div class='container alert alert-success' style='font-size:30px;'>Client ajouté avec succes!</div>";
                    redirecthome("");
                    }
                    }
            }else{
                $errormsg="<div class='container alert alert-danger'>Vous n'êtes pas le droit de voir cette page</div>";
                redirecthome($errormsg);
            }
        

        }elseif($do == 'edit'){//page de modifier
        $userid = isset($_GET['userid'])&&is_numeric($_GET['userid']) /*userid qui est dans la barre d'URL de navigateur*/ ? intval($_GET['userid']) : 0;
        $stmt = $connect->prepare("SELECT * FROM users WHERE userID=? LIMIT 1");//prendre les donnees depuis userID
        $stmt-> execute(array($userid));
        $row = $stmt->fetch();
        $count=$stmt->rowCount();
        if($count > 0){
            if($_SESSION['ID']==$userid){
            echo'<div class="card card-default">';
            echo'<div class="card-header">';
            echo'<h1 class="text-center">Modifier votre compte</h1></div>';
            }else{
            echo'<div class="card card-default">';
            echo'<div class="card-header">';
            echo '<h1 class="text-center">Modifier client</h1></div>';
            }
?>         
        <div class="card-body">
        <div class="container">

            <form class="form-horizontal" action="?do=update" method="POST">
            <div class="form-group row">
                <label class="col-sm-2  control-label">Email : </label>
                <div class="col-sm-10 col-md-6">
                <input type="email" name="email" class="form-control form-control-lg" value="<?php echo $row['email'] ?>" required>
                </div>
                <input type="hidden" name="userid" value="<?php echo $userid ?>"><!-- pour renvoyer l'ID dans la form -->
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-md-2">Mot de passe : </label>
                <div class="col-sm-10 col-md-6">
                <input type="hidden" name="old-pwd" value="<?php echo $row['password'] ?>">
                <input type="password" name="new-pwd" class="password form-control form-control-lg" autocomplete="new-password" placeholder="Laissez vide si vous ne souhaitez pas modifier">
                <i class="show-pass fa fa-eye"></i>
            </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Nom : </label>
                <div class="col-sm-10 col-md-6">
                <input type="text" name="lastname" class="form-control form-control-lg" value="<?php echo $row['Nom'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Prénom : </label>
                <div class="col-sm-10 col-md-6">
                <input type="text" name="firstname" class="form-control form-control-lg" value="<?php echo $row['Prenom'] ?>" required>
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
<?php        //fin page de modifier


        }else{//si userID n'est pas valide //redirection de dashboard 
            redirecthome("<div class='container alert alert-danger'>ID non valide</div>");
        }

        }elseif($do == 'update'){//mis a jour les donnees de user apres l'enregistrement
            
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo '<h1 class="text-center">Mis à jour</h1>';
                $id=$_POST['userid'];
                $email=$_POST['email'];
                $Prenom=$_POST['firstname'];
                $Nom=$_POST['lastname'];
                $pwd='';
                if(empty($_POST['new-pwd'])){//si le champ de mot de passe est vide on nous ne le metterons pas à jour
                    $pwd=$_POST['old-pwd'];
                }else{
                    $pwd=sha1($_POST['new-pwd']);
                }
                $FormErrors = array();
                if(empty($Nom)){
                    $FormErrors[] = 'Le nom ne peut pas être <b>vide</b>';
                }
                if(empty($Prenom)){
                    $FormErrors[] = 'Le prenom ne peut pas être <b>vide</b>';
                }
                if($email!=$_SESSION['log']){
                $checkemail=check("email","users",$email);//verifier si l'email déja existe
                if($checkemail==1){
                $FormErrors[] = "<div style='font-size:2em'>Email existe déja !!!<br>Ressayer avec un autre Email! </div>";
                }
                }
                if(empty($email)){
                    $FormErrors[] = 'L\'email ne peut pas être <b>vide</b>';
                }?><div class="container"><?php
                foreach($FormErrors as $error){
                    echo '<div class="alert alert-danger container">'.$error.'</div>';
                    redirecthome("");
                }?></div><?php
                if(empty($FormErrors)){//verifions si y a pas d'erreurs pour acceder a la mis a jour de la base de donnees
                $stmt = $connect->prepare("UPDATE users SET email=?,Nom=?,Prenom=?,password=? WHERE userID=?");//mis a jour les donnees depuis userID
                $stmt-> execute(array($email,$Nom,$Prenom,$pwd,$id));
                if($stmt->rowCount()==1){
                echo "<p class='container alert alert-success' style='font-size:30px;'>Modification appliqué avec succes!<p>";
                redirecthome("");
                }elseif($stmt->rowCount()==0){
                    echo"<p class='container alert alert-primary' style='font-size:30px;'>Pas de modification!<p>";
                    redirecthome("");
                }
                }
                // fin de mis a jour de donnees de user apres l'enregistrement
            }else{
                redirecthome("<div class='container alert alert-danger'>ERREUR</div>");            }
        }elseif($do == 'delete'){//suppression d'un client
            $userid = isset($_GET['userid'])&&is_numeric($_GET['userid']) /*userid qui est dans la barre d'URL de navigateur*/ ? intval($_GET['userid']) : 0;
            $stmt = $connect->prepare("SELECT * FROM users WHERE userID=? LIMIT 1");//prendre les donnees depuis userID
            $stmt-> execute(array($userid));
            $count=$stmt->rowCount();
            if($count > 0){
                $stmt = $connect->prepare("DELETE FROM users WHERE userID=?");
                $stmt->execute(array($userid));
                echo '<div class="container"><h1>Suppression</h1>';
                echo '<div class="alert alert-success"><h3>Supprimé avec succes!</h3></div></div>';
                redirecthome("");
            }else{
                redirecthome("<div class='container alert alert-danger'>ERREUR</div>");
            }//fin de suppression d'un client


        }else{
            redirecthome("<div class='container alert alert-danger'>ERREUR!</div>");
        }
    }else{


        header('location: index.php');        
         
    }
    
    include $templates.'footer.php';

?>