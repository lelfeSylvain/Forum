<!DOCTYPE html>
<?php 
    include 'inc/class.Session.php'; 
    Session::init();
    include 'inc/class.PDOForum.php';
    include 'inc/fonctions.php';
    include 'vues/v_entete.php';
    // constantes 
    define("EOL","<br />\n");// fin de ligne html et saut de ligne
    
    if (!Session::isLogged()) {
        header('Location: login.php');
    }
    // à partir d'ici, l'utilisateur est forcément connecté
    $pdo = PDOForum::getPdoForum();
    // justement on enregistre sa dernière activité dans la BD
    $pdo->setDerniereCx($_SESSION['numUtil']);
    // actions ?
    if(!isset($_REQUEST['uc'])){ //s'il n'y a pas d'uc alors on consulte les posts
     $_REQUEST['uc'] = 'lecture';
     $_REQUEST['num'] = 'tout';
    }	 
    $uc = $_REQUEST['uc'];
    switch($uc){
        case 'lecture':{// uc lecture des posts
                include("controleurs/c_lecture.php");break;
        }
        case 'creer':{// uc création d'es'un post ou rubrique
                include("controleurs/c_creation.php");break;
        }
        default :  // par défaut on consulte les posts
            include("controleurs/c_lecture.php");
    }
    include("vues/v_pied.php") ;

?>


