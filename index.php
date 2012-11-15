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

$url = "";
//Talk to the database
if(isset($hostname) && $hostname != ""){
	R::setup("mysql:host=localhost;dbname=$db",$dbuser,$dbpass);
	$haystack = $hostname;
	$needles = R::find('infoscreens',' hostname = ?', array( $haystack ));
	foreach($needles as $needle){
		$infoscreen = $needle["alias"];
		$version = $needle["version_tag"];
                if($version == "testing"){
                    $url = "http://testing.s.flatturtle.com/" . $infoscreen;
                }else{
		    $url = "https://s.flatturtle.com/" . $version . "/" . $infoscreen;
                }
	}
	if(sizeof($needles) == 0){
		$url = "https://s.flatturtle.com/stable/";
	}
}else{
	$url = "https://s.flatturtle.com/stable/";
}
?>

<!doctype html>
<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>FlatTurtle</title>
		<!-- For iPhone 4 -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://www.flatturtle.com/themes/site/img/apple-touch-icon-114.png">
		<!-- For iPad 1-->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://www.flatturtle.com/themes/site/img/apple-touch-icon-72.png">
		<!-- For everything else -->
		<link rel="shortcut icon" href="https://www.flatturtle.com/themes/site/img/favicon.ico">
		<link rel="stylesheet" href="https://my.flatturtle.com/assets/css/style.css" type="text/css" media="screen" />
		<link type="text/css" rel="stylesheet" href="https://fast.fonts.com/cssapi/66253153-9c89-413c-814d-60d3ba0d6ac2.css"/>
		<!--[if lte IE 8]><link rel="stylesheet" href="https://my.flatturtle.com/assets/css/ie7-font-awesome.css" type="text/css" media="screen" /><![endif]-->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
		<script type="text/javascript">
                        window.setTimeout(function(){
                                location = "<?php echo $url; ?>";
                            }, 1000*60*<?php echo $timetoredirect; ?>);


			if (typeof jQuery == 'undefined'){
				document.write(unescape("%3Cscript src='https://my.flatturtle.com/assets/js/jquery-min.js' type='text/javascript'%3E%3C/script%3E"));
			}
			!window.jQuery.ui && document.write(unescape("%3Cscript src='https://my.flatturtle.com/assets/js/jquery-ui-min.js type='text/javascript'%3E%3C/script%3E"))
		</script>
	</head>
	<body>


<div class="wrapper">
			<div class="container">
				<div class="row">
					<div class="span8">
						<header role="banner">
							<hgroup>
								<h1><img src="https://my.flatturtle.com/assets/img/logo_320_2x.gif" alt="FlatTurtle" /></h1>
							</hgroup>
						</header>
					</div>
				</div>
			</div>
			<div class="grey_wrapper">
				<div class="container">
<div class='row'>
	<div class='span12'>
		<h2>
                       Your Turtle is being configured.
		</h2>


	</div>
</div>
			</div>
		</div>
	</div>
	<footer role="footer">
		<div class="container">
			<div class="row">
				<div class="span12">
					&copy; 2012 <a href="https://flatturtle.com" target="_blank">FlatTurtle</a> - Some rights reserved
<!--
                                                   Are you a developer who would like to know more about FlatTurtle?
                                                   Did you know you can control your FlatTurtle through an API?
                                                   Did you know you can write your own turtles and panes?
                                                   Get in touch with us at
                                                      http://dev.FlatTurtle.com
                                                   or mail us at
                                                      info@flatturtle.com
-->
				</div>
			</div>
		</div>
	</footer>
</body>
</html>

