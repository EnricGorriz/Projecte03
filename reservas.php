<?php
session_start();
	if(isset($_SESSION['nombre']))$login=1;
	if(isset($_POST['login']))$login=1;
	if(isset($_POST['reservar']))$login=1;
	if(isset($_POST['retornar']))$login=1;
	if(isset($_POST['manteniment']))$login=1;
	if(isset($login)){
		if(isset($_POST['login'])){	
			if(isset($_POST['mail']))$mail = $_POST['mail'];
			if(isset($_POST['contraseña']))$contraseña = $_POST['contraseña'];
			$con = mysqli_connect('localhost', 'root', 'DAW22015', 'bd_reservas_millorat');
			$sql=("SELECT * FROM `tbl_usuario` WHERE usu_email = '$mail' && usu_contra = '$contraseña' ");
			//echo $sql;
			$datos = mysqli_query($con, $sql);
			if(mysqli_num_rows($datos) > 0){
				while($send = mysqli_fetch_array($datos)){
					$send['usu_nom'] = utf8_encode($send['usu_nom']);
					//echo "<br/><br/>$send[usu_nom]";
					$_SESSION['nombre']=$send['usu_nom'];
					$_SESSION['mail']=$send['usu_email'];
					$_SESSION['rang']=$send['usu_rang'];
				}
			}else{
				$_SESSION['error'] = 'error';
				header("Location: index.php");
				die();
			}
			mysqli_close($con);
		}
		if(isset($_POST['manteniment'])){
			if(isset($_POST['manteniment']))$manteniment = $_POST['manteniment'];
			$con = mysqli_connect('localhost', 'root', 'DAW22015', 'bd_reservas_millorat');
			//echo $manteniment;
			$sql1=("SELECT * FROM `tbl_recursos` WHERE rec_id = $manteniment");
			echo $sql1;
			$datos = mysqli_query($con, $sql1);
			if(mysqli_num_rows($datos) > 0){
				while($cerca = mysqli_fetch_array($datos)){
					$validar = $cerca['rec_desactivat'];
					if ($validar == 1) {
						$sql=("UPDATE tbl_recursos SET rec_desactivat = 0 WHERE rec_id = $manteniment ");
						$estat = "averiat";
						echo $estat;
					}else{
						$sql=("UPDATE tbl_recursos SET rec_desactivat = 1 WHERE rec_id = $manteniment ");
						$estat = "Ja en funcionament";
						echo $estat;
					}
				}
			}
			mysqli_query($con, $sql);	
			mysqli_close($con);
		}
		if(isset($_POST['reservar'])){
			$reservar = $_POST['reservar'];
			$con = mysqli_connect('localhost', 'root', 'DAW22015', 'bd_reservas_millorat');
			//echo $reservar;
			$sql1=("SELECT * FROM `tbl_recursos` WHERE rec_id = $reservar");
			//echo $sql1;
			$datos = mysqli_query($con, $sql1);
			if(mysqli_num_rows($datos) > 0){
				while($cerca = mysqli_fetch_array($datos)){
					$validar = $cerca['rec_reservado'];
					if ($validar == 1) {
						$hoy = getdate();
						$hora=($hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds']);
						$data=($hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday']);
						//echo "$hora<br/>$data";
						$usuari=$_SESSION['mail'];
						$sql=("UPDATE tbl_recursos SET rec_reservado = 0 WHERE rec_id = $reservar ");
						$estat = "Recurs reserva't";
						mysqli_query($con, $sql);	
						$sql2=("INSERT INTO `tbl_reservas`(`res_fecha_ini`, `res_hora_ini`, `UsuarioReservante`, `idRecurso`)VALUES
						('$data','$hora','$usuari', $reservar)");
						//echo $sql2;
						mysqli_query($con, $sql2);	
					}else{
						$hoy = getdate();
						$hora=($hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds']);
						$data=($hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday']);
						//echo "$hora<br/>$data";
						$usuari=$_SESSION['mail'];
						$sql=("UPDATE tbl_recursos SET rec_reservado = 1 WHERE rec_id = $reservar ");
						$estat = "Recurs retorna't";
						mysqli_query($con, $sql);	
						$sql2=("UPDATE `tbl_reservas` SET `res_fecha_fin` = '$data',  `res_hora_fin` = '$hora' WHERE idRecurso = $reservar &&  UsuarioReservante = '$usuari' ORDER BY tbl_reservas.res_fecha_fin ASC LIMIT 1");
						//echo $sql2;
						mysqli_query($con, $sql2);	
					}
					break;
				}
			}
						
			mysqli_close($con);
		}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reservar</title>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" href="css/stylesBar.css">
		<link rel="stylesheet" href="css/stylejs.css">
        <link rel="stylesheet" type="text/css" href="css/reservas.css" />
	    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	    <script type="text/javascript" src="js/scriptBar.js"></script>
	</head>
    <body>
		<div class="header">
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href='reservas.php'>RESERVAS</a></li>
					<li><a href='incidencia.php'>INCIENCIAS</a></li>
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
		<?php
			if(isset($estat))echo $estat;
		?>
        <div class="fondo">
		
			<div class="principal">
				<h1>AULAS</h1>
				<?php
					$con = mysqli_connect('localhost', 'root', 'DAW22015', 'bd_reservas_millorat');
					$sql = ("SELECT * FROM `tbl_recursos` WHERE tbl_recursos.id_tipus_recurs >= 1 && tbl_recursos.id_tipus_recurs <= 4");
					$datos = mysqli_query($con, $sql);
                    if(mysqli_num_rows($datos) > 0){
                        while($cerca = mysqli_fetch_array($datos)){
							$manteniment=1;
							$id = $cerca['rec_id'];
                            $cerca['rec_contingut']= utf8_encode($cerca['rec_contingut']);
							$nom = $cerca['rec_contingut'];
                            $img = "images/$cerca[rec_contingut].jpg";
							if($cerca['rec_desactivat']=="1"){
								if($cerca['rec_reservado']=="1"){
									$img = "images/$cerca[rec_contingut].jpg";
								}else{
									$img = "images/$cerca[rec_contingut]ocupada.jpg";
								}
							}else{
								$img = "images/$cerca[rec_contingut]mantenimiento.jpg";
								$manteniment=0;
							}
                            echo "<div id='nom' class='objeto'>$cerca[rec_contingut]<div class='objeto2'><a href='#reserva' onclick='function1($id)'><img src='$img'/></a><br/></div>";
?>
<script>
var function1=function($id){
	var element = $id;
	document.getElementById("id").value = element;
	var articulo = document.getElementById("nom").innerHTML;
	document.getElementById("tituloReserva").value = articulo;
}
</script>
<?php
							echo "</div>";
                        }
                    }
					mysqli_close($con);
				?>
			</div>
			<div class="aside">
				<h1>MATERIALES</h1>
				<?php
					$con = mysqli_connect('localhost', 'root', 'DAW22015', 'bd_reservas_millorat');
					$sql = ("SELECT * FROM `tbl_recursos` WHERE tbl_recursos.id_tipus_recurs >= 5 && tbl_recursos.id_tipus_recurs <= 8");
					$datos = mysqli_query($con, $sql);
                   if(mysqli_num_rows($datos) > 0){
                        while($cerca = mysqli_fetch_array($datos)){
							$manteniment=1;
							$id = $cerca['rec_id'];
                            $cerca['rec_contingut']= utf8_encode($cerca['rec_contingut']);
                            $img = "images/$cerca[rec_contingut].jpg";
							if($cerca['rec_desactivat']=="1"){
								if($cerca['rec_reservado']=="1"){
									$img = "images/$cerca[rec_contingut].jpg";
								}else{
									$img = "images/$cerca[rec_contingut]ocupada.jpg";
								}
							}else{
								$img = "images/$cerca[rec_contingut]mantenimiento.jpg";
								$manteniment=0;
							}
                            echo "<div class='objeto'>$cerca[rec_contingut]<div class='objeto2'><a href='#reserva' onclick='function1($id)'><img src='$img'/></a></div>";
							echo "</div>";
                        }
                    }
					mysqli_close($con);
				?>
			</div>
		</div>
		<div id="reserva" class="modalmask">
			<div class="modalbox movedown" id="reservaContent">
				<a href="reservas.php" title="Close" class="close">[close]</a>
				<h2 id="tituloReserva">Titulo</h2>
				<div id="contenidoReserva">Para reservar el producto no olvide rellenar todos los campos.</div>
				<form action="reservas.php" method="GET">
					<h4> Fecha Inicio </h4>
					<input id="fechaini" type="date" name="fechaini" required>
					<input id="horaini"type="time" name="horaini" value="10:00:00" max="22:00:00" min="08:00:00" step="1"><br/>
					<h4> Fecha Final </h4>
					<input id="fechafin" type="date" name="fechafin" required>
					<input id="horafin"type="time" name="horafin" value="10:00:00" max="22:00:00" min="08:00:00" step="1"><br/>
					<input type="hidden" id="id" name="id">
					<br/><br/><br/><input type="submit">
				</form>
			</div>
		</div>
    </body>
</html>
<?php
}else{
	$_SESSION['validarse'] = 'error';
	header("Location: index.php");
	die();
}

?>
<script>
var function2 = function(){
	object.onmouseover=function(){myScript};
}
</script>