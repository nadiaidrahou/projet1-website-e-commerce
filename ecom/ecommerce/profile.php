<?php
    ob_start();
    session_start();
    $titre='Modifier profile';
    if(isset($_SESSION['userlog'])){
        include 'abbreviations.php';
        $do = isset($_GET['do']) ? $_GET['do'] : '';
        if($do == ''){
        $stmt=$connect->prepare("SELECT * FROM users WHERE userID=?");
        $stmt->execute(array($_SESSION['ID']));
        $row=$stmt->fetch();
?>
        <div class="card card-default">
        <div class="card-header">
        <div class="container">
            <h1 class="text-center">Modifier votre profile</h1>
        </div>
        </div>
        <div class="card-body  modification">
            <form action="?do=update" method="POST">
            <div class="input-cont">
            <input class="form-control form-control-lg" name="email" type="email" value="<?php echo $row['email'];$_SESSION['userlog']=$row['email']; ?>" required>
            </div>
            <input type="hidden" name="userid" value="<?php print_r($_SESSION['ID']); ?>"><!-- pour renvoyer l'ID dans la form -->
            <div class="input-cont">
            <input name="old-pwd" type="hidden" value="<?php echo $row['password']; ?>">
            <input class="form-control form-control-lg password" name="new-pwd" type="password" placeholder="Laissez vide si vous ne souhaitez pas modifier" autocomplete="new-password">
            <i class="show-pass fa fa-eye"></i>
            </div>
            <div class="input-cont">
            <input class="form-control form-control-lg" name="lastname" value="<?php echo $row['Nom']; ?>" required>
            </div>
            <div class="input-cont">
            <input class="form-control form-control-lg" name="firstname" value="<?php echo $row['Prenom']; ?>" required>
            </div>
            <input class="form-control form-control-lg" name="tele" type="text" value="<?php echo $row['Telephone']; ?>" placeholder="Téléphone (optinnel)">
            <input class="form-control form-control-lg" name="adresse" type="text" value="<?php echo $row['Adresse']; ?>" placeholder="Adresse (optinnel)">
            <input class="form-control form-control-lg" name="city" type="text" value="<?php echo $row['Ville']; ?>" placeholder="Ville (optinnel)">
            <input name="login" type="submit" class="btn btn-primary btn-lg btn-block" value="Enregistrer">
            </form>
        </div>
        </div>
<?php
        
        }elseif($do == 'update'){//mis a jour les donnees de user apres l'enregistrement
            
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo '<h1 class="text-center">Mis à jour</h1>';
                $userid=$_POST['userid'];
                $email=$_POST['email'];
                $Prenom=$_POST['firstname'];
                $Nom=$_POST['lastname'];
                $tele=$_POST['tele'];
                $adresse=$_POST['adresse'];
                $ville=$_POST['city'];
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
                if($email!=$_SESSION['userlog']){
                $checkemail=check("email","users",$email);//verifier si l'email déja existe
                if($checkemail==1){
                $FormErrors[] = "<div style='font-size:2em'>Email déja utilisé!!!</div>";
                }
                }
                if(empty($email)){
                    $FormErrors[] = 'L\'email ne peut pas être <b>vide</b>';
                }?><div class="container"><?php
                foreach($FormErrors as $error){
                    echo '<div class="alert alert-danger container">'.$error.'</div>';
                }?></div><?php
                if(empty($FormErrors)){//verifions si y a pas d'erreurs pour acceder a la mis a jour de la base de donnees
                $stmt = $connect->prepare("UPDATE users SET email=?,Nom=?,Prenom=?,password=?,Telephone=?,Adresse=?,Ville=? WHERE userid=?");//mis a jour les donnees depuis userID
                $stmt-> execute(array($email,$Nom,$Prenom,$pwd,$tele,$adresse,$ville,$userid));
                if($stmt->rowCount()==1){
                echo "<p class='container alert alert-success' style='font-size:30px;'>Modification appliqué avec succes!<p>";
                }elseif($stmt->rowCount()==0){
                    echo"<p class='container alert alert-primary' style='font-size:30px;'>Pas de modification!<p>";
                }
                }
                }
        }
                // fin de mis a jour de donnees de user apres l'enregistrement
    }else{
        header('location: index.php');
    }
?>




<?php
    include $templates.'footer.php';
    ob_end_flush();
?>