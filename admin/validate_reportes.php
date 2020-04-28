<?php 
if(isset($_POST['aprobar'])){
		if(isset($_GET['id'])){
			$Result = GetId($_GET['id'],$con);
			if($Result[5]!='resuelto'){
				if($stm = $con->query("UPDATE reportes SET Estado='resuelto',Resueltopor='".$_SESSION['User']."',Comentarios_staff='".$_POST['comentarios_staff']."',
									 Dia_out=NOW(), Dia_out=NOW(),Comentarios_user='".$_POST['comentarios_user']."'
									 WHERE id=".$_GET['id']."")){}
				if($stm = $con->query("INSERT INTO log (User,Action,Time) VALUES ('".$_SESSION['User']."',
										'Aceptar reporte ".$_GET['id']."',NOW())")){
					header ('location: reportes.php');}
			}else{
				echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
					Este reporte ya ha sido aceptado por '.$_POST['staff'].'</div>';
			}
		}else{
			echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
					Hubo un problema al validar los datos intentalo más tarde</div>';
		}
	}else if(isset($_POST['rechazar'])){
		if(isset($_GET['id'])){
			$Result = GetId($_GET['id'],$con);
			if($Result[5]!='rechazado'){
				if($stm = $con->query("UPDATE reportes SET Estado='rechazado',Resueltopor='".$_SESSION['User']."',
									Comentarios_staff='".$_POST['comentarios_staff']."', Comentarios_user='".$_POST['comentarios_user']."'
									WHERE id=".$_GET['id']."")){}
				if($stm = $con->query("INSERT INTO log (User,Action,Time) VALUES ('".$_SESSION['User']."',
										'Rechazar reporte ".$_GET['id']."',NOW())")){
					header ('location: reportes.php');}
			}else{
				echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
					Este reporte ya ha sido rechazado por '.$_POST['staff'].'</div>';
			}
		}else{
			echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
					Hubo un problema al validar los datos intentalo más tarde</div>';
		}
	}else if(isset($_POST['eliminar'])){
		if(isset($_GET['id'])){
			$Result = GetId($_GET['id'],$con);
				if($stm = $con->query("DELETE FROM reportes WHERE id=".$_GET['id']."")){}
				if($stm = $con->query("INSERT INTO log (User,Action,Time) VALUES ('".$_SESSION['User']."',
										'Reporte ".$_GET['id']." eliminado',NOW())")){
					header ('location: reportes.php');}
		}else{
			echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
					Hubo un problema al validar los datos intentalo más tarde</div>';
		}
	}else if(isset($_POST['cancelar'])){
		header ('location: reportes.php');
	}
?>