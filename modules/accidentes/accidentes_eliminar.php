<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_GET['id_reporte'])))
	{
		extract($_GET);
		//echo $login, $passwd, $nivel;
		$SQL = "DELETE FROM tsca_accidente					
				WHERE
					id_reporte = '$id_reporte'
					";		
		$result = ejecutarPDO("cnx_siceac", $SQL);		
		if ($result)
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-success',
								'descripcion'=>'Reporte de Accidente Eliminado Correctamente'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		else
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'No se pudo Eliminar el reporte! Contacte a Sistemas...');
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
	}	
?>
