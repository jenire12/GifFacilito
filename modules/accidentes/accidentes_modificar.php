<?php
	if (isset($_GET['id_reporte'])){
		include_once("../../bd/funciones_bd.inc");
		$SQL = "UPDATE tsca_accidente
					SET
						estatus = '1'
					WHERE
						id_reporte = {$_GET['id_reporte']}
				";
		$result = ejecutarPDO("cnx_siceac", $SQL);
		
		$SQL = "
				SELECT 
					t1.id_reporte, fec_registro, 
					to_char(t1.fec_informe, 'DD/MM/YYYY') AS fec_informe, 
					t1.jefe_turno,
					t2.nombres||' '||t2.apellidos AS nombre_jefe,
					t8.descripcion AS desc_departamento, 
					to_char(t1.fec_ocurrencia, 'DD/YY/YYYY') AS fec_ocurrencia,
					t1.turno,
					t3.descripcion AS desc_turno,
					t1.trabajador_lesionado,
					t4.nombres||' '||t4.apellidos AS nombre_trabajador,
					t1.profesion_oficio,
					t1.lesion,
					t5.descripcion AS desc_lesion,					
					t1.descripcion_accidente, 
					t1.recomendaciones, 
					t1.perdida_tiempo, 
					t1.sobretiempo, 
					t1.medico_tratante,
					t6.nombres||' '||t6.apellidos AS nombre_medico,
					t1.enfermero_tratante,
					t7.nombres||' '||t7.apellidos AS nombre_enfermero,					
					t1.lugar_accidente,
					t9.descripcion AS desc_cargo
				FROM 
					tsca_accidente t1					
					LEFT JOIN tsca_mttrabajador t2 ON t1.jefe_turno = t2.id_ficha
					LEFT JOIN tsca_turnos t3 ON t1.turno = t3.id_turno					
					LEFT JOIN tsca_mttrabajador t4 ON t1.trabajador_lesionado = t4.id_ficha
					LEFT JOIN tsca_lesiones t5 ON t1.lesion = t5.cod_lesion
					LEFT JOIN tsca_mttrabajador t6 ON t1.trabajador_lesionado = t6.id_ficha
					LEFT JOIN tsca_mttrabajador t7 ON t1.trabajador_lesionado = t7.id_ficha					
					LEFT JOIN tsca_departamentos t8 ON t2.departamento = t8.cod_departamento
					LEFT JOIN tsca_mtcargo t9 ON t4.cargo = t9.id_cargo
				WHERE id_reporte = '{$_GET['id_reporte']}'				
				";
		// echo $SQL;
		// die();
		$result = ejecutarPDO("cnx_siceac", $SQL);
		$fila = $result->fetch();
		?>
<?php include_once("../../bd/funciones_bd.inc"); ?>
<link href="../../css/typeahead/style.css" rel="stylesheet" />
<link href="../../css/datepicker.css" rel="stylesheet" />
<style>
	.datepicker{z-index:1151;}
</style>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form  class="form-horizontal" role="form" id="formulario_agregar" action="./accidentes_insertar.php" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Visor de Accidente</h4>
      </div>
      <div class="modal-body">
        
		  <div class="form-group">		  	
		  	<div class="col-md-3 col-md-offset-5">
		  		<label for="fec_informe">Fecha Informe</label>
		  	</div>
		  	<div class="col-lg-4">
		  		<input type="text" class="span2" name="fec_informe" id="fec_informe" data-date-format="dd/mm/yyyy" value="<?php echo $fila['fec_informe']; ?>" placeholder="Ingresa Fecha Informe" readonly="readonly" required="required">
		  		<!-- <span class="glyphicon glyphicon-calendar"></span> -->
		  	</div>
		  </div>
		  <div class="form-group">
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="jefe_turno">Supervisor </label>
		  	</div>
		  	<div class="col-lg-3">
		  		<input type="text" class="form-control" value="<?php echo $fila['nombre_jefe']; ?>" name="input_departamento" id="input_departamento">
		  	</div>
		  	<div class="col-lg-3 col-md-offset-3">
		  		<input type="text" class="form-control" value="<?php echo $fila['jefe_turno']; ?>" >
		  		
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="input_departamento">Departamento</label>	
		  	</div>
		    <div class="col-lg-6">
		    	<input type="text" class="form-control" value="<?php echo $fila['desc_departamento']; ?>" name="input_departamento" id="input_departamento">
		    </div>
		  </div>
		  <div class="form-group">		  	
		  	<div class="col-lg-3">
		  		<label for="lugar_accidente">Lugar del Accidente </label>
		  	</div>
		  	<div class="col-lg-5">
		  		<input type="text" class="form-control" value="<?php echo $fila['lugar_accidente']; ?>" name="lugar_accidente" id="lugar_accidente" placeholder="Lugar del Accidente" required="required">
		  	</div>
		  </div>
		  <hr />
		  <div class="form-group">		  	
		  	<div class="col-lg-3">
		  		<label for="fec_informe">Fecha del Accidente</label>
		  	</div>
		  	<div class="col-lg-3">
		  		<input type="text" value="<?php echo $fila['fec_ocurrencia']; ?>" name="fec_ocurrencia" id="fec_ocurrencia" data-date-format="dd/mm/yyyy" placeholder="Fecha Ocurrencia" readonly="readonly" required="required">		  		
		  	</div>
		  	<div class="col-lg-1 col-lg-offset-2">
		  		<label for="turno">Turno</label>
		  	</div>
		  	<div class="col-lg-3">		  		
		  		<input type="text" class="form-control" value="<?php echo $fila['desc_turno']; ?>" name="input_departamento" id="input_departamento">
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="input_trabajador">Nombre del Lesionado </label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="form-control" value="<?php echo $fila['nombre_trabajador']; ?>" name="input_departamento" id="input_departamento">
		  	</div>
		  </div>
		  <div class="form-group">		  	
		  	<div class="col-lg-3">
		  		<label for="trabajador_lesionado">Ficha </label>
		  	</div>
		  	<div class="col-lg-3">
		  		<input type="text" class="form-control" name="trabajador_lesionado" id="trabajador_lesionado" value="<?php echo $fila['trabajador_lesionado']; ?>" readonly="readonly" placeholder="Ficha" required="required">
		  	</div>
		  	<div class="col-lg-1">
		  		<label for="input_cargo">Cargo </label>
		  	</div>
		  	<div class="col-lg-5">
		  		<input type="text" class="form-control" name="input_cargo" id="input_cargo" value="<?php echo $fila['desc_cargo']; ?>" readonly="readonly" placeholder="Cargo" required="required">
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="profesion_oficio">Profesión / Oficio </label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="form-control" value="<?php echo $fila['profesion_oficio'] ?>" name="profesion_oficio" id="profesion_oficio" placeholder="Ingresa profesión/oficio" required="required">		    		
		  	</div>
		  </div>
		  <hr />
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="jefe_turno">Lesión </label>
		  	</div>
		  	<div class="col-lg-6">
				<input type="text" class="form-control" value="<?php echo $fila['desc_lesion']; ?>" name="input_departamento" id="input_departamento" />
		  	</div>		  
		  </div>	  
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="descripcion">Descripción de Lesión</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<textarea name="descripcion_accidente" id="descripcion_accidente" rows="1" cols="30"><?php echo $fila['descripcion_accidente']; ?></textarea>
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="medico_tratante">Médico(a) tratante</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" name="medico_tratante" value="<?php echo $fila['nombre_medico']; ?>" />
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="enfermero_tratante">Enfermero(a) tratante</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" name="enfermero_tratante" value="<?php echo $fila['nombre_enfermero']; ?>" />
		  	</div>
		  </div>
		  
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="recomendaciones">Recomendaciones</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<textarea name="recomendaciones" id="recomendaciones" rows="1" cols="30"> <?php echo $fila['recomendaciones']; ?> </textarea>
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-2">
		  		<label for="perdida_tiempo">Perdida de Tiempo</label>
		  	</div>
		  	<div class="col-lg-4">
		  		<input type="text" name="perdida_tiempo" value="<?php echo $fila['perdida_tiempo']; ?>" />
		  	</div>
		  	<div class="col-lg-2">
		  		<label for="sobretiempo">Sobretiempo</label>
		  	</div>
		  	<div class="col-lg-4">
		  		<input type="text" name="sobretiempo" value="<?php echo $fila['sobretiempo']; ?>" />
		  	</div>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
    <!-- /modal-content -->
</div>     <!-- /modal-dialog -->



<? }else{
		echo "<strong>Disculpe... Hubo un error en la carga del formulario... </strong>";
		die();
	}
?>
