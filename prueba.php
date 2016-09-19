<?php

	//~ $salida=shell_exec ("python bacaskend.py");
	//~ $salida = exec("python backend.py");
	//exec("python /var/www/modulacion/backend.py", $salida);
	
	
	$salida=shell_exec ("python ./modulos_python/DSB-LC/modulada.py");
	//~ $devuelve=exec("sh run.sh");
$HTML="<img src='$salida'/>";



echo $salida;
echo ".....".strlen($salida);;
	
	
	
?>

