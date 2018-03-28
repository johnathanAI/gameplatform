<?php
//session_start();
include("mysql_connect.php");
?>
<script>
function progressChange(e) {
    var postData = $(this).serializeArray();
	var roadWidth = $("#roadWidth").val();
	var maxSpeed = $("#maxSpeed").val();
	var totalCars = $("#totalCars").val();
	var maxTime = $("#maxTime").val();
	var crashTime = $("#crashTime").val();
    $.ajax(
    {
        url : "savesetting.php",
        type: "GET",
		crossDomain: true,
        data : "postData="+postData+"&roadWidth="+roadWidth+"&maxSpeed="+maxSpeed+"&totalCars="+totalCars+"&maxTime="+maxTime+"&crashTime="+crashTime,
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
<div id="sidebar">
  <h2>Outrun!</h2>
  <table id="controls" style="margin-right:20px">
    <tr><td id="fps" colspan="2" align="right"></td></tr>
  </table>
  <form method="GET" id="settingsForm" name="settingsForm">
    <div>
      <select id="lanes" name="lanes">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option selected>4</option>
      </select>
    </div>
    <label for="roadWidth">Car Size (<span id="currentRoadWidth"></span>) :</label>
    <input id="roadWidth" onchange="progressChange(event)"  name="roadWidth" type='range' min='500' max='3000' title="integer (500-3000)" >
    <label for="totalCars">total Cars (<span id="currenttotalCars"></span>) :</label></th>
    <input id="totalCars" onchange="progressChange(event)"  name="totalCars" type='range' min='1' max='200' title="integer (0-200)" >
    <label for="maxSpeed">Max Speed (<span id="currentmaxSpeed"></span>) :</label></th>
    <input id="maxSpeed" onchange="progressChange(event)"  name="maxSpeed" type='range' min='1' max='12000' title="integer (0-6000)" >
    <label for="maxTime">Max Time[sec] (<span id="currentmaxTime"></span>) :</label></th>
    <input id="maxTime" onchange="progressChange(event)"  name="maxTime" type='range' min='3' max='180' title="integer (0-6000)" >

	<label for="crashTime">Crash [times] (<span id="allowcrashTime"></span>) :</label></th>
    <input id="crashTime" onchange="progressChange(event)" default="" name="crashTime" type='range' min='20' max='9999' title="integer (0-9999)" >

   <div style="display:none">
      <select id="backgroundImg" name="backgroundImg" style="border: 1;color: black;background: transparent;font-size: 10px;font-weight: bold;padding: 2px 10px;width: 100px; *width: 80px;*background: #58B14C;-webkit-appearance: none;">
        <option value="background1">background1</option>
        <option value="background2">background2</option>
        <option value="background3">background3</option>
        <option value="background4">background4</option>
        <option value="background5">background5</option>
      </select>
    </div>
    <div style="display:none">
      <select id="sprites" name="sprites" style="border: 1;color: black;background: transparent;font-size: 10px;font-weight: bold;padding: 2px 10px;width: 100px; *width: 80px;*background: #58B14C;-webkit-appearance: none;">
        <option value="sprites1">sprites1</option>
        <option value="sprites2">sprites2</option>
        <option value="sprites3">sprites3</option>
        <option value="sprites4">sprites4</option>
        <option value="sprites5">sprites5</option>
      </select>
    </div>
  </form>
</div>
