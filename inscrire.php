<?php 
    include 'inc/class.Session.php'; Session::init();
    include 'inc/class.PDOForum.php'; 
    include 'vues/v_entete.php';
    $pseudo = "";
    $mdp1 = "";
    $mdp2 = "";
    if (isset($_POST['login']) && isset($_POST['password1']) && isset($_POST['password2'])) {
		$pseudo = $_POST['login'];
    $mdp1 = $_POST['password1'];
    $mdp2 = $_POST['password2'];
        if ($mdp1 === $mdp2) { // les 2 mots de passe saisis sont identiques
			$pdo = PDOForum::getPdoForum();
			if (!$rep = $pdo->getInfoUtil($pseudo)) {// si j'ai une réponse du modèle
				// le pseudo n'est pas déjà utilisé
				if ($pdo->setNouveauUtil($pseudo,$mdp1)) {// enregistrement bien passé
					echo $pseudo." vous êtes correctement enregistré.";
					die();
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
?>
    <form method="post" action="inscrire.php">
      Pour s'inscrire : <br>
      Votre pseudo : <input type="text" name="login" value=<?php echo $pseudo; ?>> <br>
      Mot de passe : <input type="password" name="password1" value=<?php echo $mdp1; ?>><br>
      Mot de passe : <input type="password" name="password2" value=<?php echo $mdp2; ?>>
      <input type="submit" value="Login">
    </form>
<?php
	include 'vues/v_pied.php';
?> 

