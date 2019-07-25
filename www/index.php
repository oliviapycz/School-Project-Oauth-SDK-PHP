<?php

session_start();

require "conf.inc.php";

function myAutoloader($class){
	//est ce que la class que l'on essaye d'instancier existe dans
	//le dossier core
	$pathCore = "core/".$class.".class.php";
	$pathModels = "models/".$class.".class.php";
	if( file_exists($pathCore) ){
		include $pathCore;
	}else if ( file_exists($pathModels) ){
		include $pathModels;
	}
}
//Appel la fonction myAutoloader si on essaye une instance d'une class
//qui n'existe pas
spl_autoload_register("myAutoloader");

//Comment faire pour récupérer le slug
//Utilisation de la variable super globale SERVER
//c'est une variable créée par le server et alimenté
//aussi par le server. On ne doit que la consulter.
//Elles commencent par $_ et sont en majuscules 
//$_SERVER["REQUEST_URI"] => /users/add
$slug = $_SERVER["REQUEST_URI"];

//Suppression des GET dans l'url
$slugExploded = explode("?", $slug);
$slug = $slugExploded[0];


//Récupère la route correspondant au slug
$route = Routing::getRoute($slug);
if(is_null($route)){
	die("L'url n'existe pas");
}
//Transforme un tableau en une multitude de variable prenant pour nom les clés
extract($route);


//Vérifier que le fichier et la class controller existe
if( file_exists($cPath) ){
	include $cPath;
	if( class_exists($c)){
		//Instance dynamique du controller
		$cObject = new $c();
		//Vérification de l'existance de la méthode
		if( method_exists($cObject, $a) ) {
			//Appel de la méthode	
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

