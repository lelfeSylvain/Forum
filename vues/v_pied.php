                
		<footer id="footer" role="contentinfo" class="line ptm txtcenter mal ">
			<?php  
                            if (Session::isLogged()) {
                                    echo $_SESSION['username'];
                                    if (isset($_SESSION['prenom']) or isset($_SESSION['nom'])) {
                                        echo " alias ".$_SESSION['prenom']." ". $_SESSION['nom'];
                                    }
                                    //if ($_REQUEST['uc']!='rec') 
                                            echo "<br /><a href='index.php?uc=lecture&num=tout' class='textgros'>Retourner à l'accueil</a> - ";
                                    echo "<a href='logout.php'>Déconnexion</a> <br />\n";
                            }
                            else {// non loggé : on ne fait rien
                            }
                            echo "<br /><p class='textgros'>Mini-Forum - <a href='http://etablissementbertrandeborn.net/'>BTS SIO BdeB</a> - <img src='https://licensebuttons.net/l/by-nc-sa/3.0/80x15.png' alt='cc-by-nc-sa' /></p>";
				
			?>
		</footer>

	</body>
</html>
