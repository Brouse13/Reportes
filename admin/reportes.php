<?php
require_once('../session.php');
require_once '../db.php';

require ('functions_reportes.php');
?>
<!DOCTYPE html>
<html>
<?php include '../comunes/header.php'; ?>
<body>
<?php 
require ('validate_reportes.php');
?>
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
		<li class="nav-item">
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
		<li class="nav-item active">
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
			<h2 class="text-center" style="color:orange">Reportes</h2>
		</div>
	</div>
	<hr>
	<!--Inicio reportes -->
	<?php 
	if(isset($_GET['id'])){
	Fillform($_GET['id'],$con);}
	?>
	<div class="row mt-sm-4 mb-sm-4">
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
		<p class="float-right">Numero de reportes: <?php echo $count;?></p>
	</div>
	<div class="row">
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
});
</script>
</body>
</html>