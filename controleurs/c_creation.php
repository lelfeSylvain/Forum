<?php
    if (!isset($_REQUEST['quoi']) ) {// erreurs d'aiguillage
        include 'controleurs/c_lecture.php';
    }
    elseif ( !isset($_REQUEST['num']) ) { // aiguillage incomplet
        include 'controleurs/c_lecture.php';
    }
    else {// on a un quoi et un num 
        $quoi = $_REQUEST['quoi'];
        $num=$_REQUEST['num'];
        if ($quoi==="valider"){// on enregistre un nouveau post/rubrique
            if ($_REQUEST['post']) {//si c'est un nouveau post
                $titre=$_REQUEST['nomPost'];
                $post=$_REQUEST['lePost'];
                $num=$pdo->ajouterPost($num,$titre,$_SESSION['numUtil'],$post);
            }
            else {// c'est une rubrique
                $titre=$_REQUEST['nomRubrique'];
                $num=$pdo->ajouterRubrique($num,$titre,$_SESSION['numUtil']);
            }
        }
        $prochaine=$pdo->getProchainNumero();
        $vue->getForm($quoi,$num,$prochaine);
    }
                       
    


    

?>

