<?php
	session_start();
	//Incluir archivo de Cooexion a la de Base datos
	include_once('../../bd/funciones_bd.inc');

	// Verifica Valores
	if( !empty($_POST['login']) and !empty($_POST['passwd']))
	{
		
		// echo md5($_POST["passwd"]);
		// die();
		// Recibe Valores
		$parametro['usuario'] = array('login'=>$_POST['login'],'passwd'=>md5($_POST["passwd"]));
		
		$sql = "
				SELECT 
					t1.*,
					t2.nombres,
					t2.apellidos
				FROM 
					tsca_usuarios t1
					LEFT JOIN tsca_mttrabajador t2 ON t1.login = t2.id_ficha 				
				WHERE (t1.login='".$parametro['usuario']['login']."' AND t1.passwd='".$parametro['usuario']['passwd']."')
				";
		
		$result = ejecutarPDO("cnx_siceac", $sql);
		
				
		// Pase de Valores a un Arreglo		
		$fila = $result->fetch();
		
		// Chequea si el usuario existe
		if ($fila!=NULL)
		{	
			
			// Si están en la base de datos registra la id de usuario
			$parametro['datos'] = array(
										'nivel'=>$fila['nivel'], 
										'nombres' => $fila['nombres'],
										'apellidos' => $fila['apellidos'] 
										);
			
			// Variables de Sesion
			$_SESSION['sesion'] = $parametro;

			header("Location:http://{$_SERVER['SERVER_NAME']}/siceac/");
		}
		// Usuario o Contraseña Inválida
		else
		{
			$mensaje = array('titulo'=>'Error: Fallo de Autenticacion',
						'descripcion'=>'Usuario o clave no validos');
			
			$_SESSION['mensaje'] = $mensaje;
			
			header("Location:http://{$_SERVER['SERVER_NAME']}/siceac/");
		}
	}
	else
	{
		$mensaje = array('titulo'=>'Error: Fallo de Autenticacion',
					'descripcion'=>'Debe insertar un usuario y clave validos');
			
		$_SESSION['mensaje'] = $mensaje;

		header('Location:../../index.php');
	}
?>
