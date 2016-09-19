<?php 

//Incluir archivo de Cooexion a la de Base datos
include_once('../../bd/funciones_bd.inc');
//Para formto de fechas
include_once('../../core/formatearfechas.php');

//Incluir Clase de Persistencia de Datos
include_once('class_beneficiarios.php');


//Crear Objeto Maestro de Cliente
$ObjMaestro = new Beneficiarios;

$tipo  = $_POST['tipo'];
$reg   = $_POST['reg'];




$readOnly = "ReadOnly = 'true'";
$variable='';
if ($tipo == "Nuevo") {
  $resul = $ObjMaestro->Buscar('conexion','');
  $fila    = $resul->fetch();
  $mensaje = 'Registro de Nuevo Beneficiario';
  $accion  = "agregar";
  $readOnly= '';
  
}elseif ($tipo == 'Editar') {
	$mensaje = 'Modificar Beneficiario';
  $resul = $ObjMaestro->Buscar('conexion',$reg);
  $fila    = $resul->fetch();
  $fila['fecha_nacimiento']=cambiar_formato_VZ($fila['fecha_nacimiento'],'Date');    
  $accion  = "actualizar";
  $readOnly='';
  $variable="<input type='hidden' name='cedula_original' id='cedula_original' value=\"{$fila['cedula']}\" /> ";
  $tipo_ced=$fila['cedula'][0];
  $fila['cedula']=substr($fila['cedula'],1);
  
}elseif($tipo == "Eliminar") {
	$mensaje = 'Eliminar beneficiario';
  $resul = $ObjMaestro->Buscar('conexion',$reg);	
  $fila    = $resul->fetch();
  $fila['fecha_nacimiento']=cambiar_formato_VZ($fila['fecha_nacimiento'],'Date');    
  $accion  = "eliminar";
  $tipo_ced=$fila['cedula'][0];
  $fila['cedula']=substr($fila['cedula'],1);
  
}

echo <<<ETIQUETA


<h1 align='center'>$mensaje</h1>

<DIV style="width:750px;height:100%;display:inline;">
<FORM action='' name='beneficiarios'>
<FIELDSET>
<LEGEND><B>Datos del Beneficiario</B></LEGEND>

<TABLE  BORDER='0' >
<TR>
	<td colspan='2'>
		C&eacute;dula de Identidad: <br />
				<select id='tipo_cedula' name='tipo_cedula' $readOnly>
			
ETIQUETA;
			echo $tipo_ced;
			if ($tipo_ced=='V'){
				$listado="
						<option value=''> Seleccione </option>
						<option value='V' selected='selected'> V </option>
						<option value='E'> E </option>
						";
			}else{
				if ($tipo_ced=='E'){
					$listado="
							<option value=''> Seleccione </option>
							<option value='V'> V </option>
							<option value='E' selected='selected'> E </option>
							";
				}else{
					$listado="
							<option value='' selected='selected'> Seleccione </option>
							<option value='V'> V </option>
							<option value='E'> E </option>
							";
				}
			}
			
			

echo <<<ETIQUETA
			$listado
		</select>
		<input type="text" name="cedula" id="cedula" value="{$fila['cedula']}" onkeypress='return validarsolonumero(event);' maxlength='8' size="8"/>
		$variable
	</td>    
    <TD >
		&nbsp;Nombres: 
		<INPUT TYPE='text' NAME='nombres' ID='nombres' SIZE='' VALUE='{$fila['nombres']}'  maxlength='' $readOnly onkeyup='ConvertirMay(this);' >		
	</TD>
    <TD >
		&nbsp;Apellidos: 
		<INPUT TYPE='text' NAME='apellidos' ID='apellidos' SIZE='' VALUE='{$fila['apellidos']}'  maxlength='' $readOnly onkeyup='ConvertirMay(this);' >		
	</TD>    
    
</tr>
<tr>
<TD >
		&nbsp;Sexo:
		<select id='sexo' name='sexo' $readOnly>
			
