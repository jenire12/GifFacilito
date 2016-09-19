<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" action="./usuarios_insertar.php" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Usuario</h4>
      </div>
      <div class="modal-body">
        
		  <div class="form-group">
		    <label for="login">Nombre de Usuario</label>
		    <input type="text" class="form-control" name="login" id="login" placeholder="Ingresa login" required="required">
		  </div>
		  <div class="form-group">
		    <label for="passwd">Password</label>
		    <input type="password" class="form-control" name="passwd"i d="passwd" placeholder="Password" required="required">
		  </div>
		  <div class="form-group">
		  	<label for="nivel">Nivel</label>
		  	<select name="nivel" id="nivel" class="form-control">
			  <option value="1">ADMINISTRADOR</option>
			  <option value="2">CONSULTOR 1</option>
			  <option value="3">CONSULTOR 2</option>
			  <option value="0">INACCESIBLE</option>
			</select>
		  </div>					  
		  <!-- <button type="submit" class="btn btn-default">Submit</button> -->
		<!-- </form> -->
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