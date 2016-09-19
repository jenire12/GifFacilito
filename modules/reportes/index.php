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
    <link href="../../css/datepicker.css" rel="stylesheet" />    
    <!-- <link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet"> -->
    
    
    <!-- JavaScript -->
    <script src="../../js/jquery-1.10.2.js"></script>    
	<!-- <script src="js/jquery-ui-1.10.4.custom.js"></script> -->	
    <script src="../../js/bootstrap.js"></script>
    <script src="../../js/jquery.dataTables.js"></script>
    <script src="../../js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>
    <!-- <script src="../../js/tablesorter/jquery.tablesorter.js"></script>    
    <script src="../../js/tablesorter/tables.js"></script> -->
    <script src="../../js/funciones.js"></script>
    <!-- <script src="js/js_menu.js"></script> -->
    
    <script type="text/javascript" language="javascript" class="init">
		$(document).ready(function() {
			var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
			 
			var checkin = $('#fecha_inicio').datepicker().on('changeDate', function(ev) {
			  if (ev.date.valueOf() > checkout.date.valueOf()) {
			    var newDate = new Date(ev.date)
			    newDate.setDate(newDate.getDate() + 1);
			    checkout.setValue(newDate);
			  }
			  checkin.hide();
			  $('#fecha_fin')[0].focus();
			}).data('datepicker');
			var checkout = $('#fecha_fin').datepicker().on('changeDate', function(ev) {
			  checkout.hide();
			}).data('datepicker');
		});
		function imprime(criterio){
			var fecha_inicio = $("#fecha_inicio").val();
			var fecha_fin = $("#fecha_fin").val();
			var campo_criterio = $("#campo_criterio").val();
			if (fecha_inicio=='' || fecha_fin==''){
				alert("Atención!! Debe ingresar rango de fechas!!");
				return false;
			}
			window.open("./reporte_accidentes.php?fecha_inicio="+ fecha_inicio +"&fecha_fin="+ fecha_fin +"&criterio="+ criterio + "&campo_criterio=" + campo_criterio,'_blank');
		}
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
          		<h1>Reportes <small> de accidentes generados</small></h1>
	          	<ol class="breadcrumb">
	              <li><a href="../../"><i class="fa fa-globe"></i> Inicio</a></li>
	              <li class="active"><i class="fa fa-desktop"></i> Reportes</li>
	              <li class="active"><i class="fa fa-table"></i> Accidentes</li>
	            </ol>	
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
		    <div class="well">
		      <table class="table">
		        <thead>
		          <tr>	
		            <th>Desde: 
		            	<input type="text" class="span2" value="" data-date-format="dd/mm/yyyy" id="fecha_inicio">
		            </th>
		            <th>Hasta: 
		            	<input type="text" class="span2" value="" data-date-format="dd/mm/yyyy" id="fecha_fin">
		            </th>
		            <th>
		            	<div class="input-group">
					      <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
					      <input class="form-control" id="campo_criterio" type="text" placeholder="Filtro de busqueda">
					    </div>
		            </th>
		            <th>
		            	<!-- Single button -->
						<div class="btn-group">
						  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
						    Imprimir reporte <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" role="menu">
						    <li><a href="#" onclick="imprime('t8.descripcion');">por departamentos</a></li>
						    <li><a href="#" onclick="imprime('t5.descripcion');">por lesiones</a></li>						    
						    <li class="divider"></li>
						    <li><a href="#" onclick="imprime('no_criterio');">Sin critetios</a></li>
						  </ul>
						</div>
		            </th>
		          </tr>
		        </thead>
		      </table>
		     </div>
          </div>  		
      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->
  </body>
</html>
<?php
}else{
header('Location:../../');
}
