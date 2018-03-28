<?php
session_start();
include("mysql_connect.php");

function saveConfig(){
	if(isset($_GET['roadWidth']) || isset($_GET['totalCars']) || isset($_GET['maxSpeed']) || isset($_GET['maxTime']) ){

	  $roadWidth = $_GET['roadWidth'];
	  $totalCars = $_GET['totalCars'];
	  $maxSpeed = $_GET['maxSpeed'];
	  $maxTime = $_GET['maxTime'];
	  //$backgroundImg = $_GET['backgroundImg'];
	  //$sprites = $_GET['sprites'];
	  try{
	  $getCurrentState = "Select * FROM gameconfig WHERE gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."';";
	  $currentResult = mysql_query($getCurrentState);
		if (!$currentResult) {
			die('Invalid query: ' . mysql_error());
		}
	  $Row=mysql_num_rows($currentResult);
	  
	  
	  if ($Row > 0)
      {
	  
	  //$saveBackgroundImg = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'outrun', 'backgroundImg', '$backgroundImg')";
	  //$saveSprites = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'outrun', 'sprites', '$backgroundImg')";
	  
	  $updateRoadWidth = "UPDATE gameconfig SET value='$roadWidth' WHERE parameter='roadWidth' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."'";
	  $updateTotalCars = "UPDATE gameconfig SET value='$totalCars' WHERE parameter='totalCars' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."'";
	  $updateMaxSpeed = "UPDATE gameconfig SET value='$maxSpeed' WHERE parameter='maxSpeed' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."'";
	  
	  mysql_query($updateRoadWidth);
	  mysql_query($updateTotalCars);
	  mysql_query($updateMaxSpeed);
	  }
	  
	  else{
		   $saveRoadWidth = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'outrun', 'roadWidth', '$roadWidth')";
	       $saveTotalCars = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'outrun', 'totalCars', '$totalCars')";
	       $saveMaxSpeed = "INSERT INTO gameconfig (profileName, gameName, parameter, value) VALUES ('".$_SESSION['login_user']."', 'outrun', 'maxSpeed', '$maxSpeed')";
		  
		  mysql_query($saveRoadWidth);
	      mysql_query($saveTotalCars);
	      mysql_query($saveMaxSpeed);
	  }
	  }
	  catch (Exception $e) {
    	echo json_encode('Caught exception: '.$e->getMessage()."\n");
		}
	/*
	  if(mysql_query($saveRoadWidth) != false){
	    mysql_query($saveRoadWidth);
	  }
	  else{
	    $updateRoadWidth = "UPDATE gameconfig SET value='$roadWidth' WHERE parameter='roadWidth' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."'";
	    mysql_query($updateRoadWidth);
	  }
	
	  if(mysql_query($saveTotalCars) != false){
	    mysql_query($database, $saveTotalCars);
	  }
	  else{
	    $updateTotalCars = "UPDATE gameconfig SET value='$totalCars' WHERE parameter='totalCars' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."'";
	    mysql_query($updateTotalCars);
	  }
	
	  if(mysql_query($saveMaxSpeed) != false){
	    mysql_query($database, $saveMaxSpeed);
	  }
	  else{
	    $updateMaxSpeed = "UPDATE gameconfig SET value='$maxSpeed' WHERE parameter='maxSpeed' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."'";
	    mysql_query($updateMaxSpeed);
	  }
	*/
	//  if(mysqli_query($database, $saveBackgroundImg) != false){
	//    mysqli_query($database, $saveBackgroundImg);
	//  }
	//  else{
	//    $updateBackgroundImg = "UPDATE gameconfig SET value='$backgroundImg' WHERE parameter='backgroundImg' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."'";
	//    mysqli_query($database, $updateBackgroundImg);
	//  }
	
	//  if(mysqli_query($database, $saveSprites) != false){
	//    mysqli_query($database, $saveSprites);
	//  }
	//  else{
	//    $updateSprites = "UPDATE gameconfig SET value='$sprites' WHERE parameter='sprites' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."'";
	//    mysqli_query($database, $updateSprites);
	//  }
	
	  // echo json_encode($roadWidth.' ; '.$totalCars.' ; '.$maxSpeed);
	}
}
/*
else {
  $loadRoadWidth = "SELECT value FROM gameconfig WHERE parameter='roadWidth' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."' ";
  $loadTotalCars = "SELECT value FROM gameconfig WHERE parameter='totalCars' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."' ";
  $loadMaxSpeed = "SELECT value FROM gameconfig WHERE parameter='maxSpeed' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."' ";
//  $loadBackgroundImg = "SELECT value FROM gameconfig WHERE parameter='backgroundImg' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."' ";
//  $loadSprites = "SELECT value FROM gameconfig WHERE parameter='sprites' AND gameName = 'outrun' AND profileName ='".$_SESSION['login_user']."' ";

  $resultLoadRoadWidth = mysql_query($database, $loadRoadWidth);
  //echo $resultLoadRoadWidth;
  $countResultLoadRoadWidth = mysql_num_rows($resultLoadRoadWidth);

  $resultLoadTotalCars = mysql_query($database, $loadTotalCars);
  //echo $resultLoadTotalCars;
  $countResultLoadTotalCars = mysql_num_rows($resultLoadTotalCars);

  $resultLoadMaxSpeed = mysql_query($database, $loadMaxSpeed);
  //echo $resultLoadMaxSpeed;
  $countResultLoadMaxSpeed = mysql_num_rows($resultLoadMaxSpeed);

//  $resultLoadBackgroundImg = mysqli_query($database, $loadBackgroundImg);
//  $countResultLoadBackgroundImg = mysqli_num_rows($resultLoadBackgroundImg);

//  $resultLoadSprites = mysqli_query($database, $loadSprites);
//  $countResultLoadSprites = mysqli_num_rows($resultLoadSprites);

  if($countResultLoadRoadWidth != 1){
    $roadWidth = 2000;
  }
  else{
    $resultRoadWidth = mysql_query($database, $loadRoadWidth);
    $rowRoadWidth = mysql_fetch_array($resultRoadWidth,MYSQLI_ASSOC);
    $roadWidth = $rowRoadWidth['value'];
  }

  if($countResultLoadTotalCars != 1){
    $totalCars = 100;
  }
  else{
    $resultTotalCars = mysql_query($database, $loadTotalCars);
    $rowTotalCars = mysql_fetch_array($resultTotalCars,MYSQLI_ASSOC);
    $totalCars = $rowTotalCars['value'];
  }

  if($countResultLoadMaxSpeed != 1){
    $maxSpeed = 6000;
  }
  else{
    $resultMaxSpeed = mysql_query($database, $loadMaxSpeed);
    $rowMaxSpeed = mysql_fetch_array($resultMaxSpeed,MYSQLI_ASSOC);
    $maxSpeed = $rowMaxSpeed['value'];
  }
  $maxTime = 60;

//  if($countResultLoadBackgroundImg != 1){
//    $backgroundImg = "background1";
//  }
//  else{
//    $resultBackgroundImg = mysqli_query($database, $loadBackgroundImg);
//    $rowBackgroundImg = mysqli_fetch_array($resultBackgroundImg,MYSQLI_ASSOC);
//    $backgroundImg = $rowBackgroundImg['value'];
//  }

//  if($countResultLoadSprites != 1){
//    $sprites = "sprites1";
//  }
//  else{
//    $resultSprites = mysqli_query($database, $loadSprites);
//    $rowSprites = mysqli_fetch_array($resultSprites,MYSQLI_ASSOC);
//    $sprites = $rowSprites['value'];
//  }

}
*/
		return saveconfig();
?>