<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_GET['id_ficha'])))
	{
		extract($_GET);
		//echo $login, $passwd, $nivel;
		$SQL = "DELETE FROM tsca_usuarios					
				WHERE
					login = '$id_ficha'
					";		
		$result = ejecutarPDO("cnx_siceac", $SQL);		
		if ($result)
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-success',
								'descripcion'=>'Usuario Eliminado Correctamente'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		else
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'No se pudo Eliminar al Usuario! Contacte a Sistemas...');
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
	}	
?>
