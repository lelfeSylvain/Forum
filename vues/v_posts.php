<?php

    // affiche un article passé en paramètre
    function afficherArticles($unPost){
        echo "<b><big>".$unPost['titre']."</big></b>";
        echo " - <b>".$unPost['pseudo']."</b><br />\n";
        echo "".$unPost['corps'].EOL;
        echo "rédigé le : ".$unPost['tsCreation'];
        if ($unPost['codeEtat']>2){
                echo ", ".$unPost['lib']." le ".$unPost['tsDerniereModif'];
        }
        echo EOL;
        echo "<a href='index.php?uc=creer&quoi=post&num=".$unPost['pnum']."'>répondre</a>";
        echo EOL;
    }
	

	
    // Affiche un entête d'une rubrique, si entete est vrai c'est la rubrique actuelle
    function afficherRubriques($uneRub,$entete=0){
        echo "<b><big><big>";
        if (!$entete) {
            echo "<a href='index.php?uc=lecture&num=".$uneRub['pnum']."'>";
        }
        echo $uneRub['titre'];
        if (!$entete) {
            echo "</a>";
        }
        echo "</a></big></big></b> ".EOL;
    }

    // suite du code
    // on affiche la référence à un niveau supérieur
    if ($rubriqueActuelle==1) {
        echo "vous êtes au plus haut niveau";
    }
    else {
        echo "<a href='index.php?uc=lecture&num=".$rubriqueMere."'>remonter au niveau supérieur</a>";
    }
    echo EOL;
    // on affiche les rubriques contenues à notre niveau. 
    // la première rubrique afichée est la rubrique actuelle
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
