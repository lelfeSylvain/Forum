<?php 
    include 'inc/class.Session.php'; Session::init();

    Session::logout();
    header('Location: login.php');
?>
