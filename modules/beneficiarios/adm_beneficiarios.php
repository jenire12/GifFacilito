<?php
header("Content-type: text/xml");


include_once('../../bd/funciones_bd.inc');

include_once('../../core/formatearfechas.php');

$accion   = $_POST['operacion'];

// 			CLASES PERSISTENCIAS

include_once('class_beneficiarios.php');
include_once('class_auditoria.php');


$ObjAuditoria			= new Auditoria;
$ObjBeneficiario		= new Beneficiarios;


// Ejecuta las acciones correspondientes segun la operacion
if ($accion=='agregar' OR  $accion=='actualizar' OR $accion=='eliminar'  ) {  
    try {
         $PDO = conectar('conexion');
         $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $PDO->beginTransaction();      

         if ($accion=='agregar') {
		 $_POST['cedula']=$_POST['tipo_cedula'].$_POST['cedula'];
	     $resul 		  = $ObjBeneficiario->Agregar($PDO,$_POST);	     
	     //$fila     		  = $resul->fetch();
	     echo "<respuestas><operacion>satisfactoria</operacion><lastinsertID>{$_POST['cedula']}</lastinsertID></respuestas>";            
         }	 
	 
		if ($accion=='eliminar') {
            //Ejecuta el metodo Actualizar
            $_POST['cedula']=$_POST['tipo_cedula'].$_POST['cedula'];
            $resul = $ObjBeneficiario->Eliminar($PDO, $_POST['cedula']);
            echo "<respuestas><operacion>satisfactoria</operacion><lastinsertID> </lastinsertID></respuestas>"; 
         }
         
		if ($accion=='actualizar') {
			$_POST['cedula']=$_POST['tipo_cedula'].$_POST['cedula'];
            $resul 	 = $ObjBeneficiario->Modificar($PDO,$_POST,$_POST['cedula_original']);			
            echo "<respuestas><operacion>satisfactoria</operacion><lastinsertID> </lastinsertID></respuestas>"; 
         }
         
         
		$_POST['accion']= $accion;
		$_POST['tabla']= 'beneficiarios.beneficiario';
		$_POST['identificador']= $_POST['cedula'];
		$_POST['fecha']= date('Y-m-d H:i:s');
		
		
			
		$ObjAuditoria->Agregar($PDO, $_POST);
         $PDO->commit();
         $PDO = null;  
    } catch (Exception $e) {
      //print $e->getCode();
      print $e->getMessage();
      
    }
}
else {
   // 6.- En el caso de operaciones no identificadas
   echo "<respuestas><operacion>fallo</operacion><mensaje>Operacion fallo al ejecutarse!!!</mensaje></respuestas>";
}

