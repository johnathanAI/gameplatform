<?php
session_start();
include("mysql_connect.php");

    $playTime = $_POST['playTime'];
    $highScores = $_POST['highScores'];
    $latestScores = $_POST['latestScores'];
    $date = date("Y-m-d H:i:s", strtotime('+7 hours'));
    $savePlayTimeRecord = "INSERT INTO gamerecord (profileName, gameName, record, value, date) VALUES ('".$_SESSION['login_user']."', 'Breakout', 'Played Time', '$playTime minutes',  '$date')";
    $saveHighScoresRecord = "INSERT INTO gamerecord (profileName, gameName, record, value, date) VALUES ('".$_SESSION['login_user']."', 'Breakout', 'Highest Scores', '$highScores points',  '$date')";
    $saveLatestScoresRecord = "INSERT INTO gamerecord (profileName, gameName, record, value, date) VALUES ('".$_SESSION['login_user']."', 'Breakout', 'Latest Scores', '$latestScores points',  '$date')";
    mysql_query($savePlayTimeRecord, $database);
    mysql_query($saveHighScoresRecord, $database);
    mysql_query($saveLatestScoresRecord, $database);

 ?>
