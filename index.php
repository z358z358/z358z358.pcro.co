<?php
require_once('lib/function.php');

$_current = $_route[$url[0]] ? $url[0] : 'main';

$html['_current'] = $_current;
$html['nav'] = $_route;

if(file_exists(__DIR__ . '/controller/' . $_current . '.php')){
	require __DIR__ . '/controller/' . $_current . '.php';
}

//die();
?>