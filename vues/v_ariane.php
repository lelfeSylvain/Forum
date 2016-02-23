<?php

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
