<?php
    ob_start();
    session_start();
    include 'abbreviations.php';
    if(isset($_SESSION['userlog'])){
        $stmt=$connect->prepare("SELECT * FROM users WHERE userID=?");
        $stmt->execute(array($_SESSION['ID']));
        $row=$stmt->fetch();
        
        ?>
        <div class="container card card-default bg-light">
            <div class="card-header">
            <h1 class="text-center">
            veuillez vérifier votre données pour continuer a acheter
            </h1>
            </div>
            <div class="card-body">
            <form action="profile.php?do=update" method="POST">
                <div class="row">
                <label clas="col-md-4">Téléphone : </label>
                <div class="col-md-8 input-cont">
                <input class="form-control form-control-lg" name="tele" type="text" value="<?php echo $row['Telephone']; ?>" placeholder="Téléphone (optinnel)" >
                </div>
                </div>
                <div class="row">
                <label clas="col-md-4">Adresse : </label>
                <div class="col-md-8 input-cont">
                <input style="margin-left:18px;" class="form-control form-control-lg" name="adresse" type="text" value="<?php echo $row['Adresse']; ?>" placeholder="Adresse (optinnel)" >
                </div>
                </div>
                <div class="row">
                <label clas="col-md-4">Ville : </label>
                <div class="col-md-8 input-cont">
                <input style="margin-left:43px;" class="form-control form-control-lg" name="city" type="text" value="<?php echo $row['Ville']; ?>" placeholder="Ville (optinnel)">
                </div>
                </div>
                <div class="input-cont">
                <input type="submit" name="login" class="offset-md-1 btn btn-primary btn-lg col-md-8" value="Continue a acheter">
                </div>    
            </form> 
            </div>
        </div>
<?php  
  }else{
        header('location: login.php');
    }



    include $templates.'footer.php';
    ob_end_flush();
?>