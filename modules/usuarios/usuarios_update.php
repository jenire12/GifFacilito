<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_POST['formulario'])))
	{		
		extract($_POST);
		$passwd = md5($passwd);
		//echo $login, $passwd, $nivel;
		$SQL = "UPDATE tsca_usuarios
					SET						
						passwd = '$passwd',
						nivel = '$nivel'
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
