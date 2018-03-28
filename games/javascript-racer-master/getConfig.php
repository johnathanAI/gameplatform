<?php
session_start();
include("mysql_connect.php");

function getConfig(){
		$getParameter = "SELECT * FROM gameconfig WHERE profileName='".$_SESSION['login_user']."' AND gameName='outrun'";
		$result = mysql_query($getParameter);
		$rows = array();
		while($r = mysql_fetch_assoc($result)) {
			$rows[] = $r;
		}
		echo json_encode($rows);
		//echo json_encode($display);
	}
	getConfig();
?>	
