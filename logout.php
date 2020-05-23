<?php
	session_start();
	if($_SESSION['Logged']==true){
		session_unset();
		$_SESSION['error']='success_exit';
		header ('location: index.php');
	}else{
		header('location: index.php');
	}
?>