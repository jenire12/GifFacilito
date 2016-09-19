function seccion_usuarios(){
	// var tipo = document.getElementById('Titulo').title;
	var tipo = "Buscar";
	url = "./modules/usuarios/index.php";
	// Datos = "tipo=" + tipo + "&senhal="+ senhal + "&amplitud_modulante="+ amplitud_modulante + "&frecuencia_modulante="+ frecuencia_modulante + "&amplitud_portadora="+ amplitud_portadora + "&frecuencia_portadora="+ frecuencia_portadora + "&constante_modulacion="+ constante_modulacion;
	Datos = "tipo=" + tipo;
	ObtenerDatosPorPOST("page-wrapper", url, Datos);
}