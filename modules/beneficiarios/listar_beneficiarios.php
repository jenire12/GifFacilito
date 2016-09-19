<?php


if(isset($_POST['buscador'])){
    include_once ('../../bd/funciones_bd.inc');
    $campo    = 'cedula';
    $criterio = $_POST['buscador'];
    
}else{
    
    $campo    = 'cedula';
    $criterio = '';
    
}

$aux="$campo::text  LIKE '%$criterio%'";

	
$SQL =	"
			SELECT DISTINCT
				t1.cedula as \"Cédula\",
				t1.nombres as \"Nombres\",
				t1.apellidos as \"Apellidos\",
				t1.sexo as \"Sexo\",				
				to_char(t1.fecha_nacimiento,'dd/mm/yyyy') as \"Fecha de Nacimiento\",				
				t1.direccion as \"Dirección\",
				t1.telefono as \"teléfono\",
				t1.estatus as \"Estatus\"				
			FROM
				beneficiarios.beneficiario t1
			WHERE 
				$aux
			";

	
	//echo $SQL;
  $resul = ejecutarPDO('conexion', $SQL);     
 
  $cadenaSQL = "$SQL ORDER BY t1.cedula";
  
 //Cabecera
  $LISTA_BENEFICIARIO  = "<DIV id='lista' >\n";
  $LISTA_BENEFICIARIO .= "<TABLE id='lista' BORDER='0' WIDTH='100%' CELLSPACING='0'>\n"; 
  $LISTA_BENEFICIARIO .= "<TR class='campos' id='campos'><TH></TH>\n";  
  $LISTA_BENEFICIARIO .= "<TH>C&eacute;dula</TH>";
  $LISTA_BENEFICIARIO .= "<TH>Nombres</TH>";
  $LISTA_BENEFICIARIO .= "<TH>Apellidos</TH>";
  $LISTA_BENEFICIARIO .= "<TH>Sexo</TH>";
  $LISTA_BENEFICIARIO .= "<TH>Fecha de Nacimiento</TH>";
  $LISTA_BENEFICIARIO .= "<TH>Direcci&oacute;n</TH>";
  $LISTA_BENEFICIARIO .= "<TH>Tel&eacute;fono</TH>";
  $LISTA_BENEFICIARIO .= "<TH>Estatus</TH>";
  
  $LISTA_BENEFICIARIO .= "</TR>\n";                   
  
    $filas = ejecutarPDO('conexion', $cadenaSQL);
    
    $flag=true;
    foreach ($filas as $fila) {
    $flag=false;       
    $cedula = $fila['0'];
    $LISTA_BENEFICIARIO .= "<TR class='datos' ID='$cedula'><TD WIDTH='5%' ALIGN='CENTER'>\n";
    
    $LISTA_BENEFICIARIO .= "<INPUT TYPE='radio' NAME='CLAVEPRI' VALUE='$cedula'  ></TD>\n";
    $LISTA_BENEFICIARIO .= "<TD nowrap='nowrap' >{$fila[0]}</TD>";
    $LISTA_BENEFICIARIO .= "<TD nowrap='nowrap' >{$fila[1]}</TD>";
    $LISTA_BENEFICIARIO .= "<TD nowrap='nowrap' >{$fila[2]}</TD>";
    $LISTA_BENEFICIARIO .= "<TD nowrap='nowrap' >{$fila[3]}</TD>";
    $LISTA_BENEFICIARIO .= "<TD nowrap='nowrap' >{$fila[4]}</TD>";
    $LISTA_BENEFICIARIO .= "<TD nowrap='nowrap' >{$fila[5]}</TD>";
    $LISTA_BENEFICIARIO .= "<TD nowrap='nowrap' >{$fila[6]}</TD>";
    $LISTA_BENEFICIARIO .= "<TD nowrap='nowrap' >{$fila[7]}</TD>";    
    
    echo "</TR>\n";//Cierra una fila de tabla HTML
     $VolporReg = 0;
     }
     if ($flag){
    $LISTA_BENEFICIARIO .= "	<tr class='datos' align='center'>
					<td colspan='12'><b>No se encontraron registros de la búsqueda</b></td>
				</tr>";
	}			
$LISTA_BENEFICIARIO .= "</TABLE></DIV>\n";
$LISTA_BENEFICIARIO .="<div id='formulario'></div>";
echo $LISTA_BENEFICIARIO;

?>
