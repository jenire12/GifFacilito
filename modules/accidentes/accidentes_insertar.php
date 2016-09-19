<?php
	session_start();
	include_once("../../bd/funciones_bd.inc");
	
	if ((isset($_POST['formulario'])))
	{		
		extract($_POST);
		$profesion_oficio = strtoupper($profesion_oficio);
		$descripcion_accidente = strtoupper($descripcion_accidente);
		$recomendaciones = strtoupper($recomendaciones);
		$lugar_accidente = strtoupper($lugar_accidente);
		
		$SQL = "INSERT INTO tsca_accidente
					(
						fec_registro, fec_informe, jefe_turno, fec_ocurrencia, turno, trabajador_lesionado, 
						profesion_oficio, lesion, descripcion_accidente, recomendaciones, perdida_tiempo, 
						sobretiempo, medico_tratante, enfermero_tratante, lugar_accidente
					)
				VALUES 
					(
						NOW(), '$fec_informe', '$jefe_turno', '$fec_ocurrencia', '$turno', '$trabajador_lesionado', 
						'$profesion_oficio', '$lesion', '$descripcion_accidente', '$recomendaciones', '$perdida_tiempo', 
						'$sobretiempo', '$medico_tratante', '$enfermero_tratante', '$lugar_accidente'
					)
				";
		
		$result = ejecutarPDO("cnx_siceac", $SQL);
		if ($result)
		{
			
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-success',
								'descripcion'=>'Reporte de Accidente Cargado Correctamente'
							);
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
		else
		{	
			$mensaje = array(
								'titulo'=>'Aviso',
								'clase'=>'alert-danger',
								'descripcion'=>'Ocurrió un error al momento de cargar el reporte de accidentes!!');
			
			$_SESSION['mensaje'] = $mensaje;
			header('Location:./');
		}
	}	
?>
