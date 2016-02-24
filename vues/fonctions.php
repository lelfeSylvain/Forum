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
    echo "<article class=' article '>";
    echo "<span class='titrepost'>".$unPost['titre']."</span>".EOL;
    afficherCorpsArticle($unPost);
    
}

function afficherCorpsArticle($unPost,$estActuelle=0){
    echo "".$unPost['corps'].EOL;
    if (!$estActuelle) {
        echo "<span class='textpetit'>rédigé par <span class='auteurpost'>".$unPost['pseudo']."</span>";
        echo ", le : ".$unPost['tsCreation'];
        if ($unPost['codeEtat']>2){
                echo ", ".$unPost['lib']." le ".$unPost['tsDerniereModif'];
        }
        echo "</span>".EOL;
        echo "<a href='index.php?uc=creer&quoi=post&num=".$unPost['pnum']."'>répondre à cet article</a>";
    }
    echo "</article>";
}
	

	
/** Affiche la rubrique avec un hyperlien sur la rubrique,
 *  si $estActuelle est vrai alors c'est la rubrique actuelle
 * 
 * @param type $uneRub le titre de la rubrique à afficher
 * @param type $estActuelle faut-il mettre un lien hypertexte (oui par défaut)
 */
function afficherRubrique($uneRub,$estActuelle=0){
    if (!$estActuelle) {
        echo "<article  class='rubrique incluse'>".EL;
    }
    else {
       echo "<article  class='rubrique '>".EL; 
    }
    echo "<article  class='enteteRubrique'>".EL;
    
    if (!$estActuelle) {
        echo "<a href='index.php?uc=lecture&num=".$uneRub['pnum']."'>";
    }
   
    echo $uneRub['titre'];
    if (!$estActuelle) {
        echo "</a></article>".EL;// fin entete rubrique
    }    
    else {
        echo "</article>".EL;// fin entete rubrique
        if ($uneRub['corps']!="") {
            echo "<article class='corpsRubrique'>";
            afficherCorpsArticle($uneRub,$estActuelle);
        }
    }
    if (!$estActuelle) {echo "</article> ".EL;}
    
}



?>
