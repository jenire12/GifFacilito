<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_POST['formulario'])))
	{		
		extract($_POST);
		$descripcion = strtoupper($descripcion);
		//echo $login, $passwd, $nivel;
		$SQL = "INSERT INTO tsca_lesiones
					(cod_lesion, descripcion)
					VALUES ('$cod_lesion', '$descripcion')";
		
		$result = ejecutarPDO("cnx_siceac", $SQL);		
		if ($result)
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-success',
								'descripcion'=>'Lesión Agregada Correctamente'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		else
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'No se pudo agregar la lesión. Esa lesión ya existe!');
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
	}	
?>
