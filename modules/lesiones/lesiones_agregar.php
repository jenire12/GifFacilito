<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" action="./lesiones_insertar.php" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Lesion</h4>
      </div>
      <div class="modal-body">
        
		  <div class="form-group">
		    <label for="login">Código de lesión</label>
		    <input type="text" class="form-control" name="cod_lesion" id="cod_lesion" placeholder="Ingresa codigo de lesión" required="required">
		  </div>
		  <div class="form-group">
		    <label for="login">Descripción de lesión</label>
		    <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Ingresa descripción de lesión" required="required">
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