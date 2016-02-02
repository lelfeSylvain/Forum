		<footer id="footer" role="contentinfo" class="line ptm txtcenter">
			<?php  
				if (Session::isLogged()) {
					echo $_SESSION['username'] ." alias ".$_SESSION['prenom']." ". $_SESSION['nom'];
					//if ($_REQUEST['uc']!='rec') 
						echo "<br /><a href='index.php?uc=lecture'><big>Retourner au forum</big></a> - ";
					echo "<a href='logout.php'>Déconnexion</a> <br />\n";
				}
			?>
		</footer>

	</body>
</html>
