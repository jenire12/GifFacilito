<?php
	include_once("../../bd/funciones_bd.inc");
	
	
	if (isset($_REQUEST['departamentos'])) {
	
		$query = strtoupper($_REQUEST['departamentos']);
		
		$SQL = "SELECT * FROM tsca_departamentos WHERE descripcion LIKE '%{$query}%'";
		$array = array();
		$result = ejecutarPDO("cnx_siceac", $SQL); 
		foreach ($result as $fila) { 
			$array[] = array('value' => $fila['cod_departamento'], 'desc_dpto' => $fila['descripcion'] );
		}
		echo json_encode ($array); //Return the JSON Array

}
?>