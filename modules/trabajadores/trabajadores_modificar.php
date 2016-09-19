<?php
	if (isset($_GET['id_ficha'])){
		include_once("../../bd/funciones_bd.inc"); 
		$SQL = "
				SELECT 
					t1.id_ficha,
					t1.cedula,
					t1.nombres,
					t1.apellidos,
					t1.cargo,
					to_char(t1.fec_ingreso, 'DD/MM/YYYY') AS fec_ingreso,
					t1.departamento,
					t1.sexo,
					t1.cuadrilla,
					t2.descripcion AS desc_cargo,
					t3.descripcion AS desc_departamento,
					t4.descripcion AS desc_cuadrilla
				FROM 
					tsca_mttrabajador t1
					LEFT JOIN tsca_mtcargo t2 ON t1.cargo = t2.id_cargo
					LEFT JOIN tsca_departamentos t3 ON t1.departamento = t3.cod_departamento
					LEFT JOIN tsca_cuadrillas t4 ON t1.cuadrilla = t4.cod_cuadrillas 
				WHERE id_ficha = '{$_GET['id_ficha']}'				
				";
		$result = ejecutarPDO("cnx_siceac", $SQL);
		$fila = $result->fetch();
		?>
<link href="../../css/typeahead/style.css" rel="stylesheet" />
<link href="../../css/datepicker.css" rel="stylesheet" />
<style>
	.datepicker{z-index:1151;}
</style>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form  class="form-horizontal" role="form" id="formulario_modificar" action="./trabajadores_update.php" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Modificar Trabajador</h4>
      </div>
      <div class="modal-body">
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="login">Ficha</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="form-control" name="id_ficha" id="id_ficha" value="<?php echo $fila['id_ficha']; ?>" placeholder="Ingresa Ficha" required="required">
		  		<input type="hidden" name="id_ficha_original" id="id_ficha_original" value="<?php echo $fila['id_ficha']; ?>">
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="login">Cédula</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="form-control" name="cedula" id="cedula" value="<?php echo $fila['cedula']; ?>" placeholder="Ingresa Cédula" maxlength="9" required="required">
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="login">Nombres</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="form-control" name="nombres" id="nombres" value="<?php echo $fila['nombres']; ?>" placeholder="Ingresa Nombres" required="required">
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="login">Apellidos</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="form-control" name="apellidos" id="apellidos" value="<?php echo $fila['apellidos']; ?>" placeholder="Ingresa Apellidos" required="required">
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="sexo">Nivel</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<select name="sexo" id="sexo" class="form-control">
		  			<?php if ($fila['sexo'] == "M"){ ?>
		  				<option value="M" selected="selected">MASCULINO</option>
				  		<option value="F">FEMENINO</option>	
		  			<?php }else{ ?>
				  		<option value="M">MASCULINO</option>
				  		<option value="F" selected="selected">FEMENINO</option>
				  	<?php } ?>
				</select>
		  	</div>
		  </div>		  
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="login">Cargo</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="form-control" name="input_cargo" id="input_cargo" value="<?php echo $fila['desc_cargo']; ?>" placeholder="Ingresa Cargo" required="required">
		  		<input type="hidden" name="cargo" id="cargo" value="<?php echo $fila['cargo']; ?>"/>	
		  	</div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="login">Departamento</label>	
		  	</div>
		    <div class="col-lg-6">
		    	<input type="text" class="form-control" name="input_departamento" id="input_departamento" value="<?php echo $fila['desc_departamento']; ?>" placeholder="Ingresa Departamento" required="required">
		    	<input type="hidden" name="departamento" id="departamento" value="<?php echo $fila['departamento']; ?>"/>	
		    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="login">Cuadrilla</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="form-control" name="input_cuadrilla" id="input_cuadrilla" value="<?php echo $fila['desc_cuadrilla']; ?>" placeholder="Ingresa Cuadrilla" required="required">
		    	<input type="hidden" name="cuadrilla" id="cuadrilla" value="<?php echo $fila['cuadrilla']; ?>"/>	
		  	</div>
		  </div>		  
		  <div class="form-group">
		  	<div class="col-lg-3">
		  		<label for="login">Fecha Ingreso</label>
		  	</div>
		  	<div class="col-lg-6">
		  		<input type="text" class="span2" name="fec_ingreso" value="<?php echo $fila['fec_ingreso']; ?>" id="fec_ingreso"  data-date-format="dd/mm/yyyy" placeholder="Ingresa Fecha Ingreso" readonly="readonly" required="required">
		  		<span class="glyphicon glyphicon-calendar"></span>
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
	
	var Cargos = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  prefetch: './data_cargos.php?cargos=',
	  remote: './data_cargos.php?cargos=%QUERY'
	});
	Cargos.initialize();	 
	$('#input_cargo').typeahead(null, {
	  name: 'cargo',	  
	  displayKey: 'desc_cargo',
	  source: Cargos.ttAdapter()
	}).bind("typeahead:selected", function(obj, datum, name) {		
		//var datos = JSON.stringify(datum);
		$("#cargo").val(datum.value);
	}).change(function() {
  		if (("#cargo").val() == ''){
			alert("Atencion... Seleccione un cargo de la lista!");
		}
	});
	
	// Departamentos
    var Departamentos = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  prefetch: './data_departamentos.php?departamentos=',
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
	  prefetch: './data_cuadrillas.php?cuadrillas=',
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
	
	$('#fec_ingreso').datepicker();
	
  </script>
<? }else{
		echo "<strong>Disculpe... Hubo un error en la carga del formulario... </strong>";
		die();
	}
?>
