<?php
	session_start();
	
	if (isset($_SESSION['sesion'])){ //ingreso
		$nivel=$_SESSION['sesion']['datos']['nivel'];
		$login=$_SESSION['sesion']['usuario']['login'];
		$nombre=$apellido="";
		
		include_once("../../bd/funciones_bd.inc");
				
		if ($nivel == 1){
			// Usuario administrador
			$nombre = $login;
		}else{
			$nombre = $_SESSION['sesion']['datos']['nombres'];
			$apellido = $_SESSION['sesion']['datos']['apellidos'];
			$nombre = strtolower(substr($nombre, 0, strpos($nombre, ' ')));
			$apellido = strtolower(substr($apellido, 0, strpos($apellido, ' ')));
			$nombre = strtoupper(substr($nombre,0, 1)).substr($nombre, 1);
			$apellido = strtoupper(substr($apellido,0, 1)).substr($apellido, 1);
		}
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>.: Sistema para el Control Estad&iacute;stico de Accidentes :.</title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="../../css/sb-admin.css" rel="stylesheet">    
    <link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">    
    <link rel="stylesheet" href="../../font-awesome/css/dataTables.bootstrap.css">    
    <!-- <link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet"> -->
    
    
    <!-- JavaScript -->
    <script src="../../js/jquery-1.10.2.js"></script>    
	<!-- <script src="js/jquery-ui-1.10.4.custom.js"></script> -->	
    <script src="../../js/bootstrap.js"></script>
    <script src="../../js/jquery.dataTables.js"></script>
    <script src="../../js/dataTables.bootstrap.js"></script>
    <!-- <script type="text/javascript" src="../../js/typeahead/typeahead.bundle.js"></script> -->
    <script src="../../js/funciones.js"></script>
    <!-- <script src="js/js_menu.js"></script> -->
    
    <script type="text/javascript" language="javascript" class="init">
		$(document).ready(function() {
			$('#example').dataTable({				
				"language" : {
					"lengthMenu" : "Mostrando _MENU_ ",
					"zeroRecords" : "Nada encontrado - Disculpe",
					"info" : "Mostrando página _PAGE_ de _PAGES_",
					"infoEmpty" : "No hay registros disponibles",
					"infoFiltered" : "(filtrado de _MAX_ registros totales)"
				}
			});			
			$('body').on('hide.bs.modal', '.modal', function() {
				$(this).removeData('bs.modal');
				window.location="./";
			});
		});
	</script>
	<style>
		#example_filter {
			float: right;
		}
	</style>
  </head>
  <body>

    <div id="wrapper">
      <?php include "../../menu.php" ?>
      <div id="page-wrapper">      	
          <div class="col-lg-12" >
          	<div class="row">
          		<h1>Trabajadores <small>Lista de trabajadores</small></h1>
	          	<ol class="breadcrumb">
	              <li><a href="../../"><i class="fa fa-globe"></i> Inicio</a></li>
	              <li class="active"><i class="fa fa-desktop"></i> Datos basicos</li>
	              <li class="active"><i class="fa fa-table"></i> Trabajadores</li>
	            </ol>	
          	</div>   
            <div class="row">
            	<div class="col-lg-2 col-lg-offset-10">
	            	<a class="btn btn-primary pull-right" href="./trabajadores_agregar.php" data-toggle="modal" data-target="#ModelTrabajadores"> <span class="glyphicon glyphicon-plus-sign"></span> Agregar Trabajador </a>
	            </div>
            </div>
            <br />
            <div class="row">    	 
		    	<?php
		    	if(isset($_SESSION['mensaje']))
				{	
					?>
					<div class="alert alert-dismissable <?php echo $_SESSION['mensaje']['clase']; ?>">
						<button type="button" class="close" data-dismiss="alert">×</button>
		            	<b><?php echo $_SESSION['mensaje']['titulo']; ?>: </b> <?php echo $_SESSION['mensaje']['descripcion']; ?>  
		        	</div>
		        	<?php
					unset($_SESSION['mensaje']);
					}
				?>      
		    </div>
		    <div class="row">
		    	<div class="table-responsive">	
	              <table id="example" class="table table-hover table-striped table-condensed tablesorter" cellspacing="0" width="100%">
	                <thead>
	                  <tr align="center">
	                    <th>Ficha Trabajador <i class="fa fa-sort"></i></th>
	                    <th>Cédula <i class="fa fa-sort"></i></th>
	                    <th>Nombre Completo <i class="fa fa-sort"></i></th>
	                    <th>Cargo <i class="fa fa-sort"></i></th>	                    	                    
	                    <th>opciones <i class="fa fa-sort"></i></th>                    
	                  </tr>
	                </thead>
	                <tbody>
	                  <?php
	                  		$sql = "
	                  				SELECT 
										t1.*,
										t1.nombres||' '||t1.apellidos AS nombre_completo,
										t2.descripcion AS desc_cargo,
										t3.descripcion AS desc_departamento,
										t4.descripcion AS desc_cuadrilla
									FROM
										tsca_mttrabajador t1
										LEFT JOIN tsca_mtcargo t2 ON t1.cargo = t2.id_cargo
										LEFT JOIN tsca_departamentos t3 ON t1.departamento = t3.cod_departamento
										LEFT JOIN tsca_cuadrillas t4 ON t1.cuadrilla = t4.cod_cuadrillas
									ORDER BY id_ficha
	                  				";
							$result = ejecutarPDO("cnx_siceac", $sql); 
							foreach ($result as $fila) { ?>
								<tr>									
									<td><?php echo $fila['id_ficha']; ?></td>
									<td><?php echo $fila['cedula']; ?></td>
									<td title="<?php echo $fila['nombre_completo']; ?>"><?php echo substr($fila['nombre_completo'],0,30); ?></td>
									<td title="<?php echo $fila['desc_departamento']; ?>"><?php echo substr($fila['desc_cargo'],0,25); ?></td>																		
									<td>																				
										<a class="btn btn-success" href="./trabajadores_modificar.php?id_ficha=<?php echo $fila['id_ficha']; ?>" data-toggle="modal" data-target="#ModelTrabajadores"><span class="glyphicon glyphicon-edit"> Editar</span> </a>
										<a class="btn btn-danger" href="./trabajadores_eliminar.php?id_ficha=<?php echo $fila['id_ficha']; ?>"> Eliminar</span> </a>
									</td>
								</tr>
							<?php } ?>
	                </tbody>
	              </table>
	            </div>
		    </div>
          	
          </div>
          
          <!-- Modal -->
			<div class="modal fade" id="ModelTrabajadores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			
			        </div>
			        <!-- /.modal-content -->
			    </div>
			    <!-- /.modal-dialog -->
			</div>        		
      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->
  </body>
</html>
<?php
}else{
header('Location:../../');
}
