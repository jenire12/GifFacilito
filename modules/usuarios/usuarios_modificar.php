<?php
	if (isset($_GET['login'])){
		include_once("../../bd/funciones_bd.inc"); 
		$SQL = "
				SELECT * FROM tsca_usuarios WHERE login = '{$_GET['login']}'				
				";
		$result = ejecutarPDO("cnx_siceac", $SQL);
		$fila = $result->fetch();
		?>
		
		<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <form role="form" action="./usuarios_update.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Modificar Usuario</h4>
	      </div>
	      <div class="modal-body">
	        
			  <div class="form-group">
			    <label for="login">Nombre de Usuario</label>
			    <input type="text" class="form-control" name="login" id="login" value="<?php echo $fila['login']; ?>" placeholder="Ingresa login" required="required">
			  </div>
			  <div class="form-group">
			    <label for="passwd">Password</label>
			    <input type="password" class="form-control" name="passwd" id="passwd" value="" placeholder="Password" required="required">
			  </div>
			  <div class="form-group">
			  	<label for="nivel">Nivel</label>
			  	<select name="nivel" id="nivel" class="form-control">
			  		<?php
			  		switch($fila['nivel']){
						case 1:{
							echo "
								<option value='1' selected='selected'>ADMINISTRADOR</option>
								<option value='2'>CONSULTOR 1</option>
								<option value='3'>CONSULTOR 2</option>
								<option value='0'>INACCESIBLE</option>									
								";
							break;
						}
						case 2:{
							echo "
								<option value='1'>ADMINISTRADOR</option>
								<option value='2' selected='selected'>CONSULTOR 1</option>
								<option value='3'>CONSULTOR 2</option>
								<option value='0'>INACCESIBLE</option>									
								";
							break;
						}
						case 3:{
							echo "
								<option value='1'>ADMINISTRADOR</option>
								<option value='2'>CONSULTOR 1</option>
								<option value='3' selected='selected'>CONSULTOR 2</option>
								<option value='0'>INACCESIBLE</option>									
								";
							
						}
						default:{
							echo "
								<option value='1' selected='selected'>ADMINISTRADOR</option>
								<option value='2'>CONSULTOR 1</option>
								<option value='3'>CONSULTOR 2</option>
								<option value='0' selected='selected'>INACCESIBLE</option>									
								";
							break;
						}
			  		} 
			  		?>
				  
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
	<? }else{
		echo "<strong>Disculpe... Hubo un error en la carga del formulario... </strong>";
		die();
	}
?>
