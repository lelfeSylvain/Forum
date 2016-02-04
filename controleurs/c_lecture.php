<?php
	if ($_REQUEST['num']=="tout" or !is_numeric($_REQUEST['num'])) {
		$lesPosts = $pdo->getToutesLesRubriques();
	}
	else {
		$lesPosts = $pdo->getTousLesPosts($_REQUEST['num']);
	}
	include 'vues/v_posts.php';
	







?>
