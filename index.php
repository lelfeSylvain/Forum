<!DOCTYPE html>
<?php 
    require_once 'inc/class.Session.php'; 
    Session::init();
    require_once 'inc/class.PDOForum.php';
    require_once 'inc/class.FabriqueVue.php';
    require_once 'inc/fonctions.php';
    include_once 'vues/v_entete.php';
    // constantes 
    define("EOL","<br />\n");// fin de ligne html et saut de ligne
    
    // si l'utilisateur n'est pas identifié, il doit le faire
    if (!Session::isLogged()) {
        header('Location: login.php');
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
        if ($_REQUEST['num']=="tout" or !is_numeric($_REQUEST['num']) or !isset($_REQUEST['num'])) {
            $rubriqueMere=1;
            $rubriqueActuelle=1;
        }
        else {
            $rubriqueActuelle=$_REQUEST['num'];
            $rubriqueMere=$pdo->getRubriqueMere($rubriqueActuelle);
        }
        include 'vues/v_ariane.php';
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


