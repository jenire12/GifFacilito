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
    <!-- <script src="../../js/tablesorter/jquery.tablesorter.js"></script>    
    <script src="../../js/tablesorter/tables.js"></script> -->
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

			$('body').on('hidden.bs.modal', '.modal', function() {
				$(this).removeData('bs.modal');
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
          		<h1>Lesiones <small>Lista de lesiones</small></h1>
	          	<ol class="breadcrumb">
	              <li><a href="../../"><i class="fa fa-globe"></i> Inicio</a></li>
	              <li class="active"><i class="fa fa-desktop"></i> Datos basicos</li>
	              <li class="active"><i class="fa fa-table"></i> Lesiones</li>
	            </ol>	
          	</div>   
            <div class="row">
            	<div class="col-lg-2 col-lg-offset-10">
	            	<a class="btn btn-primary pull-right" href="./lesiones_agregar.php" data-toggle="modal" data-target="#ModelLesiones"> <span class="glyphicon glyphicon-plus-sign"></span> Agregar lesión </a>
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
	                    <th>Codigo lesión <i class="fa fa-sort"></i></th>
	                    <th>Descripción <i class="fa fa-sort"></i></th>
	                    <th>opciones <i class="fa fa-sort"></i></th>                    
	                  </tr>
	                </thead>
	                <tbody>
	                  <?php
	                  		$sql = "
	                  				SELECT 
										cod_lesion,
										descripcion								
									FROM
										tsca_lesiones t1
									ORDER BY descripcion
	                  				";
							$result = ejecutarPDO("cnx_siceac", $sql); 
							foreach ($result as $fila) { ?>
								<tr>									
									<td><?php echo $fila['cod_lesion']; ?></td>
									<td title="<?php echo $fila['descripcion']; ?>"><?php echo substr($fila['descripcion'],0,40); ?></td>
									<td>																				
										<a class="btn btn-success" href="./lesiones_modificar.php?cod_lesion=<?php echo $fila['cod_lesion']; ?>" data-toggle="modal" data-target="#ModelLesiones"><span class="glyphicon glyphicon-edit"> Editar</span> </a>
										<a class="btn btn-danger" href="./lesiones_eliminar.php?cod_lesion=<?php echo $fila['cod_lesion']; ?>"> Eliminar</span> </a>
									</td>
								</tr>
							<?php } ?>
	                </tbody>
	              </table>
	            </div>
		    </div>
          	
          </div>
          
          <!-- Modal -->
			<div class="modal fade" id="ModelLesiones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
