 <form method="post" action="index.php?uc=inscrire">
    Pour s'inscrire : <br>
    Votre pseudo : <input type="text" name="login" value="<?php echo $pseudo; ?>"> <br>
    Mot de passe : <input type="password" name="password1" value="<?php echo $mdp1; ?>"><br>
    Mot de passe : <input type="password" name="password2" value="<?php echo $mdp2; ?>">
    <input type="submit" value="Inscription" onClick="v_inscrire()">
  </form>
