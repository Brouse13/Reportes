<?php
require_once ('../session.php');
require_once ('../db.php');
require_once ('../functions.php');

$Rango = getRango($_SESSION['User']);

$reportes = noReplyReport();

?>
<!DOCTYPE html>
<html>
<?php include '../comunes/header.php'; ?>
<body>

<nav class="navbar navbar-expand-xl bg-dark navbar-dark"><!-- Navbar-->
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="index.php">Inicio</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="reportes.php">Reportes</a>
			</li>
			<li class="nav-item">
				<a class="nav-link proximamente" href="#">Apelaciones</a>
			</li>
			<?php 
			if (isAdmin($_SESSION['User'])) {
				echo '<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
				  Estadisticas
				</a>
				<div class="dropdown-menu">
				  <a class="dropdown-item" href="#">Admin</a>
				  <a class="dropdown-item" href="#">Staff</a>
				  <a class="dropdown-item" href="#">Users</a>
				</div>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="#">Logs</a>
			</li>';
			}
			?>
		</ul>
		<ul class="navbar-nav">
		<li class="nav-item dropdown active form-inline"><!-- Desplegable de la derecha del menu con el nombre...-->
				<a class="nav-link dropdown-toggle mr-sm-4" href="#" id="navbardrop" data-toggle="dropdown"><?php echo 'Hola '.$_SESSION['User'];?></a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">Cuenta</a>
					<a class="dropdown-item" href="#">Cambiar contraseña</a>
					<a class="dropdown-item" href="../logout.php">Salir</a>
				</div>
			</li>
		</ul>
		
	</div>
</nav><!-- Fin de la navbar-->

<div class="container">
<?php include '../comunes/verificar.php';  //Función para generar código de verificación y/o caonfirmar si el user está registrado?>
	<hr>
	<div class="row">
		<div class="col-sm-12">
			<h3 style="color:orange"><?php echo 'Hola de nuevo '.$Rango.' '.$_SESSION['User'];?></h3><!--Hola de nuevo $Rango $Nombre-->
		</div>
	</div>
	<hr>

	<div style="display:none;" class="dialog" title="Próximamente">
		<p>Estamos trabajando para poder ofreceros más y nuevas ventajas, cuando esté disponible se avisará vía foro.</p>
		<p>Att: El equipo de administración</p>
	</div>
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


<script>
$(".proximamente").click(function (e) { 
	$(function() {
    	$(".dialog").dialog();
 	 });
});
</script>
</body>
</html>