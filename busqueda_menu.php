<?php

extract($_POST);

$tipo = explode(" - ",trim($tipo));
$carpeta = "./modulos_python/{$tipo[0]}-{$tipo[1]}/";
$archivo='';
switch (trim($senhal)){
	case 'Señal Modulada':{
		$archivo = 'modulada.py';
		break;
	}
	case 'Señal Modulada DF':{
		$archivo = 'modinfreq.py';
		break;
	}
	case 'Portadora':{
		$archivo = 'Portadora.py';
		break;
	}
	case 'Modulante':{
		$archivo = 'modulante.py';
		break;
	}	
}
$archivo = $carpeta.$archivo;
//~ echo "Archivo a buscar: $archivo <br /><br /><br />";

if(isset($_POST['amplitud_modulante'])){
	$ejecucion = "python $archivo {$_POST['amplitud_modulante']} {$_POST['frecuencia_modulante']} {$_POST['amplitud_portadora']} {$_POST['frecuencia_portadora']} {$_POST['constante_modulacion']}";
	
	//~ echo "ejecucion: $ejecucion <br />";
}else{
	$ejecucion = "python $archivo";
}

$salida=shell_exec ($ejecucion);

if (trim($salida) == 'Error'){
	$salida='./imagenes/imagen_error.jpg';
	$senhal='Error: Espectro fuera de Rango';
}
//~ sleep (10);

//~ echo "Salida: $salida <br /><br /><br />";

$HTML = <<<ETIQUETA
	<img src="$salida" width="50%" height="50%" >
	<p><strong>$senhal</strong></p>
ETIQUETA;

echo $HTML;

?>
