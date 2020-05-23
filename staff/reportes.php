<?php
require_once ('../session.php');
require_once ('../db.php');
require_once ('../functions.php');

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
			<li class="nav-item">
				<a class="nav-link" href="index.php">Inicio</a>
			</li>
			<li class="nav-item active">
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
<?php include '../comunes/verificar.php';  //Función para generar código de verificación y/o caonfirmar si el user está registrado
	  require ('validate_reportes.php');   //PHP usado para verificar la cuenta del usuario
?>

	<div style="display:none;" class="dialog" title="Próximamente">
		<p>Estamos trabajando para poder ofreceros más y nuevas ventajas, cuando esté disponible se avisará vía foro.</p>
		<p>Att: El equipo de administración</p>
	</div>
	<hr>
	<div class="row"><!-- Título de la página-->
		<div class="col-sm-12">
			<h2 class="text-center" style="color:orange">Reportes</h2>
		</div>
	</div>
	<hr>


	<!--Inicio reportes -->
	
	<?php //PHP usado para mostrar el formulario de los reportes
	if(isset($_GET['id'])){
		$Request = getReporte($_GET['id']);
		if($Request['Estado'] != NULL && $Request['Id'] != NULL){//ERROR ArrayOutOfBound Arreglar
			echo '<div id="reportes-info" class="modal">
		<div class="d-flex justify-content-center align-items-center">
			<div id="info_user" class=" card col-sm-8"><!--d-none -->
			<span id="boton_cerrar" class="cerrar" title="Cerrar">&times;</span>
				<div class="card-header">
				<h4 id="info_user_title" class="text-center" style="color:orange">Reporte sobre '.$Request['Reportado'].'</h4>
				</div>
				<div class="card-content">
				<br>
					<form class="form" action="'.$_SERVER['PHP_SELF'].'?id='.$Request['Id'].'" method="POST">
						<div class="form-inline">
							<label class="col-sm-2" for="reportante ">Reportante:</label>
							<input name="reportante" type="text" class="form-control mb-2 col-sm-12" value="'.$Request['Reportante'].'" readonly/>
						</div>
						<div class="form-inline">
							<label for="hora_in ">Hora:</label>
							<input name="hora_in" type="text" class="form-control mb-2 col-sm-12" value="'.$Request['Dia_In'].'" readonly/>
						</div>
						<div class="form-inline">
							<label for="staff ">Resuelto por:</label>
							<input name="staff" type="text" class="form-control mb-2 col-sm-12" value="'.$Request['Resueltopor'].'" readonly/>
						</div>
						<div class="form-inline">
							<label for="motivo ">Motivo:</label>
							<input name="motivo" type="text" class="form-control mb-2 col-sm-12" value="'.$Request['Motivo'].'" readonly/>
						</div>
						<div class="form-inline">
							<label for="pruebas ">Pruebas:</label>
							<textarea name="pruebas" class="form-control mb-2 col-sm-12" rows="2" readonly>'.$Request['Pruebas'].'</textarea>
						</div>
						<div class="form-inline">
							<label class="mr-sm-4" for="comentarios_staff "><strong>Comentarios Staff:</strong></label>
							<textarea name="comentarios_staff" class="form-control mb-2 col-sm-8" rows="2">'.$Request['Comentarios_staff'].'</textarea>
						</div>
						<div class="form-inline">
							<label class="mr-sm-4" for="comentarios_user "><strong>Comentarios User:</strong></label>
							<textarea name="comentarios_user" class="form-control mb-2 col-sm-8" rows="2" required>'.$Request['Comentarios_user'].'</textarea>
							
						</div>
						<div class="form-group">
							<button type="submit" name="aprobar" class="btn btn-success mt-sm-2">Aprobar</button>
							<button type="submit" name="rechazar" class="btn btn-danger mt-sm-2">Rechazar</button>';
							
						if(isAdmin($_SESSION['User'])) {
							echo '<button type="submit" name="eliminar" class="btn btn-warning mt-sm-2 ml-sm-1">Eliminar</button>';
						}
						echo '
						</div>
					</form>
				</div>
			<hr>
			</div>
		</div>
		</div>';
		}
	}
	?>

	<div class="row mt-sm-4 mb-sm-4"><!-- Usado para ordenar los reportes segun algunos datos -->
		<div class="col">
			<div class="dropdown float-left">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Ordenar por:</button>
					<div class="dropdown-menu">
					  <a class="dropdown-item" href="reportes.php?order=Reportante">Reportante</a>
					  <a class="dropdown-item" href="reportes.php?order=Reportado">Reportado</a>
					  <a class="dropdown-item" href="reportes.php?order=Staff">Staff</a>
					  <a class="dropdown-item" href="reportes.php?order=Motivo">Sanción</a>
					  <a class="dropdown-item" href="reportes.php?order=Estado">Estado</a>
					</div>
			  </div>
		</div>
		<p class="float-right">Numero de reportes: <?php echo $reportes;?></p>
	</div>
	<div class="row"><!-- Usado para con jquery buscar dentro de la tabla-->
		<form class="col form-inline mb-sm-4">
			<input class="form-control mr-sm-2" id="buscar" type="search" placeholder="Buscar">
		</form>
	</div>
	<?php 		
		$Select='Reportante';//Ordenar datos del los usuarios mediante GET default --> Reportante
		if(isset($_GET['order'])){
			if($_GET['order']=='Reportado'||$_GET['order']=='Reportante'||$_GET['order']=='Motivo'||$_GET['order']=='Resueltopor'||$_GET['order']=='Estado'){
				$Select=$_GET['order'];
			}
		}
		
	$sql = 'SELECT * FROM reportes ORDER BY '.$Select.'';
	if($result = $con->query($sql)){
		if($result->num_rows>0){
			echo'<table id="reportes_table" class="table table-striped table-hover">
				<thead class="thead-dark">
				  <tr>
					<th>Reportante</th>
					<th>Reportado</th>
					<th>Motivo</th>
					<th>Resuelto Por</th>
					<th>Editar</th>	
				  </tr>
				</thead>
				<tbody id="reportes">';
			while($row = $result->fetch_array()){
				if($row['Estado']=='resuelto'){$EstadoDisplay='Resuelto';$ColorRow='table-success';}else if($row['Estado']=='rechazado'){$EstadoDisplay='Rechazado';$ColorRow='table-danger';}
					else{$EstadoDisplay='Esperando';$ColorRow='table-warning';}//Colores de las tablas según el estado del reporte
					
					echo '<tr id="'.$row['Id'].'" class="'.$ColorRow.'">';
					echo '<td>'.$row['Reportante'].'</td>';
					echo '<td>'.$row['Reportado'].'</td>';
					echo '<td>'.$row['Motivo'].'</td>';
					echo '<td>'.$row['Resueltopor'].'</td>';
					echo '<td><a id="'.$row['Id'].'" href="reportes.php?id='.$row['Id'].'"><i class="fas fa-pen" style="color:black;"></i></a></td>';
					echo '</tr>';
			}
		}else{
			echo '<div class="alert alert-success">No se ha encontrado ningún reporte</div>';
		}
	}?>
	</tbody>
	</table>
	<br>
</div>
<script>
$(document).ready(function(){//Jquery de la búsqueda en reportes
	$("#buscar").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#reportes tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$("#boton_cerrar").on('click', function () {//Jquery para cerrar el modal de reportes
		$("#reportes-info").hide();
	});

	$(".proximamente").click(function (e) { 
		$(function() {
			$(".dialog").dialog();
		});
	});
});



</script>
</script>
</script>

</body>
</html>