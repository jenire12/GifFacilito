<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_GET['cod_lesion'])))
	{
		extract($_GET);
		//echo $login, $passwd, $nivel;
		$SQL = "DELETE FROM tsca_lesiones					
				WHERE
					cod_lesion = '$cod_lesion'
					";		
		$result = ejecutarPDO("cnx_siceac", $SQL);		
		if ($result)
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-success',
								'descripcion'=>'Lesión Eliminada Correctamente'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		else
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'No se pudo Eliminar la lesión!');
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
	}	
?>
