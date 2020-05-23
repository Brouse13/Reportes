<?php
require_once ('../session.php');
require_once ('../db.php');
require_once ('../functions.php');

?>
<!DOCTYPE html>
<html>
<?php include '../comunes/header.php'; ?>
<body>

<nav class="navbar navbar-expand-xl bg-dark navbar-dark"><!-- Navbar -->
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link" href="index.php">Inicio</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="reportar.php">Reportar</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="apelar.php">Apelalar</a>
			</li>
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
</nav><!-- Fin de la navbar -->

<div class="container">
	<!-- Formulario para apelar tu sanción-->
	<div class="d-flex justify-content-center align-items-center mt-sm-4">
		<div id="info_user" class=" card col-sm-8"><!--d-none -->
			<div class="card-header">
			<h4 id="info_user_title" class="text-center" style="color:orange">Apela tu sanción</h4>
			</div>
			<div class="card-content">
			<br>
				<form id="proximamente" class="form" action="validate_apelacion.php?user=<?php echo $_SESSION['User']; ?>" method="POST">
					<div class="form-inline">
						<?php echo '<img src="https://cravatar.eu/helmhead/'. $_SESSION['User'] .'/85.png" alt="Skin">'; ?>
						<input class="form-control ml-sm-4 col-sm-10" type="text" name="id_baneo" id="id_baneo" placeholder="ID del baneo" required>
					</div>
					<div class="form-group"><!--Selector de sancion con id para que jquery lo reconozca -->
						<label for="sancion">Sanción:</label>
						<select name="sancion" id="sancion" class="form-control" required>
						<option value=""></option>
						<option>Warn</option>
						<option>Kick</option>
						<option>Muteo</option>
						<option>Ban</option>
						</select>
					</div>

					<div class="form-group" id="chat"><!--Ejecutor de la sanción -->
						<label for="staffs">Ejecutor de la sanción:</label>
						<select name="staffs" id="sancion" class="form-control" required>
						<option value=""></option>
						<?php
							foreach (getStaffs() as $staff) {
								echo '<option>'. $staff .'</option>';
							}
						?>
						</select>
					</div>
					<div class="form-inline">
						<label for="pruebas ">Explicaión:</label>
						<textarea name="pruebas" class="form-control mb-2 col-sm-12" rows="3" maxlength="1000" placeholder="Explicación del motivo por el que crees que es una sanción mal ejecutada"required></textarea>
					</div>

					<div class="form-group">
						<button type="submit" id="enviar" class="btn btn-success mt-sm-2">Enviar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
</body>
</html>