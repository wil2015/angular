<?php

// Connection variables 
$host = "localhost"; // MySQL host name eg. localhost
$user = "root"; // MySQL user. eg. root ( if your on localserver)
$password = ""; // MySQL user password  (if password is not set for your root user then keep it empty )
$database = "magento"; // MySQL Database name

$bdServidor = 'localhost';
$bdUsuario = 'root';
$bdSenha = '';
$bdBanco = 'magento';
if ($_SERVER['SERVER_NAME'] == "localhost") {
	$bdServidor = 'localhost';
	$bdUsuario = 'root';
	$bdSenha = '';
	$bdBanco = 'magento';}
	else {
		$bdServidor = 'ip-172-31-21-17';
		$bdServidor = 'ec2-54-209-29-39.compute-1.amazonaws.com';
		$bdServidor = 'localhost';
		$bdUsuario = 'bn_magento';
		$bdUsuario = 'root';
		$bdSenha = 'SatKER3rT8pP';
		$bdBanco = 'bitnami_magento';};

$conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);
if (mysqli_connect_errno($conexao)) {
	echo "Problemas para conectar no banco. Verifique os dados! \n" . "==" . $_SERVER['SERVER_NAME'] . "==".  mysqli_connect_error();
	
	die();
}




//mysql_query("SET NAMES utf8");


?>