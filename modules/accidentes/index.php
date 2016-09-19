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
          		<h1>Accidentes <small>Listado de accidentes</small></h1>
	          	<ol class="breadcrumb">
	              <li><a href="../../"><i class="fa fa-globe"></i> Inicio</a></li>
	              <li class="active"><i class="fa fa-desktop"></i> Seguridad Industrial</li>
	              <li class="active"><i class="fa fa-table"></i> Accidentes</li>
	            </ol>	
          	</div>   
            <div class="row">
            	<div class="col-lg-2 col-lg-offset-10">
	            	<a class="btn btn-primary pull-right" href="./accidentes_agregar.php" data-toggle="modal" data-target="#ModelAccidentes"> <span class="glyphicon glyphicon-plus-sign"></span> Agregar Accidnete </a>
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
	                    <th>ID Reporte <i class="fa fa-sort"></i></th>
	                    <th>Fecha de Ocurrencia <i class="fa fa-sort"></i></th>
	                    <th>Nombre del Lesionado <i class="fa fa-sort"></i></th>
	                    <th>Lesión <i class="fa fa-sort"></i></th>	                    	                    	                    
	                    <th>opciones <i class="fa fa-sort"></i></th>                    
	                  </tr>
	                </thead>
	                <tbody>
	                  <?php
	                  		$where = "";
	                  		if (isset($_GET['WrFAziK'])){
	                  			$where = "WHERE id_reporte = {$_GET['WrFAziK']}";
	                  		}
	                  
	                  		$sql = "
	                  				SELECT 
										t1.id_reporte,
										to_char(t1.fec_ocurrencia, 'DD/MM/YYYY') AS fec_ocurrencia,
										t2.nombres||' '||t2.apellidos AS trabajador_lesionado,
										t3.descripcion AS cargo,
										t4.descripcion AS departamento,
										t5.descripcion AS lesion
									FROM
										tsca_accidente t1
										JOIN tsca_mttrabajador t2 ON t1.trabajador_lesionado = t2.id_ficha
										JOIN tsca_mtcargo t3 ON t2.cargo = t3.id_cargo
										JOIN tsca_departamentos t4 ON t2.departamento = t4.cod_departamento
										JOIN tsca_lesiones t5 ON t1.lesion = t5.cod_lesion
										$where
									ORDER BY id_reporte DESC
	                  				";
							
							$result = ejecutarPDO("cnx_siceac", $sql); 
							foreach ($result as $fila) { ?>
								<tr>									
									<td><?php echo str_pad($fila['id_reporte'],5, "0", STR_PAD_LEFT); ?></td>
									<td><?php echo $fila['fec_ocurrencia']; ?></td>
									<td title="<?php echo $fila['trabajador_lesionado']; ?>"><?php echo substr($fila['trabajador_lesionado'],0,30); ?></td>
									<td title="<?php echo $fila['lesion']; ?>"><?php echo substr($fila['lesion'],0,35); ?></td>
									<td>																				
										<a class="btn btn-default" href="./accidentes_modificar.php?id_reporte=<?php echo $fila['id_reporte']; ?>" data-toggle="modal" data-target="#ModelAccidentes"><span class="glyphicon glyphicon-search"> ver</span> </a>
										<a class="btn btn-danger" href="./accidentes_eliminar.php?id_reporte=<?php echo $fila['id_reporte']; ?>"> Eliminar</span> </a>
									</td>
								</tr>
							<?php } ?>
	                </tbody>
	              </table>
	            </div>
		    </div>
          	
          </div>
          
          <!-- Modal -->
			<div class="modal fade bs-example-modal-lg" id="ModelAccidentes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog modal-lg">
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
