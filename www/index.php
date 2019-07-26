<?php

session_start();

require "conf.inc.php";

function myAutoloader($class){
	//est ce que la class que l'on essaye d'instancier existe dans
	//le dossier core
	$pathCore = "core/".$class.".class.php";
	$pathModels = "models/".$class.".class.php";
	$pathProviders = "core/Provider/$class.php";
	if( file_exists($pathCore) ){
		include $pathCore;
	}else if ( file_exists($pathModels) ){
		include $pathModels;
	}else if ( file_exists($pathProviders) ){
        include $pathProviders;
    }
}

spl_autoload_register("myAutoloader");

$slug = $_SERVER["REQUEST_URI"];

$slugExploded = explode("?", $slug);
$slug = $slugExploded[0];


$route = Routing::getRoute($slug);
if(is_null($route)){
	die("L'url n'existe pas");
}

extract($route);


if( file_exists($cPath) ){
	include $cPath;
	if( class_exists($c)){
		$cObject = new $c();
		if( method_exists($cObject, $a) ) {
			$cObject->$a();
		}else{
			die("L'action ".$a." n'existe pas");
		}
	}else{
		die("La class ".$c." n'existe pas");
	}
}else{
	die("Le fichier controller ".$c." n'existe pas");
}

