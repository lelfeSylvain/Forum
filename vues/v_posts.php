<?php

    // affiche un article passé en paramètre
    function afficherArticles($unPost){
        echo "<article id='main' role='main' class='mbs txtleft pas'>";
        echo "<span class='titrepost'>".$unPost['titre']."</span>";
        echo " - <span class='auteurpost'>".$unPost['pseudo']."</span><br />\n";
        echo "".$unPost['corps'].EOL;
        echo "<span class='textpetit'>rédigé le : ".$unPost['tsCreation'];
        if ($unPost['codeEtat']>2){
                echo ", ".$unPost['lib']." le ".$unPost['tsDerniereModif'];
        }
        echo "</span>".EOL;
        echo "<a href='index.php?uc=creer&quoi=post&num=".$unPost['pnum']."'>répondre</a>";
        echo "</article>";
    }
	

	
    // Affiche un entête d'une rubrique, si entete est vrai c'est la rubrique actuelle
    function afficherRubriques($uneRub,$entete=0){
        echo "<article  class='rubrique'>";
        if (!$entete) {
            echo "<a href='index.php?uc=lecture&num=".$uneRub['pnum']."'>";
        }
        echo $uneRub['titre'];
        if (!$entete) {
            echo "</a>";
        }
        echo "</article> ".EOL;
    }

    // suite du code
    echo "<section class='mls'>\n";
    // on affiche la référence à un niveau supérieur
    echo "<nav class='ariane mbs'>";
    if ($rubriqueActuelle==1) {
        echo "vous êtes au plus haut niveau";
    }
    else {
        echo "<a href='index.php?uc=lecture&num=".$rubriqueMere."'>remonter au niveau supérieur</a>";
    }
    echo "</nav>";
    // on affiche les rubriques contenues à notre niveau. 
    // la première rubrique affichée est la rubrique actuelle
    foreach($lesRubriques as $uneRubrique){
        afficherRubriques($uneRubrique,$rubriqueActuelle==$uneRubrique['pnum']);// sans l'entete pour l'actuelle 
    }
    // on affiche les articles contenues dans la rubrique actuelle
    foreach($lesPosts as $unPost){
        afficherArticles($unPost);
    }
    echo "<nav>";
    // on propose de créer une nouvelle rubrique
    echo "<a href='index.php?uc=creer&quoi=rubrique&num=".$rubriqueActuelle."'>créer une nouvelle rubrique</a> - ";
    // on propose de créer un nouvel article
    echo "<a href='index.php?uc=creer&quoi=post&num=".$rubriqueActuelle."'>créer un nouvel article</a>";
    echo EOL;        
    echo"</nav></section>";

?>