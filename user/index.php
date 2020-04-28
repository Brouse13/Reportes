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
$count=0;
if($stm = $con->prepare('SELECT * FROM reportes WHERE Reportante=?')){//Método para obtener el número de reportes
	$stm->bind_param('s',$_SESSION['User']);
	$stm->execute();
	$stm->store_result();
	$count= $stm->num_rows();
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
		  <a class="nav-link" href="reportes.php">Reportar</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="apelaciones.php">Apelalar</a>
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

	<div class="row"><!--Número total de reportes-->
		<h4 class="col">Tus reportes: <?php echo $count; ?></h4>
	</div>

	<div class="mt-sm-4"><!--Lista de todos tus reportes con query de sql-->
		<?php
		$sql = 'SELECT * FROM reportes WHERE Reportante="'.$_SESSION['User'].'"';
		if($result = $con->query($sql)){
			if($result->num_rows>0){
				echo'<table id="reportes_table" class="table table-striped table-hover">
					<thead class="thead-dark">
					<tr>
						<th>Reportado</th>
						<th>Motivo</th>
						<th>Resuelto Por</th>
						<th>Comentarios</th>	
					</tr>
					</thead>
					<tbody id="reportes">';
				while($row = $result->fetch_array()){
					if($row['Estado']=='resuelto'){$EstadoDisplay='Resuelto';$ColorRow='table-success';}else if($row['Estado']=='rechazado'){$EstadoDisplay='Rechazado';$ColorRow='table-danger';}
						else{$EstadoDisplay='Esperando';$ColorRow='table-warning';}//Colores de las tablas según el estado del reporte
						
						echo '<tr id="'.$row['Id'].'" class="'.$ColorRow.'">';
						echo '<td>'.$row['Reportado'].'</td>';
						echo '<td>'.$row['Motivo'].'</td>';
						echo '<td>'.$row['Resueltopor'].'</td>';
						echo '<td><textarea name="comentarios_staff" class="form-control col-sm-11" rows="3" readonly>'.$row['Comentarios_user'].'</textarea></td>';
						echo '</tr>';
				}
			}
		}?>
		</tbody>
		</table>
	</div>
</div>
</body>
</html>