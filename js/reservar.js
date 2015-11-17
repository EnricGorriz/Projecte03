var function1=function(){
	document.getElementById('resultadoContent').className='modalbox movedown';
	document.getElementById("tituloResultado").innerHTML='Ejercicio 1';
	document.getElementById("contenidoResultado").innerHTML='<a href="#" onclick="listaDia()">Listar dias de la semana</a>';
}
var listaDia=function(){
	var diaSemana = ["Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
		alert(diaSemana[0]);
		alert(diaSemana[1]);
		alert(diaSemana[2]);
		alert(diaSemana[3]);
		alert(diaSemana[4]);
		alert(diaSemana[5]);
		alert(diaSemana[6]);
}