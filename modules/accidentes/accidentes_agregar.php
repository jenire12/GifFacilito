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
        <h4 class="modal-title" id="myModalLabel">Agregar Accidente</h4>
      </div>
      <div class="modal-body">
        
		  <div class="form-group">		  	
		  	<div class="col-md-3 col-md-offset-5">
		  		<label for="fec_informe">Fecha Informe</label>
		  	</div>
		  	<div class="col-lg-4">
		  		<input type="text" class="span2" name="fec_informe" id="fec_informe" data-date-format="dd/mm/yyyy" placeholder="Ingresa Fecha Informe" readonly="readonly" required="required">
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
		  		<select name="jefe_turno" id="jefe_turno">
		  			<option value="" selected> selecciona jefe</option>		  			
		  			<?php
		  				$SQL = "
								SELECT 
		  							t1.id_ficha,
		  							t1.nombres||' '||t1.apellidos AS nombre_jefe		  							
		  						FROM 
		  							tsca_mttrabajador t1
		  						where t1.cargo = '129'
		  						";
						$result = ejecutarPDO("cnx_siceac", $SQL); 
						foreach ($result as $fila){ ?>
							<option value="<?php echo $fila['id_ficha']; ?>"><?php echo $fila['nombre_jefe']; ?></option>
						<?php } ?>					
		  			 ?>
		  		</select>		  		
		  	</div>
		  	<div class="col-lg-3 col-md-offset-3">
		  		<input type="text" class="form-control" name="ficha_jefe" id="ficha_jefe" readonly="readonly" placeholder="Ficha" required="required">
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="input_departamento">Departamento</label>	
		  	</div>
		    <div class="col-lg-6">
		    	<input type="text" class="form-control" name="input_departamento" id="input_departamento" placeholder="Ingresa Departamento" required="required">
		    	<input type="hidden" name="departamento" id="departamento" value=""/>	
		    </div>
		  </div>
		  <div class="form-group">		  	
		  	<div class="col-lg-3">
		  		<label for="lugar_accidente">Lugar del Accidente </label>
		  	</div>
		  	<div class="col-lg-5">
		  		<input type="text" class="form-control" name="lugar_accidente" id="lugar_accidente" placeholder="Lugar del Accidente" required="required">
		  	</div>
		  </div>
		  <hr />
		  <div class="form-group">		  	
		  	<div class="col-lg-3">
		  		<label for="fec_informe">Fecha del Accidente</label>
		  	</div>
		  	<div class="col-lg-3">
		  		<input type="text" name="fec_ocurrencia" id="fec_ocurrencia" data-date-format="dd/mm/yyyy" placeholder="Fecha Ocurrencia" readonly="readonly" required="required">
		  		<!-- <span class="glyphicon glyphicon-calendar"></span> -->
		  	</div>
		  	<div class="col-lg-1 col-lg-offset-2">
		  		<label for="turno">Turno</label>
		  	</div>
		  	<div class="col-lg-3">
		  		<select name="turno" id="turno">		  			
		  			<?php
		  				$SQL = "
								SELECT 
		  							*		  							
		  						FROM 
		  							tsca_turnos
		  						";
						$result = ejecutarPDO("cnx_siceac", $SQL); 
						foreach ($result as $fila){ ?>
							<option value="<?php echo $fila['id_turno']; ?>"><?php echo substr($fila['descripcion'], 0, 40); ?></option>
						<?php } ?>					
		  			 ?>
		  		</select>
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="input_trabajador">Nombre del Lesionado </label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="form-control" name="input_trabajador" id="input_trabajador" placeholder="Ingresa Trabajador" required="required">		    		
		  	</div>
		  </div>
		  <div class="form-group">		  	
		  	<div class="col-lg-3">
		  		<label for="trabajador_lesionado">Ficha </label>
		  	</div>
		  	<div class="col-lg-3">
		  		<input type="text" class="form-control" name="trabajador_lesionado" id="trabajador_lesionado" value="" readonly="readonly" placeholder="Ficha" required="required">
		  	</div>
		  	<div class="col-lg-1">
		  		<label for="input_cargo">Cargo </label>
		  	</div>
		  	<div class="col-lg-5">
		  		<input type="text" class="form-control" name="input_cargo" id="input_cargo" value="" readonly="readonly" placeholder="Cargo" required="required">
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="profesion_oficio">Profesión / Oficio </label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="form-control" name="profesion_oficio" id="profesion_oficio" placeholder="Ingresa profesión/oficio" required="required">		    		
		  	</div>
		  </div>
		  <hr />
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="jefe_turno">Lesión </label>
		  	</div>
		  	<div class="col-lg-3">
		  		<select name="lesion" id="lesion">		  			
		  			<?php
		  				$SQL = "
								SELECT 
		  							*		  							
		  						FROM 
		  							tsca_lesiones
		  						";
						$result = ejecutarPDO("cnx_siceac", $SQL); 
						foreach ($result as $fila){ ?>
							<option value="<?php echo $fila['cod_lesion']; ?>"><?php echo substr($fila['descripcion'], 0, 40); ?></option>
						<?php } ?>					
		  			 ?>
		  		</select>		  		
		  	</div>		  
		  </div>	  
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="descripcion">Descripción de Lesión</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<textarea name="descripcion_accidente" id="descripcion_accidente" rows="1" cols="30"></textarea>
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="medico_tratante">Médico(a) tratante</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<select name="medico_tratante" id="medico_tratante">		  			
		  			<?php
		  				$SQL = "
								SELECT 
		  							t1.id_ficha,
		  							t1.nombres||' '||t1.apellidos AS nombre_medico		  							
		  						FROM 
		  							tsca_mttrabajador t1
		  						WHERE
		  							t1.cargo = '17'
		  						";
						$result = ejecutarPDO("cnx_siceac", $SQL); 
						foreach ($result as $fila){ ?>
							<option value="<?php echo $fila['id_ficha']; ?>"><?php echo substr($fila['nombre_medico'], 0, 40); ?></option>
						<?php } ?>					
		  			 ?>
		  		</select>
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="enfermero_tratante">Enfermero(a) tratante</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<select name="enfermero_tratante" id="enfermero_tratante">		  			
		  			<?php
		  				$SQL = "
								SELECT 
		  							t1.id_ficha,
		  							t1.nombres||' '||t1.apellidos AS nombre_enfermero		  							
		  						FROM 
		  							tsca_mttrabajador t1
		  						WHERE
		  							t1.cargo = '16'
		  						";
						$result = ejecutarPDO("cnx_siceac", $SQL); 
						foreach ($result as $fila){ ?>
							<option value="<?php echo $fila['id_ficha']; ?>"><?php echo substr($fila['nombre_enfermero'], 0, 40); ?></option>
						<?php } ?>					
		  			 ?>
		  		</select>
		  	</div>
		  </div>
		  
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="recomendaciones">Recomendaciones</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<textarea name="recomendaciones" id="recomendaciones" rows="1" cols="30"></textarea>
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-2">
		  		<label for="perdida_tiempo">Perdida de Tiempo</label>
		  	</div>
		  	<div class="col-lg-4">
		  		<div class="radio">
				    <input type="radio" name="perdida_tiempo" id="perdida_tiempo" value="SI" > SI <br />
				    <input type="radio" name="perdida_tiempo" id="perdida_tiempo" value="NO" > NO
				</div>
		  	</div>
		  	<div class="col-lg-2">
		  		<label for="sobretiempo">Sobretiempo</label>
		  	</div>
		  	<div class="col-lg-4">
		  		<div class="radio">
				    <input type="radio" name="sobretiempo" id="sobretiempo" value="SI" > SI <br />
				    <input type="radio" name="sobretiempo" id="sobretiempo" value="NO" > NO
				</div>
		  	</div>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <input type="hidden" name="formulario" value="formulario" />
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </div>
      </form>
    </div>
    <!-- /modal-content -->
