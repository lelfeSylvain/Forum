<?php 

/** 
 * retourne la chaine $mot au pluriel si $n >1
 * @param type $n nombre d'occurence du mot
 * @param type $mot le mot à mettre au pluriel
 * @return type le mot éventuellement au pluriel
 */
function pluriel($n, $mot){
	if ($n>1) 
		return $n.' '.$mot."s ";
	else 
		return $n.' '.$mot." ";
}

 /** affiche un article passé en paramètre
  * 
  * @param type $unPost tableau de valeur correspondant à un seul article
  */
function afficherArticle($unPost){
    echo "<article class='mbs txtleft pas'>";
    echo "<span class='titrepost'>".$unPost['titre']."</span>".EOL;
    afficherCorpsArticle($unPost);
    
}

function afficherCorpsArticle($unPost){
    echo "".$unPost['corps'].EOL;
    echo "<span class='textpetit'>rédigé par <span class='auteurpost'>".$unPost['pseudo']."</span>";
    echo ", le : ".$unPost['tsCreation'];
    if ($unPost['codeEtat']>2){
            echo ", ".$unPost['lib']." le ".$unPost['tsDerniereModif'];
    }
    echo "</span>".EOL;
    echo "<a href='index.php?uc=creer&quoi=post&num=".$unPost['pnum']."'>répondre</a>";
    echo "</article>";
}
	

	
/** Affiche la rubrique avec un hyperlien sur la rubrique,
 *  si $estActuelle est vrai alors c'est la rubrique actuelle
 * 
 * @param type $uneRub le titre de la rubrique à afficher
 * @param type $estActuelle faut-il mettre un lien hypertexte (oui par défaut)
 */
function afficherRubrique($uneRub,$estActuelle=0){
    echo "<article  class='rubrique'>";
    if (!$estActuelle) {
        echo "<a href='index.php?uc=lecture&num=".$uneRub['pnum']."'>";
    }
    echo $uneRub['titre'];
    if (!$estActuelle) {
        echo "</a>";
    }    
    elseif ($uneRub['corps']!="") {
        echo "<article class='corpsRubrique'>";
        afficherCorpsArticle($uneRub);
    }
    echo "</article> ".EOL;
    
}



?>
