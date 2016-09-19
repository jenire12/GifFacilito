<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_POST['formulario'])))
	{		
		extract($_POST);		
		//echo $login, $passwd, $nivel;
		$SQL = "UPDATE tsca_usuarios
				SET
						login = '$id_ficha'
				WHERE
						login = '$id_ficha_original'
				";
		$result = ejecutarPDO("cnx_siceac", $SQL);
		if (!$result){
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'Atención: Hubo un problema a la hora de modificar con el trabajado. Por favor notifique a Sistemas!!'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		$SQL = "UPDATE tsca_mttrabajador
					SET						
						id_ficha = '$id_ficha',
						cedula = UPPER('$cedula'),
						nombres = UPPER('$nombres'),
						apellidos = UPPER('$apellidos'),
						cargo = '$cargo',
						fec_ingreso = '$fec_ingreso',
						departamento = '$departamento',
						sexo = '$sexo',
						cuadrilla = '$cuadrilla'
					WHERE
						id_ficha = '$id_ficha_original'
					";
		
		$result = ejecutarPDO("cnx_siceac", $SQL);
		if ($result)
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-success',
								'descripcion'=>'Trabajador Modificado Correctamente'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		else
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'No se pudo Modificar el trabajador!');
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
	}	
?>
