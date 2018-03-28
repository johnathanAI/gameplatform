<div id="sidebar" style="width: 22em; margin-right:20px; height: 36em;">
  <h2>Breakout!</h2>

  <div class='description'>
    <p style="font-size:15px;">
      Press <b>space</b> to start the game.<br>
    </p>
    <p style="font-size:15px;">
      <b>Esc</b> can be used to abandon a game.
    </p>
  </div>
<form action="index.php" method="GET" id="settingsForm" name="settingsForm" >
  <label for="paddleWidth">Paddle Width</label>
  <input type="range" name="paddleWidth" min="1" max="20" value=<?php if(isset($_GET['paddleWidth'])){ echo $_GET['paddleWidth']; } else { echo $paddleWidth; }?>>
  <label for="ballSpeed">Ball Speed</label>
  <input type="range" name="ballSpeed" min="1" max="15" value=<?php if(isset($_GET['ballSpeed'])){ echo $_GET['ballSpeed']; } else { echo $ballSpeed; }?>>
  <label for="ballRadius">Ball Size</label>
  <input type="range" name="ballRadius" min="0.3" max="1" step="0.1" value=<?php if(isset($_GET['ballRadius'])){ echo $_GET['ballRadius']; } else { echo $ballRadius; }?>>
  <input type="submit" value="Apply" id="submit" class="btn btn-primary" name="submit" style="float:right;">
</form>
</div>
