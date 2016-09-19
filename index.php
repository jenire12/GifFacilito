<?php
	session_start();
	
	if (isset($_SESSION['sesion'])){ //ingreso
		$nivel=$_SESSION['sesion']['datos']['nivel'];
		$login=$_SESSION['sesion']['usuario']['login'];
		$nombre=$apellido="";
				
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
		include_once './bd/funciones_bd.inc';
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
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">    
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">    
    <!-- <link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet"> -->
    
    
    
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>    
	<!-- <script src="js/jquery-ui-1.10.4.custom.js"></script> -->
	<script src="js/jquery.featureCarousel.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>    
    <script src="js/funciones.js"></script>
    <!-- <script src="js/js_menu.js"></script> -->
  </head>
  <body>

    <div id="wrapper">
      <?php include "menu.php" ?>
      <div id="page-wrapper">        
        <div class="row">
          <div class="col-lg-12" >
          	
			<div id="myCarousel" class="carousel slide" data-ride="carousel">			    
			    <ol class="carousel-indicators">
			        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			        <li data-target="#myCarousel" data-slide-to="1"></li>
			    </ol>
			    <div class="carousel-inner">
			        <div class="item active">
			            <img alt="First slide" src="imagenes/logo.jpg">
			            <div class="container">
			                <div class="carousel-caption">
			                		<h1>SISEAC</h1>
			                    	<p>Bienvenidos al Sistema para el Control Estad&iacute;stico de Accidentes</p>
			                </div>
			            </div>
			        </div>
			        <div class="item">
			            <a href="/servicios"> <img alt="First slide" src="./imagenes/logo-final1.png"></a>
			        </div>
			    </div>
			    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
			    <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
			</div>
          </div>
        </div><!-- /.row -->		
      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    

  </body>
</html>
<?php	
}else{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>.: LOGIN :.</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">    
    <link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <link href="css/style-backend.css" rel="stylesheet">
    
    
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>    
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="js/jquery.featureCarousel.js"></script>
    <script src="js/bootstrap.js"></script>
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <h1 align="center" style="color:#f5f5f5">Sistema de Control de Accidentes </h1>
    </div>
	</div>

<div class="container">
    <div class="row">    	 
    	<?php
    	if(isset($_SESSION['mensaje']))
		{	
			?>
			<div class="alert alert-dismissable alert-warning">
				<button type="button" class="close" data-dismiss="alert">×</button>
            	<b><?php echo $_SESSION['mensaje']['titulo']; ?>: </b> <?php echo $_SESSION['mensaje']['descripcion']; ?>  
        	</div>
        	<?php
        	unset($_SESSION['mensaje']);
		}
		?>      
    </div>
	
    <div class="row">
        <div class="col-lg-12">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-md-offset-4">
                        <div align="center" class="account-wall">
                            <img class="profile-img" src="imagenes/photo.png" alt="">
                            <form name="form_ingreso" class="form-signin" action="./modules/acceso/loguea.php" method="post">
                                <input type="text" class="form-control" placeholder="Usuario" name="login" required autofocus>
                                <input type="password" class="form-control" placeholder="Contraseña" name="passwd" required>
                                <!--<input type="hidden" name="redirect" value="/backend" /> -->
                                <button class="btn btn-lg btn-primary btn-block" type="submit">
                                    Entrar
								</button>
                                <label class="checkbox pull-left">
                                    <input type="checkbox" value="remember-me">
                                    Recuerdame
                                </label>
                                <a href="#" class="pull-right need-help">
                                	Olvide mi contraseña 
                                </a>
                                <span class="clearfix"></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <hr><small><p align="center"><img src="./imagenes/cintillocsn.png" width="100%" /></p></small>
    </footer>
</div>

    

  </body>
</html>
<?php
}
 
?>

