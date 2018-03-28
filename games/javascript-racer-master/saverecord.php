<?php
session_start();
include("mysql_connect.php");

    $playTime = $_POST['playTime'];
    $fastestLapTime = $_POST['fastestLapTime'];
    $latestLapTime = $_POST['latestLapTime'];
	$crashTime = $_POST['crashTime'];
    $date = date("Y-m-d H:i:s", strtotime('+7 hours'));
    $savePlayTimeRecord = "INSERT INTO gamerecord (profileName, gameName, record, value, date) VALUES ('".$_SESSION['login_user']."', 'Outrun', 'Played Time', '$playTime minutes',  '$date')";
    $saveFastestLapTimeRecord = "INSERT INTO gamerecord (profileName, gameName, record, value, date) VALUES ('".$_SESSION['login_user']."', 'Outrun', 'Fastest Lap Time', '$fastestLapTime',  '$date')";
    $saveLatestLapTimeRecord = "INSERT INTO gamerecord (profileName, gameName, record, value, date) VALUES ('".$_SESSION['login_user']."', 'Outrun', 'Latest Lap Time', '$latestLapTime',  '$date')";
	$saveCrashTime = "INSERT INTO gamerecord (profileName, gameName, record, value, date) VALUES ('".$_SESSION['login_user']."', 'Outrun', 'No of crash', '$crashTime',  '$date')";
    mysql_query($savePlayTimeRecord);
    mysql_query($saveFastestLapTimeRecord);
    mysql_query($saveLatestLapTimeRecord);
    mysql_query($saveCrashTime);
 ?>
