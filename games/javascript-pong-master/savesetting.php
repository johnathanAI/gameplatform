<?php
session_start();
include("mysql_connect.php");

if(isset($_GET['selectSide']) || isset($_GET['ballColor']) || isset($_GET['leftPaddleColor']) || isset($_GET['rightPaddleColor']) || isset($_GET['leftPaddleHeight']) || isset($_GET['rightPaddleHeight']) || isset($_GET['ballSpeed']) || isset($_GET['ballRadius']) || isset($_GET['ballAccel'])){

  $selectSide = $_GET['selectSide'];
  $ballColor = $_GET['ballColor'];
  $leftPaddleColor = $_GET['leftPaddleColor'];
  $rightPaddleColor = $_GET['rightPaddleColor'];
  $leftPaddleHeight = $_GET['leftPaddleHeight'];
  $rightPaddleHeight = $_GET['rightPaddleHeight'];
  $ballSpeed = $_GET['ballSpeed'];
  $ballRadius = $_GET['ballRadius'];
  $ballAccel = $_GET['ballAccel'];

  $saveSelectSide = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'pong', 'selectSide', '$selectSide')";
  $saveBallColor = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'pong', 'ballColor', '$ballColor')";
  $saveLeftPaddleColor = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'pong', 'leftPaddleColor', '$leftPaddleColor')";
  $saveRightPaddleColor = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'pong', 'rightPaddleColor', '$rightPaddleColor')";
  $saveLeftPaddleHeight = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'pong', 'leftPaddleHeight', '$leftPaddleHeight')";
  $saveRightPaddleHeight = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'pong', 'rightPaddleHeight', '$rightPaddleHeight')";
  $saveBallSpeed = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'pong', 'ballSpeed', '$ballSpeed')";
  $saveBallRadius = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'pong', 'ballRadius', '$ballRadius')";
  $saveBallAccel = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'pong', 'ballAccel', '$ballAccel')";

  if(mysql_query($saveSelectSide) != false){
    mysql_query($saveSelectSide, $database);
  }
  else{
    $updateSelectSide = "UPDATE gameconfig SET value='$selectSide' WHERE parameter='selectSide' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateSelectSide, $database);
  }

  if(mysql_query($saveBallColor) != false){
    mysql_query($saveBallColor, $database);
  }
  else{
    $updateBallColor = "UPDATE gameconfig SET value='$ballColor' WHERE parameter='ballColor' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateBallColor, $database);
  }

  if(mysql_query($saveLeftPaddleColor) != false){
    mysql_query($saveLeftPaddleColor, $database);
  }
  else{
    $updateLeftPaddleColor = "UPDATE gameconfig SET value='$leftPaddleColor' WHERE parameter='leftPaddleColor' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateLeftPaddleColor, $database);
  }

  if(mysql_query($saveRightPaddleColor) != false){
    mysql_query($saveRightPaddleColor, $database);
  }
  else{
    $updateRightPaddleColor = "UPDATE gameconfig SET value='$rightPaddleColor' WHERE parameter='rightPaddleColor' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateRightPaddleColor, $database);
  }

  if(mysql_query($saveLeftPaddleHeight) != false){
    mysql_query($saveLeftPaddleHeight, $database);
  }
  else{
    $updateLeftPaddleHeight = "UPDATE gameconfig SET value='$leftPaddleHeight' WHERE parameter='leftPaddleHeight' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateLeftPaddleHeight, $database);
  }

  if(mysql_query($saveRightPaddleHeight) != false){
    mysql_query($saveRightPaddleHeight, $database);
  }
  else{
    $updateRightPaddleHeight = "UPDATE gameconfig SET value='$rightPaddleHeight' WHERE parameter='rightPaddleHeight' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateRightPaddleHeight, $database);
  }

  if(mysql_query($saveBallSpeed) != false){
    mysql_query($saveBallSpeed, $database);
  }
  else{
    $updateBallSpeed = "UPDATE gameconfig SET value='$ballSpeed' WHERE parameter='ballSpeed' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateBallSpeed, $database);
  }

  if(mysql_query($saveBallRadius) != false){
    mysql_query($saveBallRadius, $database);
  }
  else{
    $updateBallRadius = "UPDATE gameconfig SET value='$ballRadius' WHERE parameter='ballRadius' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateBallRadius, $database);
  }

  if(mysql_query($saveBallAccel) != false){
    mysql_query($saveBallAccel, $database);
  }
  else{
    $updateBallAccel = "UPDATE gameconfig SET value='$ballAccel' WHERE parameter='ballAccel' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateBallAccel, $database);
  }
}
else{
  $loadSelectSide = "SELECT value FROM gameconfig WHERE parameter='selectSide' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."' ";
  $loadBallColor = "SELECT value FROM gameconfig WHERE parameter='ballColor' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."' ";
  $loadLeftPaddleColor = "SELECT value FROM gameconfig WHERE parameter='leftPaddleColor' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."' ";
  $loadRightPaddleColor = "SELECT value FROM gameconfig WHERE parameter='rightPaddleColor' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."' ";
  $loadLeftPaddleHeight = "SELECT value FROM gameconfig WHERE parameter='leftPaddleHeight' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."' ";
  $loadRightPaddleHeight = "SELECT value FROM gameconfig WHERE parameter='rightPaddleHeight' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."' ";
  $loadBallSpeed = "SELECT value FROM gameconfig WHERE parameter='ballSpeed' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."' ";
  $loadBallRadius = "SELECT value FROM gameconfig WHERE parameter='ballRadius' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."' ";
  $loadBallAccel = "SELECT value FROM gameconfig WHERE parameter='ballAccel' AND gameName = 'pong' AND profileName ='".$_SESSION['login_user']."' ";

  $resultLoadSelectSide = mysql_query($loadSelectSide, $database);
  $countResultLoadSelectSide = mysql_num_rows($resultLoadSelectSide);

  $resultLoadBallColor = mysql_query($loadBallColor, $database);
  $countResultLoadBallColor = mysql_num_rows($resultLoadBallColor);

  $resultLeftPaddleColor = mysql_query($loadLeftPaddleColor, $database);
  $countResultLeftPaddleColor = mysql_num_rows($resultLeftPaddleColor);

  $resultRightPaddleColor = mysql_query($loadRightPaddleColor, $database);
  $countResultRightPaddleColor = mysql_num_rows($resultRightPaddleColor);

  $resultLoadLeftPaddleHeight = mysql_query($loadLeftPaddleHeight, $database);
  $countResultLoadLeftPaddleHeight = mysql_num_rows($resultLoadLeftPaddleHeight);

  $resultLoadRightPaddleHeight = mysql_query($loadRightPaddleHeight, $database);
  $countResultLoadRightPaddleHeight = mysql_num_rows($resultLoadRightPaddleHeight);

  $resultLoadBallSpeed = mysql_query($loadBallSpeed, $database);
  $countResultLoadBallSpeed = mysql_num_rows($resultLoadBallSpeed);

  $resultLoadBallRadius = mysql_query($loadBallRadius, $database);
  $countResultLoadBallRadius = mysql_num_rows($resultLoadBallRadius);

  $resultLoadBallAccel = mysql_query($loadBallAccel, $database);
  $countResultLoadBallAccel = mysql_num_rows($resultLoadBallAccel);

  if($countResultLoadSelectSide != 1){
    $selectSide = 'left';
  }
  else{
    $resultLoadSelectSide = mysql_query($loadSelectSide, $database);
    $rowSelectSide = mysql_fetch_array($resultLoadSelectSide,MYSQLI_ASSOC);
    $selectSide = $rowSelectSide['value'];
  }

  if($countResultLoadBallColor != 1){
    $ballColor = 'white';
  }
  else{
    $resultLoadBallColor = mysql_query($loadBallColor, $database);
    $rowBallColor = mysql_fetch_array($resultLoadBallColor,MYSQLI_ASSOC);
    $ballColor = $rowBallColor['value'];
  }

  if($countResultLeftPaddleColor != 1){
    $leftPaddleColor = 'white';
  }
  else{
    $resultLeftPaddleColor = mysql_query($loadLeftPaddleColor, $database);
    $rowLeftPaddleColor = mysql_fetch_array($resultLeftPaddleColor,MYSQLI_ASSOC);
    $leftPaddleColor = $rowLeftPaddleColor['value'];
  }

  if($countResultRightPaddleColor != 1){
    $rightPaddleColor = 'white';
  }
  else{
    $resultRightPaddleColor = mysql_query($loadRightPaddleColor, $database);
    $rowRightPaddleColor = mysql_fetch_array($resultRightPaddleColor,MYSQLI_ASSOC);
    $rightPaddleColor = $rowRightPaddleColor['value'];
  }

  if($countResultLoadLeftPaddleHeight != 1){
    $leftPaddleHeight = 220;
  }
  else{
    $resultLeftPaddleHeight = mysql_query($loadLeftPaddleHeight, $database);
    $rowLeftPaddleHeight = mysql_fetch_array($resultLeftPaddleHeight,MYSQLI_ASSOC);
    $leftPaddleHeight = $rowLeftPaddleHeight['value'];
  }

  if($countResultLoadRightPaddleHeight != 1){
    $rightPaddleHeight = 60;
  }
  else{
    $resultRightPaddleHeight = mysql_query($loadRightPaddleHeight, $database);
    $rowRightPaddleHeight = mysql_fetch_array($resultRightPaddleHeight,MYSQLI_ASSOC);
    $rightPaddleHeight = $rowRightPaddleHeight['value'];
  }

  if($countResultLoadBallSpeed != 1){
    $ballSpeed = 12;

  }
  else{
    $resultBallSpeed = mysql_query($loadBallSpeed, $database);
    $rowBallSpeed = mysql_fetch_array($resultBallSpeed,MYSQLI_ASSOC);
    $ballSpeed = $rowBallSpeed['value'];
  }

  if($countResultLoadBallRadius  != 1){
    $ballRadius = 12;
  }
  else{
    $resultBallRadius = mysql_query($loadBallRadius, $database);
    $rowBallRadius = mysql_fetch_array($resultBallRadius,MYSQLI_ASSOC);
    $ballRadius = $rowBallRadius['value'];

  }

  if($countResultLoadBallAccel  != 1){
    $ballAccel = 1;
  }
  else{
    $resultBallAccel = mysql_query($loadBallAccel, $database);
    $rowBallAccel = mysql_fetch_array($resultBallAccel,MYSQLI_ASSOC);
    $ballAccel = $rowBallAccel['value'];

  }

}
?>
