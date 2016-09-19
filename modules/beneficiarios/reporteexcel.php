<?php

include('../../bd/funciones_bd.inc');
//Para formto de fechas
include_once('../../core/formatearfechas.php');


include 'clase_SimpleExcel.php';

$Excel = new SimpleExcel('Listado de Beneficiarios','VERTICAL');

$SQL_1 = " 
				SELECT 
					*
				FROM 
					beneficiarios.vsab_beneficiario				
				";
				



$resul = ejecutarPDO('conexion',$SQL_1);

//Se cargan las Propiedades
$Excel->setEmpresa('MADERAS DEL ORINOCO');
$Excel->setGerencia('GERENCIA DE PRODUCTOS ASERRADOS');
$Excel->setDepartamento('Departamento de Control de Calidad');
$Excel->setDescripcion('Listado de Beneficiarios desde dd/mm/yyy hasta dd/mm/yyy');
$Excel->setElaboradoPor('Mariherys García');
$Excel->setAprobadoPor('Mariherys García');
$Excel->setLogoCorporacion('../../images/logocorporacion.jpg');
$Excel->setLogoEmpresa('../../images/logoempresa.jpg');

//Se le pasa el resultado de la ejecucion del Query
$Excel->setRegistros($resul);

//Se cargan las Cabeceras, membretes y Valida Registro
$Excel->Cabeceras();

//Se carga Pie de Pagina
$Excel->piePagina();

//Carga la tabla con los datos del Registro
$Excel->agregarDatos();

//Exporta el Documento
$Excel->exportar();
