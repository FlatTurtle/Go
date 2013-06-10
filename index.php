<?php
/**
 * General redirect script for all screens
 * When the right parameter has been passed as a hostname,
 * it will redirect to the matched infoscreen
 *
 * @author: Michiel Vancoillie (michiel@irail.be)
 */

// Include config & redbean
include_once("config.php");
include_once("rb.php");

// Base URL with trailing slash
define('BASE_URL', 'http://s.flatturtle.com/');

// Get the hostname
$hostname = trim($_GET['hostname']);

// Default url
$url = BASE_URL . "demo/view/";

// Did we receive a hostname?
if(isset($hostname) && $hostname != ""){

    // Talk to the database
    R::setup("mysql:host=$dbhost;dbname=$db", $dbuser, $dbpass);
    $screen = R::findOne('infoscreen', ' hostname = ?', array($hostname));

    // Do we have a match?
    if(!empty($screen)){
        // Get first match
        $alias = $screen["alias"];
        $version = $screen["version"];

        // Check sleep state
        $sleep = false;
        $power = R::findOne('plugin', ' infoscreen_id = ? AND  type = "power"', array($screen["id"]));

        if(!empty($power) && $power['state'] == 0){
            $sleep = true;
        }


        // Build URL
        if(!$sleep){
            if($version == "testing"){
                // Redirect to test version
                $url = "https://test.flatturtle.com/" . $alias . "/view/";
            }else{
                // Go to a specific version
                $url = BASE_URL . $alias . "/view/" . $version . "/";
            }
        }else{
            // Redirect to sleep page
            $url = BASE_URL . $alias . "/view/sleep/";
        }


    }
}

// To space and beyond!
header('Location: ' . $url);