<!DOCTYPE html>
<?php 
    include 'inc/class.Session.php'; 
    Session::init();
    include 'inc/class.PDOForum.php';
    include 'vues/v_entete.php';
    if (!Session::isLogged()) {
        header('Location: login.php');
    }
    // à partir d'ici, l'utilisateur est forcément connecté
    $pdo = PDOForum::getPdoForum();
    
    if(!isset($_REQUEST['uc'])){ //s'il n'y a pas d'uc alors on consulte les posts
     $_REQUEST['uc'] = 'lecture';
     $_REQUEST['ac'] = 'tout';
    }	 
    $uc = $_REQUEST['uc'];
    switch($uc){
            case 'lecture':{// uc lecture des posts
                    include("controleurs/c_lecture.php");break;
            }
           
            default :  // par défaut on consulte les posts
				include("controleurs/c_lecture.php");
    }
    include("vues/v_pied.php") ;

?>


