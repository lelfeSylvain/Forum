<?php

    
    // on affiche les rubriques contenues à notre niveau. 
    // la première rubrique affichée est la rubrique actuelle
    foreach($lesRubriques as $uneRubrique){
        afficherRubrique($uneRubrique,$rubriqueActuelle==$uneRubrique['pnum']);// sans l'entete pour l'actuelle 
    }
    // on affiche les articles contenues dans la rubrique actuelle
    foreach($lesPosts as $unPost){
        afficherArticle($unPost);
    }
    echo "<nav>";
    // on propose de créer une nouvelle rubrique
    echo "<a href='index.php?uc=creer&quoi=rubrique&num=".$rubriqueActuelle."'>créer une nouvelle rubrique</a> - ";
    // on propose de créer un nouvel article
    echo "<a href='index.php?uc=creer&quoi=post&num=".$rubriqueActuelle."'>créer un nouvel article</a>";
    echo EOL;        
    echo"</nav></section>";

?>