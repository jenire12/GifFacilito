<?php
	include_once("../../bd/funciones_bd.inc");
	
	
	if (isset($_REQUEST['cuadrillas'])) {
	
		$query = strtoupper($_REQUEST['cuadrillas']);
		
		$SQL = "SELECT * FROM tsca_cuadrillas WHERE descripcion LIKE '%{$query}%'";
		$array = array();
		$result = ejecutarPDO("cnx_siceac", $SQL); 
		foreach ($result as $fila) { 
			$array[] = array('value' => $fila['cod_cuadrillas'], 'desc_cuadrilla' => $fila['descripcion'] );
		}
		echo json_encode ($array); //Return the JSON Array

}
?>