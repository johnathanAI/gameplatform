<?php

	//Set up mySQL
	//location of the server
	$db_server = "localhost";
	//database name
	$db_name = "bme3s02";
	//account
	$db_user = "root";
	//password
	$db_passwd = "";

	$database = mysql_connect($db_server, $db_user, $db_passwd);

	//Database connection
	if(!@$database)
			die("Failed to connect to MySQL");

	//use UTF8 encoding
	mysql_query("SET NAMES utf8");

	//choose database
	if(!@mysql_select_db($db_name))
		die("Failed to connect to database");
?>
