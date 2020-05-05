<?php
require('../session.php');
require('../db.php');

if($stm = $con->prepare('SELECT Rango FROM users WHERE Username=?')){//Método para obtener rango del propietario de la sesión
	$stm->bind_param('s',$_SESSION['User']);
	$stm->execute();
	$stm->store_result();
	$stm->bind_result($Rango);
	$stm->fetch();
}
$reportes=0;
if($stm = $con->prepare('SELECT * FROM reportes WHERE Estado="esperando"')){//Método para obtener el número de reportes
	$stm->execute();
	$stm->store_result();
	$reportes= $stm->num_rows;
}
?>
<!DOCTYPE html>
<html>
<?php include '../comunes/header.php'; ?>
<body>
<div class="container">
<?php include '../comunes/verificar.php';  //Función para generar código de verificación y/o caonfirmar si el user está registrado?>
<nav class="navbar navbar-expand-xl bg-dark navbar-dark">
	<ul class="navbar-nav mr-auto">
		<li class="nav-item dropdown active">
		  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown"><?php echo 'Hola '.$_SESSION['User'];?></a>
		  <div class="dropdown-menu">
			<a class="dropdown-item" href="#">Cuenta</a>
			<a class="dropdown-item" href="#">Cambiar contraseña</a>
			<a class="dropdown-item" href="../logout.php">Salir</a>
		  </div>
		</li>
		<li class="nav-item active">
		  <a class="nav-link" href="index.php">Inicio</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="reportes.php">Reportes</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="#">Apelaciones</a>
		</li>
	</ul>
</nav>
	<hr>
	<div class="row">
		<div class="col-sm-12">
			<h3 style="color:orange"><?php echo 'Hola de nuevo '.$Rango.' '.$_SESSION['User'];?></h3><!--Hola de nuevo $Rango $Nombre-->
		</div>
	</div>
	<hr>
	<!-- Inicio del body-->

	<div class="mt-sm-4"><!--Información de si hay nuevos reportes a atender con query de sql-->
		<?php
		if($reportes == 0){
			echo '<div class="alert alert-success">No tienes ningún reporte a responder :D</div>';
		}else{
			echo '<div class="alert alert-info">Tienes '.$reportes.' nuevos reportes a atender</div>';
		}
		?>
	</div>
</div>
</body>
</html>