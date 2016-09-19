<?php


function conectar($Conexion) {
	try {

$xml = <<<XML
<?xml version='1.0' encoding='utf-8'?> 

<conexiones>
	<conexion id="cnx_siceac">
		<tipo>pgsql</tipo>	
		<servidor>localhost</servidor>
		<usuario>postgres</usuario>
		<clave>agentes</clave>
		<bd>bd_siceac</bd>
	</conexion>
</conexiones>
XML;

	$DatosXML = simplexml_load_string($xml);
		// 2.- Se recupera la informacion de la conexion especificada
		foreach($DatosXML->conexion as $cnx) {
			if ($cnx['id'] == $Conexion) {
				$tip = $cnx->tipo;
				$srv = $cnx->servidor;
				$dbn = $cnx->bd;
				$usu = $cnx->usuario;
				$cla = $cnx->clave;
			}
		}
		// 3.- Se crea la conexion hacia la BD indicada
		$pdo = new PDO("$tip:host=$srv;dbname=$dbn", $usu, $cla);
		// 4.- Se retorna la conexion abierta
		return $pdo;
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
}

function ejecutarPDO($Conexion, $SQL) {
//echo "Conexion".$Conexion;
	if (is_string($Conexion)) {
	  // Si el 1er prametro es string, siginifica que es un Id de conexion (XML)
	  // por lo tanto, debe abrir la conexion, ejecutar la consulta, y cerrarla
		$cnxPDO = conectar($Conexion);
		try {
		// 4.- Se ejecuta la consulta especificada y se devuelve el conjunto de datos
			$res = $cnxPDO->query($SQL);
			// 5.- Se cierra la conexion
			$cnxPDO = null;
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	} else {
	  // de lo contrario, si no es un string, se considera un objeto Conexion PDO
	  // por lo tanto, solo se ejecuta la consulta (sin abrir ni cerrar conexion)
	  $res = $Conexion->query($SQL);
	}
	// En cualquier caso, igualmente se devuelve el conjunto de resultadod
	return $res;
}

?>
