<?php
    ob_start();
    session_start();
    $titre='Connexion / Inscrire';
    $Errors=array();
    if(isset($_SESSION['userlog'])){
        header('location: index.php');
    }
    include 'abbreviations.php';
    if($_SERVER['REQUEST_METHOD']=='POST'){//verifions si l'utilisateur venir de HTTP POST request
        
        if(isset($_POST['login'])){
        
            $email= $_POST['email'];
            $password = $_POST['password'];
            $hashedPass = sha1($password);

            //verifions si l'utilisateur existe dans la base de donnees
            $stmt = $connect->prepare("SELECT * FROM users WHERE email=? AND password=?");
            $stmt-> execute(array($email, $hashedPass));
            $row = $stmt->fetch();
            $count=$stmt->rowCount();

            //si $count > 0 ça veut dire que l'utilisateur est existe dans la base de donnees
            if($count > 0){
                $_SESSION['userlog'] = $email; //s'inscrire le nom de la session email
                $_SESSION['Prenom'] = $row['Prenom'];
                $_SESSION['ID'] = $row['userID'];
                $_SESSION['grp_ID'] = $row['grpID'];
                header('location:index.php'); //redirect en inedx
                exit();
            }else{

                $Errors[]='<h5>ERREUR !<br>Vérifier votre <strong>email / mot de passe</strong></h5>';
            }
        }else{//$_POST['signup']
            $email= $_POST['email'];
            $password = $_POST['password'];
            $hashedPass = sha1($password);
            $nom=$_POST['lastname'];
            $prenom=$_POST['firstname'];
            $tele=$_POST['tele'];
            if(empty($password)){
                $Errors[] = 'Le mot de passe ne peut pas être <b>vide</b>';
            }
            if(strlen($password)<6 || strlen($password)>20){
                $Errors[] = 'Le mot de passe doit contenir <b>entre 6 et 20 caractères</b>';
            }
            if(empty($nom)){
                $Errors[] = 'Le Nom ne peut pas être <b>vide</b>';
            }
            if(empty($prenom)){
                $Errors[] = 'Le prenom ne peut pas être <b>vide</b>';
            }
            if(empty($email)){
                $Errors[] = 'L\'email ne peut pas être <b>vide</b>';
            }
            $checkemail=check("email","users",$email);//verifier si l'email déja existe
            if($checkemail==1){
            $Errors[] = "<div style='font-size:2em'>Email déja utilisé!!!</div>";
            }
            if(empty($Errors)){//verifions si y a pas d'erreurs pour acceder a Inserer les donnees dans la base de donnees
                $stmt = $connect -> prepare('INSERT INTO users(email, password, Nom, Prenom,Telephone,grpID) VALUES(:omail, :ohashPass, :oNom, :oPrenom,:tele,0 )');
                    $stmt-> execute(array(
                    'omail'=>$email,
                    'ohashPass'=>$hashedPass,
                    'oNom'=>$nom,
                    'oPrenom'=>$prenom,
                    'tele'=>$tele
                    ));
                    echo "<div class='container alert alert-success' style='font-size:30px;'>Compte créé avec succes!<br>Insérez vos données pour continue</div>";
            
            }
        }
    }
?>
<div class="container login-page">
    <h1 class="text-center"><span data-class="login" class="selected">Connexion</span> | <span data-class="signup">S'inscrire</span></h1>
    <!-- connexion -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="input-cont">
        <input class="form-control form-control-lg" name="email" type="email" placeholder="Email..." required>
        </div>
        <div class="input-cont">
        <input class="form-control form-control-lg password" name="password" type="password" placeholder="Mot de passe..." required>
        <i class="show-pass fa fa-eye"></i>
        </div>
        <input name="login" type="submit" class="btn btn-primary btn-lg btn-block" value="Connexion">
    </form>
    <!-- S'inscrire -->
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="input-cont">
        <input class="form-control form-control-lg" name="email" type="email" placeholder="Email..." required>
        </div>
        <div class="input-cont">
        <input class="form-control form-control-lg password" name="password" type="password" placeholder="Mot de passe..." required>
        <i class="show-pass fa fa-eye"></i>
        </div>
        <div class="input-cont">
        <input class="form-control form-control-lg" name="lastname" type="text" placeholder="Nom..." required="required">
        </div>
        <div class="input-cont">
        <input class="form-control form-control-lg" name="firstname" type="text" placeholder="Prénom..." required>
        </div>
        <input class="form-control form-control-lg" name="tele" type="text" placeholder="Téléphone (optinnel)">
        <input name="signup" type="submit" class="btn btn-success btn-lg btn-block" value="Créer votre compte">
    </form>
<?php
    foreach($Errors as $er){
        echo '<div class=" text-center container alert alert-danger">'.$er.'</div>';
    }
?>
</div>




<?php
    include $templates.'footer.php';
    ob_end_flush();
?>