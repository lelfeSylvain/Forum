<!DOCTYPE html>
<?php 
    require_once 'inc/class.Session.php'; 
    Session::init();
    require_once 'inc/class.PDOForum.php';
    require_once 'inc/class.FabriqueVue.php';
    require_once 'vues/fonctions.php';
    include_once 'vues/v_entete.php';
    // constantes 
    define("EOL","<br />\n");// fin de ligne html et saut de ligne
    define("EL","\n");//  saut de ligne 
    
    // si l'utilisateur n'est pas identifié, il doit le faire
    if (!Session::isLogged()) {
        $uc=$_REQUEST['uc'];
        if ($uc==="inscrire") {
                include ("controleurs/c_inscrire.php");
        }
        else {
            header('Location: login.php'); // redirection vers le fichier login.php
        }
    }
    else {  // à partir d'ici, l'utilisateur est forcément connecté
        // instanciation de la fabrique de vue
        $vue = FabriqueVue::getFabrique();
        // instanciation du modèle PDO
        $pdo = PDOForum::getPdoForum();
        // justement on enregistre la dernière activité de l'utilisateur dans la BD
        $pdo->setDerniereCx($_SESSION['numUtil']);
        // actions ?
        if(!isset($_REQUEST['uc'])){ //s'il n'y a pas d'uc alors on consulte les posts
         $_REQUEST['uc'] = 'lecture';
         $_REQUEST['num'] = 'tout';
        }	 
        $uc = $_REQUEST['uc'];
        // gère le fil d'ariane
        include_once 'controleurs/c_ariane.php';
        
        //aiguillage principal
        switch($uc){
            case 'lecture':{// uc lecture des posts
                include("controleurs/c_lecture.php");break;
            }
            case 'creer':{// uc création d'un post ou rubrique
                include("controleurs/c_creation.php");break;
            }
            default :  // par défaut on consulte les posts
                include("controleurs/c_lecture.php");
        }
    }
    include("vues/v_pied.php") ;

?>


