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
		if ($entete) {
			echo pluriel($uneRub['nb'],"post");
		}
		echo "<br />\n";
		
	}
	
	// suite du code
	// array_shift ? dépile la première ligne du tableau
	foreach($lesPosts as $unPost){
		if  ($unPost['estRubrique']>0){// c'est une rubrique
			afficherRubriques($unPost,True);// avec l'entete 
		}
		else {
			afficherArticles($unPost);
		}
	}

?>
