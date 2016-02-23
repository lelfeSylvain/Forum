<?php
    
    $lesRubriques = $pdo->getRubriquesIncluses($rubriqueActuelle);
    $lesPosts = $pdo->getPostsInclus($rubriqueActuelle);
   
    include 'vues/v_posts.php';
	







?>
