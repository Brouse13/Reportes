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
			<li class="nav-item active">
			<a class="nav-link" href="reportar.php">Reportar</a>
			</li>
			<li class="nav-item">
			<a class="nav-link proximamente" href="#">Apelalar</a>
			</li>
		</ul>
		<ul class="navbar-nav">
			<li class="nav-item dropdown active form-inline mr-sm-4	"><!-- Desplegable de la derecha del menu con el nombre...-->
				<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown"><?php echo 'Hola '.$_SESSION['User'];?></a>
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

	<div style="display:none;" class="dialog" title="Próximamente">
		<p>Estamos trabajando para poder ofreceros más y nuevas ventajas, cuando esté disponible se avisará vía foro.</p>
		<p>Att: El equipo de administración</p>
	</div>

	<!-- Inicio del body-->

    <div><!-- Formulario para crear nuevos reportes-->
    <div class="d-flex justify-content-center align-items-center mt-sm-4">
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
						<option>Flood</option>
						<option>Spam</option>
						<option>Vocabulario inadecuado</option>
						<option>Amenazas</option>
						<option>Discriminación</option>
						<option>Insultos a un jugador</option>
						<option>Insultos al staff</option>
						<option>Mencionar servidores</option>
						<option>Contenido inadecuado</option>
						<option>Pasar información privada</option>
						<option>Mentir sobre el uso de comandos</option>
						<option>Hacerse pasar por un staff</option>
						<option>Nick inapropiado</option>
						<option>Incitar a romper las reglas</option>

						</select>
					</div>
					<div class="form-group" id="juego"><!--Selector de las sanciones sobre el juego -->
						<label for="juego">Jugabilidad</label>
						<select name="juego" class="form-control">
						<option value="">Selecciona un motivo válido</option>
						<option>Uso de hacks</option>
						<option>Uso de clientes ilegales</option>
						<option>Abuso de bugs</option>
						<option>Prestar servicios Vip</option>
						<option>Tpakill</option>
						<option>Fly en combate</option>
						<option>Estafa de rango</option>
						<option>Grifeo</option>
						<option>Skin inadecuada</option>
						<option>Construcciones obscenas</option>
						<option>Causar lag</option>
						<option>Tener objetos ilegales</option>
						<option>Quedarse afk en el lobby de mobarena</option>
						<option>Quedarse afk en la partida de mobarena</option>
						<option>Quedarse afk en skyblock</option>
						</select>
					</div>
					<div class="form-inline">
						<label for="pruebas ">Pruebas:</label>
						<textarea name="pruebas" class="form-control mb-2 col-sm-12" rows="3" maxlength="1000" placeholder="Para subir pruebas has de usar páginas como imgur o subefotos"required></textarea>
					</div>

					<div class="form-group">
						<button type="submit" id="enviar" class="btn btn-success mt-sm-2">Enviar</button>
					</div>
				</form>
			</div>
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

$(".proximamente").click(function (e) { 
		$(function() {
			$(".dialog").dialog();
		});
	});
</script>

</body>
</html>