</div>     <!-- /modal-dialog -->

<script type="text/javascript" src="../../js/jquery-1.10.2.js"></script>
<!-- <script type="text/javascript" src="../../js/typeahead/bloodhound.js"></script>  -->
<script type="text/javascript" src="../../js/typeahead/bloodhound.min.js"></script> 
<script type="text/javascript" src="../../js/typeahead/typeahead.bundle.js"></script> 
<!-- <script type="text/javascript" src="../../js/typeahead/typeahead.bundle.min.js"></script> --> 
<script type="text/javascript" src="../../js/typeahead/typeahead.jquery.js"></script> 
<!-- <script type="text/javascript" src="../../js/typeahead/typeahead.jquery.min.js"></script> -->
<script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>
 
<script type="text/javascript">
	
	// Departamentos
    var Departamentos = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  //prefetch: './data_departamentos.php?departamentos=',
	  remote: './data_departamentos.php?departamentos=%QUERY'
	});
	Departamentos.initialize();	 
	$('#input_departamento').typeahead(null, {
	  name: 'departamento',	  
	  displayKey: 'desc_dpto',
	  source: Departamentos.ttAdapter()
	}).bind("typeahead:selected", function(obj, datum, name) {		
		//var datos = JSON.stringify(datum);
		$("#departamento").val(datum.value);
	});
	
	// Cuadrilla
    var Cuadrilla = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  //prefetch: './data_cuadrillas.php?cuadrillas=',
	  remote: './data_cuadrillas.php?cuadrillas=%QUERY'
	});
	Cuadrilla.initialize();	 
	$('#input_cuadrilla').typeahead(null, {
	  name: 'cuadrilla',	  
	  displayKey: 'desc_cuadrilla',
	  source: Cuadrilla.ttAdapter()
	}).bind("typeahead:selected", function(obj, datum, name) {		
		//var datos = JSON.stringify(datum);
		$("#cuadrilla").val(datum.value);
	});
	
	// Trabajador
    var Trabajador = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  //prefetch: './data_cuadrillas.php?cuadrillas=',
	  remote: './data_trabajadores.php?trabajadores=%QUERY'
	});
	Trabajador.initialize();	 
	$('#input_trabajador').typeahead(null, {
	  name: 'nombre_trabajador',	  
	  displayKey: 'nombre_trabajador',
	  source: Trabajador.ttAdapter()
	}).bind("typeahead:selected", function(obj, datum, name) {		
		//var datos = JSON.stringify(datum);
		$("#trabajador_lesionado").val(datum.value);
		$("#input_cargo").val(datum.desc_cargo);
	});
	$('#fec_informe').datepicker();
	$('#fec_ocurrencia').datepicker();
	
	$("#jefe_turno").change(function() {
		var valor = $( this ).val();
		$("#ficha_jefe").val(valor);
	});
	
  </script>
