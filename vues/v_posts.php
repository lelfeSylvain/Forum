<?php

	// fonction affichant un article passé en paramètre
	function afficherArticle($unPost){
		echo "<b><big>".$unPost['titre']."</big></b>";
		echo " - <b>".$unPost['pseudo']."</b><br />\n";
		echo "".$unPost['corps']."<br />\n";
		echo "rédigé le : ".$unPost['tsCreation'];
		if ($unPost['codeEtat']>2){
			echo ", ".$unPost['lib']." le ".$unPost['tsDerniereModif'];
		}
		echo "<br />\n";
	}
	
	// fonction affichant une rubrique
	function afficherRubrique($uneRub){
		echo "<b><big><big><a href='index.php?uc=lecture&num=".$uneRub['pnum']."'>";
		echo $uneRub['titre']."</a></big></big></b>";
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
