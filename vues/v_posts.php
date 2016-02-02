<?php

	// fonction affichant un article passé en paramètre
	function afficherArticle($unPost){
		echo "<b><big>".$unPost['titre']."</big></b>";
		echo " - <b>".$unPost['pseudo']."</b><br />\n";
		echo "".$unPost['corps']."<br />\n";
		echo "rédigé le : ".$unPost['tsCreation'];
		if ($unPost['codeEtat']>2){
			echo ", modifié le ".$unPost['tsDerniereModif']."<br />";
		}
	}
	
	// fonction affichant une rubrique
	function afficherRubrique($uneRub){
		echo "<b><big><big>".$uneRub['titre']."</big></big></b>";
		echo "<br />\n";
		
	}
	
	
	
	// suite du code
	foreach($lesPosts as $unPost){
		if  ($unPost['estRubrique']>0){// c'est une rubrique
			afficherRubrique($unPost);
		}
		else {
			afficherArticle($unPost);
		}
	}

?>
