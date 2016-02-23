<?php
    echo "<p>Vous venez d'enregistrer un";
    if ($estRub) {
        echo "e nouvelle rubrique :</p>";
        afficherRubrique($unPost);
    }
    else {
        echo " nouvel article : </p>";
        afficherArticle($unPost);
    }
    



