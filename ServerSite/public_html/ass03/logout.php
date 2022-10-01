<?php 
    session_start();
    $_SESSION = [];
    session_destroy();
    echo "ihrfirh";
	unset($_SESSION['user']);
	header("location: index.php");
?>