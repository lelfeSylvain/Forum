                
		<footer id="footer" role="contentinfo" class="line ptm txtcenter mal ">
			<?php  
				if (Session::isLogged()) {
					echo $_SESSION['username'] ." alias ".$_SESSION['prenom']." ". $_SESSION['nom'];
					//if ($_REQUEST['uc']!='rec') 
						echo "<br /><a href='index.php?uc=lecture&num=tout' class='textgros'>Retourner à l'accueil</a> - ";
					echo "<a href='logout.php'>Déconnexion</a> <br />\n";
				}
				else {// non loggé
					echo "<br /><a href='index.php?uc=lecture' class='textgros'>Retourner au forum</a>";
				}
			?>
		</footer>

	</body>
</html>
