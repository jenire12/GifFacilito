<?php
	include_once("../../bd/funciones_bd.inc");
	
	
	if (isset($_REQUEST['cargos'])) {
	
		$query = strtoupper($_REQUEST['cargos']);
		
		$SQL = "SELECT * FROM tsca_mtcargo WHERE descripcion LIKE '%{$query}%'";
		$array = array();
		$result = ejecutarPDO("cnx_siceac", $SQL); 
		foreach ($result as $fila) { 
			$array[] = array('value' => $fila['id_cargo'], 'desc_cargo' => $fila['descripcion'] );
		}
		echo json_encode ($array); //Return the JSON Array

}
?>