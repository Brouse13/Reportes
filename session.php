<?php
	session_start();
	
	if($_SESSION['Logged']==true){
		$Type = $_SESSION['Type'];
		
		if(($Type == 'admin' || $Type == 'staff') && !strpos($_SERVER['PHP_SELF'], 'staff')) {
			header ('Location: http://localhost/reportes/staff/');
		}else if ($Type == 'user' && !strpos($_SERVER['PHP_SELF'], 'user')){
			header ('Location: http://localhost/reportes/user/');
		}
	}else{
		header('location:http://www.localhost/reportes/index.php');
	}
	
?>