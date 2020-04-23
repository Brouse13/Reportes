<?php
require_once('../session.php');
?>
<!DOCTYPE html>
<html>
<?php include 'comunes/header.php'; ?>
<body>
<div class="container">
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
		<li class="nav-item dropdown">
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
		  <a class="nav-link" href="reportes.php">Reportes</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="apelaciones.php">Apelaciones</a>
		</li>
	</ul>
</nav>
	<hr>
	<div class="row">
		<div class="col-sm-12">
			<h2 class="text-center" style="color:orange">Admin</h2>
		</div>
	</div>
	<hr>
	<!-- -->
</div>
</body>
</html>