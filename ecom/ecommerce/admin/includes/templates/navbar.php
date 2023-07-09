<?php
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" .$_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
?>


<nav class="navbar navbar-expand-lg">
  <div class="container">
  <a class="navbar-brand" href="../"><img style="width: 60px; height:40px;" src="layout/img/LN.png" alt=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-collapse collapse show" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if($link=='http://localhost/ecommerce/admin/dashboard.php'){echo 'active'; } ?>">
        <a class="nav-link" href="dashboard.php"><i class="fa fa-home"> </i> Acceuil</a>
      </li>
      <li class="nav-item <?php if($link=='http://localhost/ecommerce/admin/categories.php'){echo 'active'; } ?>">
        <a class="nav-link" href="categories.php"><i class="fa fa-list"></i> Catégories</a>
      </li>
      <li class="nav-item <?php if($link=='http://localhost/ecommerce/admin/produits.php'){echo 'active'; } ?>">
        <a class="nav-link" href="produits.php"><i class="fa fa-tags"></i> Produits</a>
      </li>
      <li class="nav-item <?php if($link=='http://localhost/ecommerce/admin/membres.php'){echo 'active'; } ?>">
        <a class="nav-link" href="membres.php"><i class="fa fa-users"></i> Les clients </a>
      </li>
      
    </ul>
    
    <ul class="navbar-nav mr-right">
    <li class="nav-item dropdown <?php if($link=='http://localhost/ecommerce/admin/membres.php'){echo 'active'; } ?>">
        <a class="nav-link dropdown-toggle userlogbar" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-user"></i> <?php echo ' Bonjour, '.$_SESSION['Prenom'] ?><!-- l'utilisateur/l'admin -->
        </a>
        <div class="dropdown-menu userlogbar" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../index.php"><i class="fa fa-location-arrow"></i> Aller au magasin</a>
          <a class="dropdown-item" href="membres.php?do=edit&amp;userid=<?php echo $_SESSION['ID'] ?>"><i class="fa fa-edit"></i> Modifier le profil</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i> Se déconnecter</a>
        </div>
      </li>
    </ul>
  </div>
  </div>
</nav>
    