<?php 
    $die=false;
	if (isset($_POST['login']) && isset($_POST['password1']) && isset($_POST['password2'])) {
		$pseudo = $_POST['login'];
		$mdp1 = $_POST['password1'];
		$mdp2 = $_POST['password2'];
        if ($mdp1 === $mdp2) { // les 2 mots de passe saisis sont identiques
			$pdo = PDOForum::getPdoForum();
            $rep = $pdo->getInfoUtil($pseudo);
			if (!$rep ) {// si je n'ai de réponse du modèle
				// le pseudo n'est pas déjà utilisé
				if ($pdo->setNouveauUtil($pseudo,$mdp1)) {// enregistrement bien passé
					echo $pseudo." vous êtes correctement enregistré.";
					echo "Voulez-vous vous <a href='index.php'>connecter</a> ?";
					$die=true;
				}
				else {
					echo "un problème est survenu lors de votre enregistrement. Nous sommes désolés.";
				}                
            }
			else { // pseudo déjà utilisé
				print "Ce pseudo est déjà utilisé";	
				$pseudo="";
			}
        
		} // 2 mots de passes
		else {// différents 
			print "Les 2 mots de passe saisis sont différents !";
			$mdp1="";$mdp2="";
		}
        
    }
	
   if (!$die) include ("vues/v_inscrire.php");

