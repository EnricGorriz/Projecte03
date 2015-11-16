<?php
session_start();
	if(isset($_POST['incidencia']))$login=1;
	if(isset($_SESSION['nombre']))$login=1;
	if(isset($login)){
		if(isset($_POST['incidencia'])){
			if(isset($_POST['Problema']))$recurs = $_POST['Problema'];
			if(isset($_POST['fecha'])) $fechaI = $_POST['fecha'];
			if(isset($_POST['comentarios'])) $coment = $_POST['comentarios'];
			$persona=$_SESSION['mail'];
			$con = mysqli_connect('localhost', 'root', 'DAW22015', 'bd_reservas');
			$sql1 = "SELECT * FROM tbl_reservas WHERE tbl_reservas.idRecurso = '$recurs' && tbl_reservas.res_fecha_fin <= '$fechaI' ORDER BY tbl_reservas.res_fecha_fin ASC LIMIT 1";
			echo $sql1;
			$inci = mysqli_query($con, $sql1);
			if(mysqli_num_rows($inci) > 0){
				while($send = mysqli_fetch_array($inci)){
					$reservar = $send['idRecurso'];
					$usuarioini = $send['UsuarioReservante'];
					$sql2=("UPDATE  `tbl_reservas` SET `res_incidencia` = '0',  `res_incidencia_coment` = '$coment', `res_incidencia_usu_email`= '$persona' WHERE UsuarioReservante = '$usuarioini' && tbl_reservas.idRecurso = '$recurs' && tbl_reservas.res_fecha_fin <= '$fechaI' ORDER BY tbl_reservas.res_fecha_fin ASC, tbl_reservas.res_hora_fin DESC LIMIT 1");
					echo $sql2;
					$inciden = mysqli_query($con, $sql2);
					break;
				}
			}
		}
?>
<!DOCTYPE html>
<html >
	<head>
		<meta charset="UTF-8">
		<title>Formulario INCIDENCIA</title>
		<link rel="stylesheet" href="css/styleincidencias.css">
	    <link rel="stylesheet" href="css/stylesBar.css">
	    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	    <script src="js/scriptBar.js"></script>	
	</head>
	<body>
		<div class="header">
			<div id='cssmenu'>
				<ul>
					<li><a href='reservas.php'>RESERVAS</a></li>
					<li class='active'><a href='incidencia.php'>INCIENCIAS</a></li>
					<?php
					$rang=$_SESSION['rang'];
					if($rang==0){
						echo "<li><a href='administrar.php'>ADMINISTRAR</a></li>";
					}
					?>
					<li><?php echo "<br/>&nbsp;&nbsp; Bienvenido $_SESSION[nombre] ";?></li>
				</ul>
			</div>
		</div>
		<form action="incidencia.php" method="POST">
			<div class="container">
				<div class="profile">
					<div class="profile__form">
						<div class="">
							<div class="field">
							Selecciona el problema: </br>
									<select name="Problema"> 
										<option value="Problema" required ></option>
											<?php
											$con = mysqli_connect('localhost', 'root', 'DAW22015', 'bd_reservas');
											$sql = "SELECT * FROM `tbl_recursos`";
											$datos = mysqli_query($con, $sql);
											echo "$sql";
												while ($lista = mysqli_fetch_array($datos)){
												   echo utf8_encode("<option value=\"$lista[rec_id]\">$lista[rec_contingut]</option>"); 
												}
											mysqli_close($con);
											?>
									</select> </br>
							</div>
							<div class="field">
								Seleccionar Fecha: <br/>
								<input type="date" name="fecha" required><br/>
							</div>
							Comentarios sobre la incidencia: <br/>	
							<textarea name="comentarios" rows="5" cols="37" required></textarea></br><br/>
							<div class="profile__footer">
								<input type="hidden" name="incidencia"/>
								<input type="submit" class="btn" value="Entrar"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
<?php
}else{
	$_SESSION['validarse'] = 'error';
	header("Location: index.php");
	die();
}
?>