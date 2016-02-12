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
        if ($quoi=="rubrique"){// on veut créer une rubrique
            $form= "fabriquer rubrique sous ".$num;
        }
        elseif ($quoi=="post") { // on veut créer un article
            $form= "fabriquer article sous ".$num;
        }
        elseif ($quoi=="valider") { // on va enregistrer le nouveau post (article ou rubrique)
            $form= "enregistrer rubrique sous ".$num;
        }
    }
                       
    


    include 'vues/v_creer.php';

?>

