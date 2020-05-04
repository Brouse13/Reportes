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
?>
<!DOCTYPE html>
<html>
<?php include '../comunes/header.php'; ?>
<body>
<div class="container">
<?php include '../comunes/verificar.php';  //Función para generar código de verificación y/o caonfirmar si el user está registrado
	if(isset($_SESSION['error'])){
		if($_SESSION['error'] == 'not_verified'){
			echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
					Para poder reportar a un usuario tu cuenta tiene que estar verificada</div>';
		}else if($_SESSION['error'] == 'user_null'){
			echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
					El usuario al que reportaste no existe o no ha entrado al servidor</div>';
		}
		$_SESSION['error'] = null;
	}else if(isset($_SESSION['success'])){
		echo '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
				Gracias por reportar y hacer que esta comunidad mejore</div>';
		$_SESSION['success'] = null;
	}



?>
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
		<li class="nav-item">
		  <a class="nav-link active" href="reportar.php">Reportar</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="#">Apelalar</a>
		</li>
	</ul>
</nav>
	<hr>
	<!-- Inicio del body-->

    <div><!-- Formulario para crear nuevos reportes-->
    <div class="d-flex justify-content-center align-items-center">
		<div id="info_user" class=" card col-sm-8"><!--d-none -->
			<div class="card-header">
			<h4 id="info_user_title" class="text-center" style="color:orange">Reportar a un usuario</h4>
			</div>
			<div class="card-content">
			<br>
				<form class="form" action="validate_reportar.php?reportante=<?php echo $_SESSION['User']; ?>" method="POST">
					<div class="form-inline">
						<label for="reportado ">Reportado:</label>
						<input name="reportado" id="reportado" type="text" class="form-control mb-2 col-sm-12" placeholder="Brouse_13" required/>
					</div>

					<div class="form-group"><!--Selector de sanciones con id para que jquery lo reconozca -->
						<label for="sanciones">Relación de la sanción</label>
						<select name="sanciones" id="sanciones" class="form-control" required>
						<option>Selecciona una relación</option>
						<option value="chat">Chat</option>
						<option value="juego">Jugabilidad</option>
						</select>
					</div>
					<div class="form-group" id="chat"><!--Selector de sanciones sobre el chat -->
						<label for="chat">Chat</label>
						<select name="chat" class="form-control">
						<option value="">Selecciona un motivo válido</option>
						<option value="flood">Flood</option>
						<option value="spam">Spam</option>
						<option value="vocabulario_inadecuado">Vocabulario inadecuado</option>
						<option value="amenazas">Amenazas</option>
						<option value="discriminacion">Discriminación</option>
						<option value="insultos_jugador">Insultos a un jugador</option>
						<option value="insultos_staff">Insultos al staff</option>
						<option value="mencionar_servidores">Mencionar servidores</option>
						<option value="contenido_inadecuado">Contenido inadecuado</option>
						<option value="información_privada">Pasar información privada</option>
						<option value="mentir_uso_comandos">Mentir sobre el uso de comandos</option>
						<option value="hacerse_pasar_staff">Hacerse pasar por un staff</option>
						<option value="nick_inapropiado">Nick inapropiado</option>
						<option value="incitar_romprer_reglas">Incitar a romper las reglas</option>

						</select>
					</div>
					<div class="form-group" id="juego"><!--Selector de las sanciones sobre el juego -->
						<label for="juego">Jugabilidad</label>
						<select name="juego" class="form-control">
						<option value="">Selecciona un motivo válido</option>
						<option value="hacks">Uso de hacks</option>
						<option value="clientes_ilegales">Uso de clientes ilegales</option>
						<option value="abuso_bugs">Abuso de bugs</option>
						<option value="prestar_servicios">Prestar servicios Vip</option>
						<option value="tpakill">Tpakill</option>
						<option value="fly_combate">Fly en combate</option>
						<option value="estafa de rango">Estafa de rango</option>
						<option value="grifeo">Grifeo</option>
						<option value="skin_inadecuada">Skin inadecuada</option>
						<option value="construcciones_obscenas">Construcciones obscenas</option>
						<option value="causar_lag">Causar lag</option>
						<option value="objetos ilegales">Tener objetos ilegales</option>
						<option value="afk_lobby_moba">Quedarse afk en el lobby de mobarena</option>
						<option value="afk_partida_moba">Quedarse afk en la partida de mobarena</option>
						<option value="afk_skyblock">Quedarse afk en skyblock</option>
						</select>
					</div>
					<div class="form-inline">
						<label for="pruebas ">Pruebas:</label>
						<textarea name="pruebas" class="form-control mb-2 col-sm-12" rows="3" maxlength="1000" placeholder="Para subir pruebas has de usar páginas como imgur o subefotos"required></textarea>
					</div>

					<div class="form-group">
						<button type="submit" id="enviar" class="btn btn-success mt-sm-2">Enviar</button>
						<button type="reset" class="btn btn-primary mt-sm-2">Cancelar</button>
					</div>
				</form>
			</div>
		<hr>
		</div>
	</div>

    </div>
</div>

<script>

function hide_sanciones(){
	$("#chat").hide();//Esconder div con sanciones survival
	$("#juego").hide();//Esconder div con sanciones skyblock
}

$(document).ready(function() {
	hide_sanciones();

  $('#sanciones').on('change', function() {//Funció Jquery para mostrar reportes
    var value = $(this).val();//Capturar valor del option

	if(value=='juego'){
		hide_sanciones();
		$('#juego').show();
	}else if(value=='chat'){
		hide_sanciones();
		$('#chat').show();
	}
    
  });
});


$(function() {
    $("#reportado").autocomplete({
        source: "../comunes/buscar.php?",
		select: function( event, ui ) {
            event.preventDefault();
            $("#reportado").val(ui.item.value);
        }
    });
});
</script>

</body>
</html>