<?php
require 'environment.php';

global $config;
$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://mepi.ind.br/framework");
	$config['dbname'] = 'mepiind_sismepi';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'mepiind_std_app';
	$config['dbpass'] = 'A8*eivsdCH0F';
	$config['jwt_scret_key'] = 'DAS*UDYAUSD%AUSD66584$%%$#@$DSDFSASDT@';
} else {
		define("BASE_URL", "http://mepi.ind.br/framework");
	$config['dbname'] = 'mepiind_sismepi';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'mepiind_std_app';
	$config['dbpass'] = 'A8*eivsdCH0F';
	$config['jwt_scret_key'] = 'DAS*UDYAUSD%AUSD66584$%%$#@$DSDFSASDT@';
}

global $db;
try {
    
    $options = [
	PDO::ATTR_CASE => PDO::CASE_UPPER,
	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ];
    
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass'], $options);
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}