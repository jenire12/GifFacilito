<?php
	include_once("../../bd/funciones_bd.inc");
	
	
	if (isset($_REQUEST['trabajadores'])) {
	
		$query = strtoupper($_REQUEST['trabajadores']);
		
		$SQL = "
			SELECT 
				t1.id_ficha,
				t1.nombres||' '||apellidos AS nombre_trabajador,
				t1.cargo,
				t2.descripcion AS desc_cargo
			FROM 
				tsca_mttrabajador t1
				JOIN tsca_mtcargo t2 ON t1.cargo = t2.id_cargo  
			WHERE nombres||' '||apellidos LIKE '%{$query}%'";
		$array = array();
		$result = ejecutarPDO("cnx_siceac", $SQL); 
		foreach ($result as $fila) { 
			$array[] = array(
								'value' => $fila['id_ficha'],
								'nombre_trabajador' => $fila['nombre_trabajador'],
								'cargo' => $fila['cargo'],
								'desc_cargo' => $fila['desc_cargo'],
							);
		}
		echo json_encode ($array); //Return the JSON Array

}
?>