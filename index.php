<?php
/**
 * This uses RedBeanPHP to get a variable from our database
 * When the right parameter has been passed as a hostname,
 * it will redirect to the right infoscreen
 */
include_once("config.php");
include_once("rb.php");

// Trailing slash
define('BASE_URL', 'https://s.flatturtle.com/');

// Get the hostname
$hostname = trim($_GET['hostname']);

$url = "https://flatturtle.com";
// Talk to the database
if(isset($hostname) && $hostname != ""){
	R::setup("mysql:host=$dbhost;dbname=$db",$dbuser,$dbpass);
	$needles = R::find('infoscreen',' hostname = ?', array( $hostname ));
	foreach($needles as $needle){
		$infoscreen = $needle["alias"];
		$version = $needle["version"];
		if($version == "testing"){
			$url = "http://testing.s.flatturtle.com/" . $infoscreen . "/";
		}else{
			$url = BASE_URL . $infoscreen . "/view/" . $version . "/";
		}
	}
}

header('Location: '. $url);