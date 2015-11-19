<?php
session_start();
	if(isset($_SESSION['nombre']))$login=1;
	if(isset($_POST['login']))$login=1;
	if(isset($_POST['reservar']))$login=1;
	if(isset($_POST['id']))$login=1;
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
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$fechaini = $_POST['fechaini'];
			$horaini = $_POST['horaini'];
			$fechafin = $_POST['fechafin'];
			$horafin = $_POST['horafin'];
			$con = mysqli_connect('localhost', 'root', 'DAW22015', 'bd_reservas_millorat');
			$sql1=("SELECT * FROM `tbl_reservas` WHERE idRecurso = $id && res_fecha_ini>='$fechaini' && res_hora_ini>='$horaini' && res_hora_fin<='$horafin' && res_fecha_fin<='$fechafin'");
			//echo $sql1;
			$datos = mysqli_query($con, $sql1);
			if(mysqli_num_rows($datos) >= 1){
				echo "Hi ha una reserva que presenta conflicte amb la que s'ha intentat crear";
			}else{
					$usuari=$_SESSION['mail'];
					$sql=("INSERT INTO `tbl_reservas`(`res_fecha_ini`, `res_hora_ini`, `res_fecha_fin`, `res_hora_fin`, `UsuarioReservante`, `idRecurso`) VALUES ('$fechaini', '$horaini','$fechafin','$horafin','$usuari',$id)");
					//echo $sql;
					mysqli_query($con, $sql);
					echo "<br/> Reserva creada correctamente";
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
		<script>
			var function1=function($id){
				var element = $id;
				document.getElementById("id").value = element;
				document.getElementById("foto").src = "images/" + element + ".jpg";
				var x = new XMLHttpRequest();
				x.onreadystatechange = function() {
					if (x.readyState == 4 && x.status == 200) {
						document.getElementById("contenidoReserva").innerHTML = x.responseText;
					}
				};
				x.open("GET","reserva.proc.php?id="+element,true);
				x.send();
			}
		</script>
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
                            echo "<div class='objeto'>$cerca[rec_contingut]<div class='objeto2'><a href='#reserva' onclick='javascript:function1($id)'><img src='$img'/></a><br/></div>";
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
							$nom = $cerca['rec_contingut'];
                            $img = "images/$cerca[rec_contingut].jpg";
                            echo "<div class='objeto'>$cerca[rec_contingut]<div class='objeto2'><a href='#reserva' onclick='javascript:function1($id)'><img src='$img'/></a><br/></div>";
							echo "</div>";
                        }
                    }
					mysqli_close($con);
				?>
			</div>
		</div>
		<div id="reserva" class="modalmask">
			<div class="modalbox movedown" id="reservaContent">
				<a href="reservas.php" title="Close" class="close">[Atras]</a>
				<h2 id="tituloReserva">RESERVA </h2>
				<img id="foto" src=''/><br/><br/>
				
				<div id="contenidoReserva">Para reservar, no olvide rellenar todos los campos.</div>
				<form action="reservas.php" method="POST">
					<h4> Fecha Inicio </h4>
					<input id="fechaini" type="date" name="fechaini" min='<?php echo date("Y-m-d");?>' value='<?php echo date("Y-m-d");?>'required>
					<?php
					$today1 = date("H")+1;
					$today1.= date(":00");
					?>
					<input id="horaini"type="time" name="horaini" value='<?php echo  $today1;?>' max="20:00" min="08:00" step="1"><br/>
					<h4> Fecha Final </h4>
					<input id="fechafin" type="date" name="fechafin" required>
					<?php
					$today = date("H")+2;
					$today.= date(":00");
					?>
					<input id="horafin"type="time" name="horafin" value='<?php echo $today;?>' max="20:00" min="08:00" step="1"><br/>
					<input type="hidden" id="id" name="id" value="0">
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