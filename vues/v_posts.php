<?php

    // affiche un article passé en paramètre
    function afficherArticles($unPost){
        echo "<div id='main' role='main' class='ma0 txtleft pas'>";
        echo "<span class='titrepost'>".$unPost['titre']."</span>";
        echo " - <span class='auteurpost'>".$unPost['pseudo']."</span><br />\n";
        echo "".$unPost['corps'].EOL;
        echo "<span class='textpetit'>rédigé le : ".$unPost['tsCreation'];
        if ($unPost['codeEtat']>2){
                echo ", ".$unPost['lib']." le ".$unPost['tsDerniereModif'];
        }
        echo "</span>".EOL;
        echo "<a href='index.php?uc=creer&quoi=post&num=".$unPost['pnum']."'>répondre</a>";
        echo "</div>";
    }
	

	
    // Affiche un entête d'une rubrique, si entete est vrai c'est la rubrique actuelle
    function afficherRubriques($uneRub,$entete=0){
        echo "<div  class='rubrique'>";
        if (!$entete) {
            echo "<a href='index.php?uc=lecture&num=".$uneRub['pnum']."'>";
        }
        echo $uneRub['titre'];
        if (!$entete) {
            echo "</a>";
        }
        echo "</div> ".EOL;
    }

    // suite du code
    // on affiche la référence à un niveau supérieur
    echo "<div class='ariane'>";
    if ($rubriqueActuelle==1) {
        echo "vous êtes au plus haut niveau";
    }
    else {
        echo "<a href='index.php?uc=lecture&num=".$rubriqueMere."'>remonter au niveau supérieur</a>";
    }
    echo "</div>";
    // on affiche les rubriques contenues à notre niveau. 
    // la première rubrique affichée est la rubrique actuelle
    foreach($lesRubriques as $uneRubrique){
        afficherRubriques($uneRubrique,$rubriqueActuelle==$uneRubrique['pnum']);// sans l'entete pour l'actuelle 
    }
    // on affiche les articles contenues dans la rubrique actuelle
    foreach($lesPosts as $unPost){
        afficherArticles($unPost);
    }
    // on propose de créer une nouvelle rubrique
    echo "<a href='index.php?uc=creer&quoi=rubrique&num=".$rubriqueActuelle."'>créer une nouvelle rubrique</a> - ";
    // on propose de créer un nouvel article
    echo "<a href='index.php?uc=creer&quoi=post&num=".$rubriqueActuelle."'>créer un nouvel article</a>";
    echo EOL;        
    

?>