<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_POST['formulario'])))
	{		
		extract($_POST);
		$descripcion = strtoupper($descripcion);
		//echo $login, $passwd, $nivel;
		$SQL = "UPDATE tsca_lesiones
					SET						
						cod_lesion = '$cod_lesion',
						descripcion = '$descripcion'
					WHERE
						cod_lesion = '$cod_lesion_original'
					";
		
		$result = ejecutarPDO("cnx_siceac", $SQL);
		if ($result)
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-success',
								'descripcion'=>'Lesión Modificada Correctamente'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		else
		{
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'No se pudo Modificar la lesión!');
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
	}	
?>
