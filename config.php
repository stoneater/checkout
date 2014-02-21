<!DOCTYPE html>
<html>
<head>
<title>Linux Powered Checkout system</title>
<link rel="SHORTCUT ICON" href="favicon.ico">
<meta charset="UTF-8">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link href="css/south-street/jquery-ui-1.10.3.custom.css" rel="stylesheet">
<link rel="stylesheet" href="css/print.css" >
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>

</head>
<body>
<?php

//General options...

//MySQL database options...
$db_server = "localhost"; 
$db_username = "helpdesk";
$db_password = "helpdesk";
$db_database = "checkout";

//Other global variables...

date_default_timezone_set('America/Chicago');

//set default, or first type chosen
$type=4;

//set to True to turn on all debug commands, and False for normal operation.
$debug = False;
//$debug = True;

//set all variables without needing get or post
//has benefit of listing all global variables!
if ($debug){ 
	echo "Debugging is turned on!<br>";
	ini_set('display_errors',1);
} else {
	ini_set('display_errors',0);
}
// end set debugging 

?>
