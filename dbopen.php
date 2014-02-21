<?php
//Connect to database server...

$mysqli = new mysqli($db_server,$db_username,$db_password,$db_database);
if ($mysqli->connect_errno) echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
if($debug) echo $mysqli->host_info . ".<br>";

//open for mysqli queries

?>
