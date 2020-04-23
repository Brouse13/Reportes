<?php
	session_start();
	if($_SESSION['Logged']==true){
		$Type = $_SESSION['Type'];
		if(!strpos($_SERVER['PHP_SELF'],$Type)){
			header('location:http://www.localhost/reportes/'.$Type.'/index.php');
			exit();
		}
	}else{
		header('location:http://www.localhost/reportes/index.php');
	}
?>