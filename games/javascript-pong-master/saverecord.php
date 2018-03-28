<?php
session_start();
include("mysql_connect.php");

    $playTime = $_POST['playTime'];
    $scores = $_POST['scores'];
    $date = date("Y-m-d H:i:s", strtotime('+7 hours'));
    $savePlayTimeRecord = "INSERT INTO gamerecord (profileName, gameName, record, value, date) VALUES ('".$_SESSION['login_user']."', 'Pong', 'Played Time', '$playTime minutes',  '$date')";
    $saveScoresRecord = "INSERT INTO gamerecord (profileName, gameName, record, value, date) VALUES ('".$_SESSION['login_user']."', 'Pong', 'Scores', '$scores',  '$date')";
    mysql_query($savePlayTimeRecord, $database);
    mysql_query($saveScoresRecord, $database);
 ?>
