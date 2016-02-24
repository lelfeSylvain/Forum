<?php


// on affiche la référence à un niveau supérieur
echo "<nav class='ariane'>";
if ($rubriqueActuelle==1) {
    echo "vous êtes au plus haut niveau";
}
else {
    echo "<a href='index.php?uc=lecture&num=".$rubriqueMere."'>remonter au niveau supérieur</a>";
}
echo "</nav>";
