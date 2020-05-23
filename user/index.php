<?php
require_once ('../session.php');
require_once ('../db.php');
require_once ('../functions.php');

$Rango = getRango($_SESSION['User']);

$Count = myReports($_SESSION['User']);

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
			<li class="nav-item active">
			<a class="nav-link" href="index.php">Inicio</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="reportar.php">Reportar</a>
			</li>
			<li class="nav-item">
			<a class="nav-link proximamente" href="#">Apelalar</a>
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
	<div style="display:none;" class="dialog" title="Próximamente">
		<p>Estamos trabajando para poder ofreceros más y nuevas ventajas, cuando esté disponible se avisará vía foro.</p>
		<p>Att: El equipo de administración</p>
	</div>

	<?php include '../comunes/verificar.php';  //Función para generar código de verificación y/o caonfirmar si el user está registrado?>
	<div class="row mt-sm-4">
		<div class="col-sm-12">
			<h3 style="color:orange"><?php echo 'Hola de nuevo '.$Rango.' '.$_SESSION['User'];?></h3><!--Hola de nuevo $Rango $Nombre-->
		</div>
	</div>
	<hr>
	<!-- Inicio del body-->

	<div class="row"><!--Número total de reportes-->
		<h4 class="col">Tus reportes: <?php echo $Count; ?></h4>
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
						if($row['Resueltopor'] == NULL) {
                            $resuelto_por = "<b>Sin resolver</b>";
                        }else {
                            $resuelto_por = $row['Resueltopor'];
                        }
						echo '<tr id="'.$row['Id'].'" class="'.$ColorRow.'">';
						echo '<td>'.$row['Reportado'].'</td>';
						echo '<td>'.$row['Motivo'].'</td>';
						echo '<td>'.$resuelto_por.'</td>';
						echo '<td><textarea name="comentarios_staff" class="form-control col-sm-11" rows="2" readonly>'.$row['Comentarios_user'].'</textarea></td>';
						echo '</tr>';
				}
			}
		}?>
		</tbody>
		</table>
	</div>
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