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
        
        $vue->getForm($quoi,$num);
    }
                       
    


    

?>

