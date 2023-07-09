<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href='<?php echo $img; ?>LN.jpg' />
    <link rel="stylesheet" href='<?php echo $css; ?>bootstrap.min.css'>
    <link rel="stylesheet" href='<?php echo $css; ?>font-awesome.min.css'>
    <link rel="stylesheet" href='<?php echo $css; ?>frontend.css'>
    <title><?php Titles() ?></title>
</head> 
<body class="d-flex flex-column min-vh-100">
<?php
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" .$_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
?>
    <nav class="navbar fixed-top navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand text-white" href="index.php"><img style="width: 55px; height:40px;" src="layout/img/LN.png" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fa fa-2x fa-list"></i></span>
        </button>
        <div class="navbar-collapse collapse show" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if($link=='http://localhost/ecommerce/index.php'){echo 'active'; } ?>">
                <a class="nav-link" href="index.php"><i class="fa fa-home"> </i> Acceuil</a>
            </li>
            <li class="nav-item <?php if($link=='http://localhost/ecommerce/categories.php'){echo 'active'; } ?>">
                <a class="nav-link" href="categories.php"><i class="fa fa-list"></i> Catégories</a>
            </li>
<?php       if(isset($_SESSION['userlog'])&&$_SESSION['grp_ID']==1){  ?>
            <li class="nav-item">
                <a class="nav-link" href="admin/"><i class="fa fa-briefcase"></i> ADMIN</a>
            </li>
<?php       } ?>
            
            <form action="search.php" method="POST"><!-- Search form -->
                <div class="searchbar-nav">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
            </ul>
<?php       if(isset($_SESSION['userlog'])){    ?>
            <ul class="navbar-nav mr-right">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle userlogbar" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user"></i> <?php echo ' Bonjour, '.$_SESSION['Prenom']?> <!-- l'utilisateur/l'admin --> 
                </a>
                <div class="dropdown-menu userlogbar" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="profile.php"><i class="fa fa-edit"></i> Modifier le profil</a>
                <a class="dropdown-item" href="panier.php"><i class="fa fa-shopping-cart"></i> Votre panier</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i> Se déconnecter</a>
                </div>
            </li>
            </ul>
<?php            }else{ ?>
            
            <ul class="navbar-nav log mr-right">
                <li><a href="login.php">Se connecter/S'inscrire</a></li>
            </ul>
<?php            }
?>                
            
        </div>
        </div>
    </nav>
    
    