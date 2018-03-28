<?php
//session_start();
include("mysql_connect.php");
?>
<script>
function progressChange(e) {
    var postData = $(this).serializeArray();
	var ballColor = $("#ballColor").val();
	var leftPaddleColor = $("#leftPaddleColor").val();
	
	
	
    $.ajax(
    {
        url : "savesetting.php",
        type: "GET",
		crossDomain: true,
        data : "postData="+postData+"&ballColor="+ballColor+"&maxSpeed="+maxSpeed+"&totalCars="+totalCars+"&maxTime="+maxTime+"&crashTime="+crashTime,
        success:function(data) 
        {
        	console.log ('ajax call success');
			//data: return data from server
        },
        error: function(data) 
        {
            //if fails   
            alert('it didnt work');   
        }
    });
};

</script>
<div id="sidebar" style="width: 22em; margin-right:20px; height: 36em;">
  <h2>Pong!</h2>
  <div class='description'>
    <p style="font-size:15px;">
      Press <b>1</b> for a single player game.<br>
      Press <b>2</b> for a double player game.<br>
    </p>
    <p style="font-size:15px;">
      <b>Esc</b> can be used to abandon a game.
    </p>
  </div>
  <div class='settings'>
    <label for='sound'>sound: </label>
    <input type='checkbox' id='sound'checked>
  </div>
  <!--
  <div class='settings'>
  <label for='stats'>stats: </label>
  <input type='checkbox' id='stats' checked>
</div>
-->
<div class='settings'>
  <label for='footprints'>footprints: </label>
  <input type='checkbox' id='footprints'>
</div>
<br/>
<form action="index.php" method="GET" id="settingsForm" name="settingsForm">
  <label for="selectSide">Select Slides</label>
  <select name="selectSide" style="color:black;">
    <option  class="Select-input-side"><?php if(isset($_GET['selectSide'])){ echo $_GET['selectSide']; } else { echo $selectSide; } ?></option>
    <option value="Left">Left</option>
    <option value="Right">Right</option>
  </select><br/>
  <label for="ballColor">Ball Color</label>
  <select name="ballColor" style="color:black;">
    <option  class="Select-input-ball"><?php if(isset($_GET['ballColor'])){ echo $_GET['ballColor']; } else { echo $ballColor; } ?></option>
    <option value="White">White</option>
    <option value="Red">Red</option>
    <option value="Orange">Orange</option>
    <option value="Yellow">Yellow</option>
    <option value="Green">Green</option>
    <option value="Blue">Blue</option>
    <option value="Purple">Purple</option>
  </select><br/>
  <label for="leftPaddleColor">left Paddle Color</label>
  <select  name="leftPaddleColor" style="color:black;">
    <option class="Select-input-leftpaddlecolor"><?php if(isset($_GET['leftPaddleColor'])){ echo $_GET['leftPaddleColor']; } else { echo $leftPaddleColor; } ?></option>
    <option value="White">White</option>
    <option value="Red">Red</option>
    <option value="Orange">Orange</option>
    <option value="Yellow">Yellow</option>
    <option value="Green">Green</option>
    <option value="Blue">Blue</option>
    <option value="Purple">Purple</option>
  </select><br/>
  <label for="rightPaddleColor">left Paddle Color</label>
  <select  name="rightPaddleColor" style="color:black;">
    <option class="Select-input-rightpaddlecolor"><?php if(isset($_GET['rightPaddleColor'])){ echo $_GET['rightPaddleColor']; } else { echo $rightPaddleColor; } ?></option>
    <option value="White">White</option>
    <option value="Red">Red</option>
    <option value="Orange">Orange</option>
    <option value="Yellow">Yellow</option>
    <option value="Green">Green</option>
    <option value="Blue">Blue</option>
    <option value="Purple">Purple</option>
  </select><br/>
  <label for="leftPaddleHeight">Left Paddle Height</label>
  <input type="range" name="leftPaddleHeight" min="60" max="400" value=<?php if(isset($_GET['leftPaddleHeight'])){ echo $_GET['leftPaddleHeight']; } else { echo $leftPaddleHeight; }?>>
  <label for="rightPaddleHeight">Right Paddle Height</label>
  <input type="range" name="rightPaddleHeight" min="60" max="400" value=<?php if(isset($_GET['rightPaddleHeight'])){ echo $_GET['rightPaddleHeight']; } else { echo $rightPaddleHeight; }?>>
  <label for="ballSpeed">Ball Slow Down</label>
  <input type="range" name="ballSpeed" min="4" max="20" value=<?php if(isset($_GET['ballSpeed'])){ echo $_GET['ballSpeed']; } else { echo $ballSpeed; }?>>
  <label for="ballRadius">Ball Size</label>
  <input type="range" name="ballRadius" min="5" max="20" value=<?php if(isset($_GET['ballRadius'])){ echo $_GET['ballRadius']; } else { echo $ballRadius; }?>>
  <label for="ballAccel">Difficulty</label>
  <input type="range" name="ballAccel" min="0" max="8" value=<?php if(isset($_GET['ballAccel'])){ echo $_GET['ballAccel']; } else { echo $ballAccel; }?>>
  <input type="hidden" value="Apply" id="submit" class="btn btn-primary" name="submit" style="float:right;">
</form>
</div>
