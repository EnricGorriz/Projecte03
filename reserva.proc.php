<?php
	$con = mysqli_connect('localhost', 'root', 'DAW22015', 'bd_reservas_millorat');
	$element = $_REQUEST['id'];
	$hoy = getdate();
	$data=($hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday']);
	$sql = "SELECT * FROM `tbl_reservas` WHERE tbl_reservas.idRecurso = $element && res_fecha_ini>='$data'";
	//echo $sql;
	$datos = mysqli_query($con, $sql);
	if(mysqli_num_rows($datos) > 0){
		echo "<center><h4>El recurs esta reservat en les seguents franjes </h4></center>";
		echo "<table border='1'  style='width:100%'>";
		echo "<tr><th>Data Inici </th><th>Hora d'inici</th><th>Data Final </th><th>Hora final</th></tr>";
		while($cerca = mysqli_fetch_array($datos)){
			$datai = $cerca['res_fecha_ini'];
			$horai = $cerca['res_hora_ini'];
			$dataf = $cerca['res_fecha_fin'];
			$horaf = $cerca['res_hora_fin'];
			echo "<tr><td>".$datai."</td><td>".$horai."</td><td>".$dataf."</td><td>".$horaf."</td></tr>";
		}
		echo "</table>";
	}else{
		echo "No hi ha cap futura reserva creada per aquest article.";
	}
	mysqli_close($con);
?>	