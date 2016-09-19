<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_GET['login'])))
	{
		extract($_GET);
		//echo $login, $passwd, $nivel;
		$SQL = "DELETE FROM tsca_usuarios					
				WHERE
					login = '$login'
					";
		
		$result = ejecutarPDO("cnx_siceac", $SQL);		
		if ($result)
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-success',
								'descripcion'=>'Usuario Modificado Correctamente'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		else
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'No se pudo Modificar el usuario!');
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
	}	
?>
