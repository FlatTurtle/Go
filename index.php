<?php
/**
 * This uses RedBeanPHP to get a variable from our database
 * When the right parameter has been passed as a hostname,
 * it will redirect to the right infoscreen
 */
include_once("config.php");
include_once("rb.php");

//get the hostname
$g = array_keys($_GET);
$strs = "";
if(isset($g[0])){
	$strs = $g[0];
}
$stra = explode("/",$strs);
$hostname = "";
if(isset($stra[1])){
	$hostname = $stra[1];
}

//Talk to the database
if(isset($hostname) && $hostname != ""){
	R::setup("mysql:host=localhost;dbname=$db",$dbuser,$dbpass);
	$haystack = $hostname;
	$needles = R::find('infoscreens',' hostname = ?', array( $haystack ));
	foreach($needles as $needle){
		$infoscreen = $needle["alias"];
		$version = $needle["version_tag"];
                if($version == "testing"){
                    header("location: http://ftinfoscreen-testing.pagodabox.com/" . $infoscreen);
                }else{
		    header("location: http://s.flatturtle.com/" . $version . "/" . $infoscreen);
                }
	}
	if(sizeof($needles) == 0){
		header("location: http://s.flatturtle.com/stable/");
	}
}else{
	header("location: http://s.flatturtle.com/stable/");
}

?>
