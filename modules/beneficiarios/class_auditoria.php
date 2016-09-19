<?php 

class  Auditoria {

  public function Agregar($cnx, $datos) {
    //Metodo para agregar un nuevo registro a la tabla
    extract($datos);    
    $sql = "INSERT INTO auditoria (accion, tabla, identificador, fecha) VALUES('$accion', '$tabla', '$identificador', '$fecha')";
    //echo $sql;
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }

  public function Modificar($cnx, $datos, $PK) {
    //Metodo para actualizar un registro de la tabla
    extract($datos);
    $sql = "UPDATE auditoria SET id_auditoria='$id_auditoria', accion='$accion', tabla='$tabla', identificador='$identificador', fecha='$fecha' WHERE id_auditoria ='$PK'";    
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }

  public function Eliminar($cnx, $PK) {
    //Metodo para actualizar un registro de la tabla
    $sql = "DELETE FROM auditoria WHERE id_auditoria ='$PK'";
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }

  public function Buscar($cnx, $PK) {
    //Metodo para obtener un registro por su clave primaria
    $sql = "SELECT id_auditoria, accion, tabla, identificador, fecha FROM auditoria WHERE id_auditoria ='$PK'";
    $res = ejecutarPDO($cnx,$sql);
    return $res;
  }

}

?>
