<?php
	session_start();
	unset($_SESSION['sesion']);
	header("Location:http://{$_SERVER['SERVER_NAME']}/siceac/");
?>
