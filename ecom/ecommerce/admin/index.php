<?php
    session_start();
    $titre='Connexion';
    $noNavbar=''; //pour que la nav bar n'affiche pas
    if(isset($_SESSION['log'])){
        header('location: dashboard.php');
    }
    include "abbreviations.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){//verifions si l'utilisateur venir de HTTP POST request
        
        $email= $_POST['email'];
        $password = $_POST['password'];
        $hashedPass = sha1($password);

        //verifions si l'utilisateur existe dans la base de donnees
        $stmt = $connect->prepare("SELECT email, password, Nom,Prenom, userID FROM users WHERE email=? AND password=? AND grpID=1 LIMIT 1");
        $stmt-> execute(array($email, $hashedPass));
        $row = $stmt->fetch();
        $count=$stmt->rowCount();

        //si $count > 0 ça veut dire que l'utilisateur est existe dans la base de donnees
        if($count > 0){
            $_SESSION['log'] = $email; //s'inscrire le nom de la session email
            $_SESSION['Prenom'] = $row['Prenom'];
            $_SESSION['ID'] = $row['userID'];
            header('location:dashboard.php'); //redirect en dashboard
            exit();
            }else{
                echo'<div class="text-center container alert alert-danger"><h5>L\'email ou le mot de passe <b>incorrect</b>. Veuillez réssaayer</h5></div>';
            }
        }
        
?>

    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <h4>Connectez-vous :</h4>
        <input class="form-control form-control-lg" name="email" type="email" placeholder="Email..." required>
        <input class="form-control form-control-lg" name="password" type="password" placeholder="Mot de passe..." required>
        <input name="login" type="submit" class="btn btn-primary btn-lg btn-block" value="Connexion">
    </form>

<?php
    include $templates. "footer.php";
?>