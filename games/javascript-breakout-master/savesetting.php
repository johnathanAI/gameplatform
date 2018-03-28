<?php
session_start();
include("mysql_connect.php");

if(isset($_GET['paddleWidth']) || isset($_GET['ballSpeed']) || isset($_GET['ballRadius'])){

  $paddleWidth = $_GET['paddleWidth'];
  $ballSpeed = $_GET['ballSpeed'];
  $ballRadius = $_GET['ballRadius'];

  $savePaddleWidth = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'breakout', 'paddleWidth', '$paddleWidth')";
  $saveBallSpeed = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'breakout', 'ballSpeed', '$ballSpeed')";
  $saveBallRadius = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'breakout', 'ballRadius', '$ballRadius')";


  if(mysql_query($savePaddleWidth) != false){
    mysql_query($savePaddleWidth, $database);
  }
  else{
    $updatePaddleWidth = "UPDATE gameconfig SET value='$paddleWidth' WHERE parameter='paddleWidth' AND gameName = 'breakout' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updatePaddleWidth, $database);
  }

  if(mysql_query($saveBallSpeed) != false){
    mysql_query($saveBallSpeed, $database);
  }
  else{
    $updateBallSpeed = "UPDATE gameconfig SET value='$ballSpeed' WHERE parameter='ballSpeed' AND gameName = 'breakout' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateBallSpeed, $database);
  }

  if(mysql_query($saveBallRadius) != false){
    mysql_query($saveBallRadius, $database);
  }
  else{
    $updateBallRadius = "UPDATE gameconfig SET value='$ballRadius' WHERE parameter='ballRadius' AND gameName = 'breakout' AND profileName ='".$_SESSION['login_user']."'";
    mysql_query($updateBallRadius, $database);
  }
}
else{

  $loadPaddleWidth = "SELECT value FROM gameconfig WHERE parameter='paddleWidth' AND gameName = 'breakout' AND profileName ='".$_SESSION['login_user']."' ";
  $loadBallSpeed = "SELECT value FROM gameconfig WHERE parameter='ballSpeed' AND gameName = 'breakout' AND profileName ='".$_SESSION['login_user']."' ";
  $loadBallRadius = "SELECT value FROM gameconfig WHERE parameter='ballRadius' AND gameName = 'breakout' AND profileName ='".$_SESSION['login_user']."' ";

  $resultLoadPaddleWidth = mysql_query($loadPaddleWidth, $database);
  $countResultLoadPaddleWidth = mysql_num_rows($resultLoadPaddleWidth);

  $resultLoadBallSpeed = mysql_query($loadBallSpeed, $database);
  $countResultLoadBallSpeed = mysql_num_rows($resultLoadBallSpeed);

  $resultLoadBallRadius = mysql_query($loadBallRadius, $database);
  $countResultLoadBallRadius = mysql_num_rows($resultLoadBallRadius);


  if($countResultLoadPaddleWidth != 1){
    $paddleWidth = 10;
  }
  else{
    $resultPaddleWidth = mysql_query($loadPaddleWidth, $database);
    $rowPaddleWidth = mysql_fetch_array($resultPaddleWidth,MYSQLI_ASSOC);
    $paddleWidth = $rowPaddleWidth['value'];
  }

  if($countResultLoadBallSpeed != 1){
    $ballSpeed = 10;

  }
  else{
    $resultBallSpeed = mysql_query($loadBallSpeed, $database);
    $rowBallSpeed = mysql_fetch_array($resultBallSpeed,MYSQLI_ASSOC);
    $ballSpeed = $rowBallSpeed['value'];
  }

  if($countResultLoadBallRadius != 1){
    $ballRadius = 0.5;
  }
  else{
    $resultBallRadius = mysql_query($loadBallRadius, $database);
    $rowBallRadius = mysql_fetch_array($resultBallRadius,MYSQLI_ASSOC);
    $ballRadius = $rowBallRadius['value'];

  }

}
?>
