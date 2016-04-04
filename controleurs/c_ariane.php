<?php

// gère le fil d'ariane
    if ($_REQUEST['num']=="tout" or !is_numeric($_REQUEST['num']) or !isset($_REQUEST['num'])) {
        $rubriqueMere=1;
        $rubriqueActuelle=1;
    }
    else {
        $rubriqueActuelle=$_REQUEST['num'];
        $rubriqueMere=$pdo->getRubriqueMere($rubriqueActuelle);
    } 

