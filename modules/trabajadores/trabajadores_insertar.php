<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_POST['formulario'])))
	{		
		extract($_POST);
		//$descripcion = strtoupper($descripcion);
		//echo $login, $passwd, $nivel;
		$passwd = md5("123456");
		$SQL = "INSERT INTO tsca_usuarios
				(login,passwd, nivel)
				VALUES ('$id_ficha','$passwd','0')";
		$result = ejecutarPDO("cnx_siceac", $SQL);
		if (!$result){
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'Atención: La ficha del trabajador ingresado ya esta registrada. Verifique!!'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		$SQL = "INSERT INTO tsca_mttrabajador
					(id_ficha, cedula, nombres, apellidos, cargo, fec_ingreso, departamento, sexo, cuadrilla)
				VALUES 
					(upper('$id_ficha'), upper('$cedula'), upper('$nombres'), upper('$apellidos'), '$cargo', '$fec_ingreso', '$departamento', '$sexo', '$cuadrilla')
				";
		// echo $SQL;
		// die();
		$result = ejecutarPDO("cnx_siceac", $SQL);
				
		if ($result)
		{
			
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-success',
								'descripcion'=>'Trabajador Agregado Correctamente'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		else
		{
			$SQL = "DELETE FROM tsca_usuarios WHERE login = '$id_ficha'";
			$result = ejecutarPDO("cnx_siceac", $SQL);
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'No se pudo agregar al trabajador. La cédula no puede estar repetida!!');
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
	}	
?>
