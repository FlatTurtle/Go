<?php
/**
 * This uses RedBeanPHP to get a variable from our database
 * When the right parameter has been passed as a hostname,
 * it will redirect to the right infoscreen
 */
include_once("config.php");
include_once("rb.php");

// Trailing slash
define('BASE_URL', 'http://s.flatturtle.com/');

// Get the hostname
$hostname = trim($_GET['hostname']);

$url = BASE_URL . "demo/view/";

// Talk to the database
if(isset($hostname) && $hostname != ""){
	R::setup("mysql:host=$dbhost;dbname=$db",$dbuser,$dbpass);
	$needles = R::find('infoscreen',' hostname = ?', array( $hostname ));
	foreach($needles as $needle){
		$infoscreen = $needle["alias"];
		$version = $needle["version"];
		if($version == "testing"){
			$url = "https://test.flatturtle.com/" . $infoscreen . "/view/";
		}else{
			$url = BASE_URL . $infoscreen . "/view/" . $version . "/";
		}
	}
}

header('Location: '. $url);