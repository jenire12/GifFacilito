<?php 

class  Beneficiarios {

  public function Agregar($cnx, $datos) {
    //Metodo para agregar un nuevo registro a la tabla
    extract($datos);
    $sql = "INSERT INTO beneficiarios.beneficiario (cedula, nombres, apellidos, sexo, fecha_nacimiento, direccion, telefono, estatus) VALUES('$cedula', '$nombres', '$apellidos', '$sexo', '$fecha_nacimiento', '$direccion', '$telefono', '$estatus')";    
    //echo $sql;
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }

  public function Modificar($cnx, $datos, $PK) {
    //Metodo para actualizar un registro de la tabla
    extract($datos);
    $sql = "UPDATE beneficiarios.beneficiario SET cedula='$cedula', nombres='$nombres', apellidos='$apellidos', sexo='$sexo', fecha_nacimiento='$fecha_nacimiento', direccion='$direccion', telefono='$telefono', estatus='$estatus' WHERE cedula ='$PK'";    
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }

  public function Eliminar($cnx, $PK) {
    //Metodo para actualizar un registro de la tabla
    $sql = "DELETE FROM beneficiarios.beneficiario WHERE cedula ='$PK'";
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }

  public function Buscar($cnx, $PK) {
    //Metodo para obtener un registro por su clave primaria
    $sql = "SELECT cedula, nombres, apellidos, sexo, fecha_nacimiento, direccion, telefono, estatus FROM beneficiarios.beneficiario WHERE cedula ='$PK'";
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }

  /*public function OBT_XML($cnx, $PK) {
    //Metodo para obtener un registro en XML por su clave primaria
    $sql = "SELECT n_muestreo, fec_produccion, vol_produccion, num_paquetes, num_piezas, linea_prod, piezas_nc FROM scsipcab.tsab_mdmdespunte WHERE n_muestreo ='$PK'";
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }

  public function LIS($cnx, $criterios) {
    //Metodo para recuperar registros de la tabla por un criterio
    $sql = "SELECT n_muestreo, fec_produccion, vol_produccion, num_paquetes, num_piezas, linea_prod, piezas_nc FROM scsipcab.tsab_mdmdespunte WHERE $criterios";
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }

  public function LIS_XML($cnx, $criterios) {
    //Metodo para recuperar registros en XML de la tabla por un criterio
    $sql = "SELECT n_muestreo, fec_produccion, vol_produccion, num_paquetes, num_piezas, linea_prod, piezas_nc FROM scsipcab.tsab_mdmdespunte WHERE $criterios";
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }
  */ 

}

?>
