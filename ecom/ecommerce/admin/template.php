<?php
    ob_start();
    session_start();
    $titre='';
        if(isset($_SESSION['log'])){
            include 'abbreviations.php';
            $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

            if($do == 'manage'){//gérer

            }elseif($do == 'add'){//ajout
            
            }elseif($do=='insert'){
            
            }elseif($do=='update'){

            }elseif($do=='delete'){

            }
            
        }else{
                redirecthome("<div class='container alert alert-danger'>ERREUR</div>");
            }
            
            include $templates.'footer.php';
    ob_end_flush();
?>