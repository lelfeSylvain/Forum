<!DOCTYPE html>
<?php 
    include 'inc/class.Session.php'; 
    Session::init();
    include 'inc/class.PDOForum.php';
    
    if (!Session::isLogged()) {
        header('Location: login.php');
    }
    // à partir d'ici, l'utilisateur est forcément connecté
  /*  $pdo = PDOForum::getPdoForum();
    
    if(!isset($_REQUEST['uc'])){ //s'il n'y a pas d'uc alors on consulte le menu
     $_REQUEST['uc'] = 'vis';
     $_REQUEST['ac'] = 'cm';
    }	 
    $uc = $_REQUEST['uc'];
    switch($uc){
            case 'vis':{// uc des visiteurs
                    include("controleurs/c_vis.php");break;
            }
            case 'adm' :{// uc des administrateur 
                    include("controleurs/c_adm.php");	 
                    break;
            }
            default : include("controleurs/c_vis.php");
    }
    include("vues/v_pied.php") ;
*/
?>
<html>
<head><title>Index</title><meta charset="UTF-8"></head>
<body>
Bonjour <?php print $_SESSION['username'] ." alias ".$_SESSION['prenom']." ". $_SESSION['nom']; ?>, vous êtes maintenant connecté.<br>
Votre précédente connexion était le <?php print $_SESSION['tsDerniereCx']; ?><br><a href="logout.php">Logout</a>
<br>
<?php //print $_SESSION['req']; ?><br>
</body>
</html>

