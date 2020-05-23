<?php 
$estado = "resuelto";
if(isset($_POST['rechazar'])) {//Usado para obtener el tipo de acción que se ejecutará
	$estado = "rechazado";
}

if(isset($_POST['rechazar']) || isset($_POST['aprobar']) && isset($_GET['id'])){
	$Result = getReporte($_GET['id']);

	if($Result['Estado']=='esperando' || isAdmin($_SESSION['User'])){

		$reporte = $con->query("UPDATE reportes SET 
			Estado = \"". $estado ."\", 
			Resueltopor = \"". $_SESSION['User'] ."\", 
			Dia_out = NOW(), 
			Comentarios_staff = \"". $_POST['comentarios_staff'] ."\", 
			Comentarios_user = \"". $_POST['comentarios_user'] ."\" 
			WHERE Id = ". $_GET['id'] ."");

		$log = $con->query('INSERT INTO log (User,Action) VALUES ("'. $_SESSION['User'] .'", "Reporte '. $Result['Id'] .': '. $estado .'")');

		header ('location: reportes.php');
	}else{
		echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
			Este reporte ya ha sido atendido por <b>'.$_POST['staff'].'</b></div>';
	}
}else if(isset($_POST['eliminar']) && isset($_GET['id']) && isAdmin($_SESSION['User'])){
	$Result = getReporte($_GET['id']);

	$reporte = $con->query("DELETE FROM reportes WHERE id=".$_GET['id']."");
	
	$log = $con->query("INSERT INTO log (User,Action) VALUES ('".$_SESSION['User']."',
								'Reporte ".$_GET['id']." eliminado'");

	header ('location: reportes.php');
}

?>