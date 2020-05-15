<?php
session_start();	
	require_once 'db.php';
	$Username = $Password = '';
	
	if($_SERVER["REQUEST_METHOD"]=='POST'){

		if(isset($_POST['usr'],$_POST['pss'])){
		$Username= $_POST['usr'];
		$Password= $_POST['pss'];
		
			if($stm = $con->prepare('SELECT Id,Password,Type FROM users WHERE Username= ?')){
				$stm->bind_param('s',$_POST['usr']);
				$stm->execute();
				$stm->store_result();
				
				if($stm->num_rows>0){
					
					$stm->bind_result($Id, $Password, $Type);
					$stm->fetch();

					if(password_verify($_POST['pss'],$Password)){
						session_regenerate_id();
						$_SESSION['Logged'] = true;
						$_SESSION['Id'] = $Id;
						$_SESSION['User'] = $usr;
						$_SESSION['Type'] = $Type;
						
						if($_SESSION['Type']=='admin'){
							header('Location: admin/index.php');
						}else if($_SESSION['Type']=='staff'){
							header('Location: staff/index.php');
						}else{
							header('Location: user/index.php');
						}

					}else if(strlen($Password) == 8 && $Password == $_POST['pss']){
						$new_pass = password_hash($Password, PASSWORD_DEFAULT);

						$insert_new_pass = $con->query('UPDATE users SET Password="'. $new_pass .'" WHERE Username= "'. $_POST['usr'] .'"');

						session_regenerate_id();
						$_SESSION['Logged'] = true;
						$_SESSION['Id'] = $Id;
						$_SESSION['User'] = $usr;
						$_SESSION['Type'] = $Type;
						
						if($_SESSION['Type']=='admin'){
							header('Location: admin/index.php');
						}else if($_SESSION['Type']=='staff'){
							header('Location: staff/index.php');
						}else{
							header('Location: user/index.php');
						}
					}else{
					$_SESSION['error']='fail_login';header ('location: index.php');
					}

				}else{
					$_SESSION['error']='fail_login';header ('location: index.php');
				}
			}
		}else{header("Location: index.php");}
	}

?>
