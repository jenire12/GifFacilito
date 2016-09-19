<?php
	if (isset($_GET['cod_lesion'])){
		include_once("../../bd/funciones_bd.inc"); 
		$SQL = "
				SELECT * FROM tsca_lesiones WHERE cod_lesion = '{$_GET['cod_lesion']}'				
				";
		$result = ejecutarPDO("cnx_siceac", $SQL);
		$fila = $result->fetch();
		?>
		
		<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <form role="form" action="./lesiones_update.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Modificar Lesión</h4>
	      </div>
	      <div class="modal-body">	        
			  <div class="form-group">
			    <label for="login">Código de lesión</label>
			    <input type="text" class="form-control" name="cod_lesion" id="cod_lesion" value="<?php echo $fila['cod_lesion']; ?>" placeholder="Ingresa lesion" required="required">
			    <input type="hidden" name="cod_lesion_original" id="cod_lesion_original" value="<?php echo $fila['cod_lesion']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="login">Descripción de lesión</label>
			    <input type="text" class="form-control" name="descripcion" id="descripcion" value="<?php echo $fila['descripcion']; ?>" placeholder="Ingresa descripción" required="required">
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
	<? }else{
		echo "<strong>Disculpe... Hubo un error en la carga del formulario... </strong>";
		die();
	}
?>
