<!DOCTYPE html>
<html>
<?php include 'comunes/header.php'; ?>
<body>
<div class="container">
<?php 
session_start();
if(isset($_SESSION['User'])&&isset($_SESSION['Logged'])){
		if($_SESSION['Type']=='admin'){
			header('Location: admin/index.php');
		}else if($_SESSION['Type']=='staff'){
			header('Location: staff/index.php');
		}else{
			header('Location: user/index.php');
		}
	}
	if(isset($_SESSION['error'])){
		if($_SESSION['error']=='success_exit'){
			echo '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
		Has cerrado la sesión exitosamente</div>';$_SESSION['error']='';}
		if($_SESSION['error']=='fail_login'){
			echo '<div class="alert alert-danger alert-dismissible fade show"> <button type="button" class="close" data-dismiss="alert">&times;</button>
		Usuario o contraseña incorrectos</div>';$_SESSION['error']='';}
	}
?>
	<hr>
	<div class="row">
		<div class="col-sm-12">
			<h2 class="text-center" style="color:orange">Reportes DragonballCreative Minecraft</h2>
		</div>
	</div>
	<hr>
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Iniciar sesión</h3>
			</div>
			<div class="card-body">
				<form action="login.php" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" id="usr" name="usr" class="form-control" placeholder="Usuario" required>
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" id="pss" name="pss" class="form-control" placeholder="Contraseña" required>
					</div>
					<div class="form-group">
						<input type="submit" value="Entrar" class="btn float-right login_btn" style="background-color:#FFEFAB">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					No tienes cuenta?<a href="#">Registrate</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="#">Olvidaste la contraseña?</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>