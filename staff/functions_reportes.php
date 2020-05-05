<?php
require_once('../session.php');
require_once '../db.php';

if($stm = $con->prepare('SELECT * FROM reportes')){
	$stm->execute();
	$stm->store_result();
	$count=$stm->num_rows;
}	
function GetId($Id,$con){
	if($stm = $con->prepare('SELECT Id,Reportado,Reportante,Motivo,Pruebas,Estado,Resueltopor,Dia_In,
							Dia_Out,Comentarios_staff,Comentarios_user FROM reportes WHERE Id=?')){
		$stm->bind_param('s',$Id);
		$stm->execute();
		$stm->store_result();
		$stm->bind_result($Id,$Reportado,$Reportante,$Motivo,$Pruebas,$Estado,$Resueltopor,$Dia_In,$Dia_Out,$Cmnts_staff,$Cmnts_user);
		$stm->fetch();
		return array($Id,$Reportado,$Reportante,$Motivo,$Pruebas,$Estado,$Resueltopor,$Dia_In,$Dia_Out,$Cmnts_staff,$Cmnts_user);
		//Id=0 Reportado=1 Reportante=2 Motivo=3
		//Pruebas=4 Estado=5 Resueltopor=6
		//Dia_In=7 Dia_out=8 Cmnts_staff=9 Cmnts_user=10
	}return null;
}	

function Fillform($Id,$con){
	$Request = GetId($Id,$con);
	if($Request[5]==NULL){
		return;
	}
	echo '<div class="d-flex justify-content-center align-items-center">
		<div id="info_user" class=" card col-sm-8"><!--d-none -->
			<div class="card-header">
			<h4 id="info_user_title" class="text-center" style="color:orange">Reporte sobre '.$Request[1].'</h4>
			</div>
			<div class="card-content">
			<br>
				<form class="form" action="'.$_SERVER['PHP_SELF'].'?id='.$Request[0].'" method="POST">
					<div class="form-inline">
						<label class="col-sm-2" for="reportante ">Reportante:</label>
						<input name="reportante" type="text" class="form-control mb-2 col-sm-12" value="'.$Request[2].'" readonly/>
					</div>
					<div class="form-inline">
						<label for="hora_in ">Hora:</label>
						<input name="hora_in" type="text" class="form-control mb-2 col-sm-12" value="'.$Request[7].'" readonly/>
					</div>
					<div class="form-inline">
						<label for="staff ">Resuelto por:</label>
						<input name="staff" type="text" class="form-control mb-2 col-sm-12" value="'.$Request[6].'" readonly/>
					</div>
					<div class="form-inline">
						<label for="motivo ">Motivo:</label>
						<input name="motivo" type="text" class="form-control mb-2 col-sm-12" value="'.$Request[3].'" readonly/>
					</div>
					<div class="form-inline">
						<label for="pruebas ">Pruebas:</label>
						<textarea name="pruebas" class="form-control mb-2 col-sm-12" rows="2" readonly>'.$Request[4].'</textarea>
					</div>
					<div class="form-inline">
						<label class="mr-sm-4" for="comentarios_staff "><strong>Comentarios Staff:</strong></label>
						<textarea name="comentarios_staff" class="form-control mb-2 col-sm-8" rows="2">'.$Request[9].'</textarea>
						<label class="mr-sm-4" for="comentarios_user "><strong>Comentarios User:</strong></label>
						<textarea name="comentarios_user" class="form-control mb-2 col-sm-8" rows="2">'.$Request[10].'</textarea>
					</div>

					<div class="form-group">
						<button type="submit" name="aprobar" class="btn btn-success mt-sm-2">Aprobar</button>
						<button type="submit" name="rechazar" class="btn btn-danger mt-sm-2">Rechazar</button>
						<button type="submit" name="cancelar" class="btn btn-primary mt-sm-2">Cancelar</button>
					</div>
				</form>
			</div>
		<hr>
		</div>
	</div>';
}
?>