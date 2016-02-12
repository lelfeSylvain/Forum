<?php
    if ($_REQUEST['num']=="tout" or !is_numeric($_REQUEST['num']) or !isset($_REQUEST['num'])) {
        $rubriqueMere=1;
        $rubriqueActuelle=1;
    }
    else {
        $rubriqueActuelle=$_REQUEST['num'];
        $rubriqueMere=$pdo->getRubriqueMere($rubriqueActuelle);
    }
    $lesRubriques = $pdo->getRubriquesIncluses($rubriqueActuelle);
    $lesPosts = $pdo->getPostsInclus($rubriqueActuelle);
   
    include 'vues/v_posts.php';
	







?>
