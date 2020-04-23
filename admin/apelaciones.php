<?php
require_once('../session.php');
require_once '../db.php';

require ('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reportes DragonballCreative Minecraft</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/c7b2024f07.js" crossorigin="anonymous"></script>

	
</head>
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
		<li class="nav-item">
		  <a class="nav-link" href="reportes.php">Reportes</a>
		</li>
		<li class="nav-item active">
		  <a class="nav-link" href="#">Apelaciones</a>
		</li>
	</ul>
</nav>
	<hr>
	<div class="row">
		<div class="col-sm-12">
			<h2 class="text-center" style="color:orange">Apelaciones</h2>
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
					  <a class="dropdown-item" href="reportes.php?order=Reportante">Reportado</a>
					  <a class="dropdown-item" href="reportes.php?order=Staff">Staff</a>
					  <a class="dropdown-item" href="reportes.php?order=Motivo">Sanción</a>
					  <a class="dropdown-item" href="reportes.php?order=Estado">Estado</a>
					</div>
			  </div>
			<p class="float-right">Numero de apelaciones: <?php echo $count;?></p>
		</div>
	</div>
	<div class="mb-4 col-sm-3 row">
	  <input id="buscar" class="form-control" type="text" placeholder="Buscar">
	</div>
	<?php 		
		$Select='Reportante';
		if(isset($_GET['order'])){
			if($_GET['order']=='Reportado'||$_GET['order']=='Reportante'||$_GET['order']=='Motivo'||$_GET['order']=='Resueltopor'||$_GET['order']=='Estado'){
				$Select=$_GET['order'];
			}
		}
		
	$sql = 'SELECT * FROM reportes ORDER BY '.$Select.'';
	if($result = $con->query($sql)){
		if($result->num_rows>0){
			echo'<table id="reportes" class="table table-hover">
				<thead class="thead-dark">
				  <tr>
					<th>Reportado</th>
					<th>Motivo</th>
					<th>Resuelto Por</th>
					<th>Editar</th>	
				  </tr>
				</thead>
				<tbody id="reportes" class="table-stripped table-hover">';
			while($row = $result->fetch_array()){
				if($row['Estado']=='resuelto'){$EstadoDisplay='Resuelto';$ColorRow='table-success';}else if($row['Estado']=='rechazado'){$EstadoDisplay='Rechazado';$ColorRow='table-danger';}
					else if($row['Estado']=='sin_resolver'){$EstadoDisplay='Esperando';$ColorRow='table-warning';}
					
					echo '<tr id="'.$row['Id'].'" class="'.$ColorRow.'">';
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
</div>
<script>
$(document).ready(function(){
  $("#buscar").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#reportes tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


$(document).ready(function() {
    $('#example').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ reportes por tabla",
            "zeroRecords": "No se han encontrado datos",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos disponibles",
            "infoFiltered": "(Filtrando _MAX_ datos)",
			"search": "Buscar",
			"oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
        }
    } );
} );
</script>
</body>
</html>