ETIQUETA;
			
			if (trim($fila['sexo'])=='MASCULINO'){
				$listado="
						<option value=''> Seleccione </option>
						<option value='MASCULINO' selected='selected'> M </option>
						<option value='FEMENINO'> F </option>
						";
			}else{
				if (trim($fila['sexo'])=='FEMENINO'){
					$listado="
							<option value=''> Seleccione </option>
							<option value='MASCULINO'> M </option>
							<option value='FEMENINO' selected='selected'> F </option>
							";
				}else{
					$listado="
							<option value='' selected='selected'> Seleccione </option>
							<option value='MASCULINO'> M </option>
							<option value='FEMENINO'> F </option>
							";
				}
			}
			
			

echo <<<ETIQUETA
			$listado
		</select>
	</TD>
	<TD>
		&nbsp;Fecha de Nacimiento
		<INPUT TYPE='text' NAME='fecha_nacimiento' ID='fecha_nacimiento' SIZE='' VALUE='{$fila['fecha_nacimiento']}'  maxlength='' ReadOnly='true' onClick="Javascript:popUpCalendar(this,fecha_nacimiento,'dd/mm/yyyy');" >		
	</TD>
	<TD >
		&nbsp;Direcci&oacute;n: 
		<textarea id='direccion' name='direccion' onkeyup='ConvertirMay(this);' >{$fila['direccion']}</textarea>		
	</TD>    
	<TD >
		&nbsp;Tel&eacute;fono: 
		<INPUT TYPE='text' NAME='telefono' ID='telefono' SIZE='' VALUE='{$fila['telefono']}'  maxlength='11' $readOnly onkeypress='return validarsolonumero(event);' >		
	</TD>    
	<TD >
		&nbsp;Estatus:
		<select id='estatus' name='estatus' $readOnly>
			
ETIQUETA;
			
			if (trim($fila['estatus'])=='ACTIVO'){
				$listado="
						<option value=''> Seleccione </option>
						<option value='ACTIVO' selected='selected'> ACTIVO </option>
						<option value='DESACTIVO'> DESACTIVO </option>
						";
			}else{
				if (trim($fila['estatus'])=='DESACTIVO'){
					$listado="
							<option value=''> Seleccione </option>
							<option value='ACTIVO'> ACTIVO </option>
							<option value='DESACTIVO' selected='selected'> DESACTIVO </option>
							";
				}else{
					$listado="
							<option value='' selected='selected'> Seleccione </option>
							<option value='ACTIVO'> ACTIVO </option>
							<option value='DESACTIVO'> DESACTIVO </option>
							";
				}
			}
			
			

echo <<<ETIQUETA
			$listado
		</select>
	</TD>	
</TR>
</TABLE>
</FIELDSET>
</FORM>



</TABLE>
</DIV>

</FIELDSET>

<TABLE  BORDER='1'  align="right" cellpadding="1" cellspacing="1" bordercolor="#000000" style="border-collapse:collapse;" >

ETIQUETA;
if($tipo == "Nuevo" || $tipo == "Editar")
{	

echo <<<ETIQUETA

<TR>
 <TD colspan='2' align = 'Right'>
	<INPUT TYPE="button" NAME="aceptar" value="Aceptar" ONCLICK="vDatosBeneficiario('$accion');" >
	<INPUT TYPE="button" NAME="cancelar" value = "Cancelar" ONCLICK="CerrarVentana('formulario')"> 
	</TD>
</TR>


ETIQUETA;
}
else
if($tipo == "Eliminar")
{	
echo <<<ETIQUETA

<TR>
 <TD colspan='2' align = 'Right'>
	<INPUT TYPE="button" NAME="aceptar" value="Aceptar" ONCLICK="if(confirm('Esta seguro que desea anular este registro? Los cambios serán irreversibles.'))vDatosBeneficiario('$accion');" >

	<INPUT TYPE="button" NAME="cancelar" value = "Cancelar" ONCLICK="CerrarVentana('formulario')"> 
	</TD>
<TR>

ETIQUETA;
}
else
{
echo <<<ETIQUETA

<TR>
 <TD colspan='2' align = 'Right'>

      <INPUT TYPE="button" NAME="aceptar" value = "Cancelar" ONCLICK="CerrarVentana('formulario')"> 

    </TD>
<TR>


ETIQUETA;
}
echo <<<ETIQUETA


</TABLE>
</FORM>


</DIV>


ETIQUETA;
?>
