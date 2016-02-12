<?php

    // fonction affichant un article passé en paramètre
    function afficherArticles($unPost){
        echo "<b><big>".$unPost['titre']."</big></b>";
        echo " - <b>".$unPost['pseudo']."</b><br />\n";
        echo "".$unPost['corps']."<br />\n";
        echo "rédigé le : ".$unPost['tsCreation'];
        if ($unPost['codeEtat']>2){
                echo ", ".$unPost['lib']." le ".$unPost['tsDerniereModif'];
        }
        echo "<br />\n";
    }
	

	
    // Affiche un entête d'une rubrique, si entete est vrai alors on affiche le nombre de posts contenu dans la rubrique
    function afficherRubriques($uneRub,$entete=0){
        echo "<b><big><big><a href='index.php?uc=lecture&num=".$uneRub['pnum']."'>";
        echo $uneRub['titre']."</a></big></big></b> ";
        if ($entete && isset($uneRub['nb'])) {
                echo pluriel($uneRub['nb'],"post");
        }
        echo "<br />\n";
    }

    // suite du code
    if ($rubriqueActuelle==1) {
        echo "vous êtes au plus haut niveau<br/>\n";
    }
    else {
        echo "<a href='index.php?uc=lecture&num=".$rubriqueMere."'>remonter au niveau supérieur</a><br/>\n";
    }
    foreach($lesRubriques as $uneRubrique){
        afficherRubriques($uneRubrique);// sans l'entete 
    }
    foreach($lesPosts as $unPost){
        afficherArticles($unPost);
    }
            
    

?>
