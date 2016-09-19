<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_POST['formulario'])))
	{		
		extract($_POST);
		$passwd = md5($passwd);
		//echo $login, $passwd, $nivel;
		$SQL = "INSERT INTO tsca_usuarios
					(login,passwd, nivel)
					VALUES ('$login','$passwd','$nivel')";
		
		$result = ejecutarPDO("cnx_siceac", $SQL);		
		if ($result)
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-success',
								'descripcion'=>'Usuario Agregado Correctamente'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		else
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'No se pudo agregar el usuario. Ese usuario ya existe!');
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
	}	
?>
