<?php 
    include 'inc/class.Session.php'; Session::init();
    include 'inc/class.PDOForum.php'; 
    
    
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $pdo = PDOForum::getPdoForum();
        if ($rep = $pdo->getInfoUtil($_POST['login'])) {// si j'ai une réponse du modèle
            if (Session::login($_POST['login'], $_POST['password'], $rep['pseudo'], $rep['mdp'])){
                $_SESSION['nom'] = $rep['nom'];
                $_SESSION['prenom'] = $rep['prenom'];
                $_SESSION['tsDerniereCx'] = $rep['tsDerniereCx'];
                $_SESSION['numUtil'] = $rep['num'];
                $pdo->setDerniereCx($rep['num']);
                header('Location: index.php');
                
            }
        }
        
    }
?>
<html>
  <head><title>Login</title></head>
  <body>
    <form method="post" action="login.php">
      Please login:<br>
      Login : <input type="text" name="login"> <br>
      Password : <input type="password" name="password">
      <input type="submit" value="Login">
    </form>
  </body>
</html>