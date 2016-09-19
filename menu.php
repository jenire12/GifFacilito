
<!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/"; ?>">SICEAC</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
          
          <!--Configuración de usuario -->
          <?php if ($nivel == 1) { ?>
          	<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"onClick='#' title=''><i class="fa fa-wrench"></i> Configuración <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/"; ?>modules/usuarios/"><i class="fa fa-arrow-circle-right"></i> Usuarios</a></li>	                
              </ul>
            </li> 
          <?php } ?>
			<?php if ($nivel == 1 || $nivel == 2){ ?>
          	<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"onClick='#' title='SSB - SC'><i class="fa fa-desktop"></i> Datos Básicos <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/modules/trabajadores/"; ?>" onClick='#'><i class="fa fa-arrow-circle-right"></i> Trabajadores</a></li>
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/modules/cargos/"; ?>" onClick='#'><i class="fa fa-arrow-circle-right"></i> Cargos</a></li>
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/modules/departamentos/"; ?>" onClick='#'><i class="fa fa-arrow-circle-right"></i> Departamentos</a></li>
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/modules/cuadrillas/"; ?>" onClick='#'><i class="fa fa-arrow-circle-right"></i> Cuadrillas</a></li>
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/modules/turnos/"; ?>" onClick='#'><i class="fa fa-arrow-circle-right"></i> Turnos</a></li>
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/modules/lesiones/"; ?>" onClick='#'><i class="fa fa-arrow-circle-right"></i> Lesiones</a></li>
              </ul>
            </li>
            <?php } ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"onClick='#' ><i class="fa fa-desktop"></i> Seguridad industrial <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/modules/accidentes/"; ?>" onClick='#'><i class="fa fa-table"></i> Accidentes</a></li>
              </ul>
            </li>
            <?php if ($nivel == 1 || $nivel == 2){ ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"onClick='#' ><i class="fa fa-desktop"></i> Reportes <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/modules/reportes/"; ?>" onClick='#'><i class="fa fa-table"></i> Accidentes</a></li>                                
              </ul>
            </li>
            <?php } ?>
          </ul>
          
          <!-- Menu a la derecha!!! -->
          <ul class="nav navbar-nav navbar-right navbar-user">
          	<!-- Alertas de Accidentes -->
          	<?php if ($nivel == 1 || $nivel == 2){ ?>
          	<?php
          		$SQL = "
          				SELECT 
							t1.id_reporte,
							to_char(t1.fec_registro, 'DD/MM/YYYY') AS fec_registro
						FROM
							tsca_accidente t1
						WHERE
							t1.estatus = '0'
          				";
				$result = ejecutarPDO("cnx_siceac", $SQL);				 
          	?>
            <li class="dropdown alerts-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Alertas de Accidentes <span class="badge"><?php echo $result->RowCount(); ?></span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
              	<?php foreach($result as $fila){ ?>
              		<li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/modules/accidentes/?WrFAziK={$fila['id_reporte']}"; ?>">
	                	Aviso de Accidente: <span class="label label-warning">Fecha: <?php echo $fila['fec_registro']; ?></span>
	                </a></li>
              	<?php } ?>
                <li class="divider"></li>
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/modules/accidentes/"; ?>">Ver Todos</a></li>
              </ul>
            </li>
            <?php } ?>
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $nombre." ".$apellido; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <!-- <li><a href="#"><i class="fa fa-user"></i> Perfil</a></li> -->
                <!--<li><a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge">7</span></a></li> -->
                <!-- <li><a href="#"><i class="fa fa-gear"></i> Configuraci&oacute;n</a></li> -->
                <!-- <li class="divider"></li> -->
                <li><a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/siceac/"; ?>/modules/acceso/salir.php"><i class="fa fa-power-off"></i> Salir</a></li>
              </ul>
            </li>
          </ul>	
        </div><!-- /.navbar-collapse -->
      </nav>
