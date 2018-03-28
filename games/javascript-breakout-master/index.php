<?php include 'savesetting.php'; ?>
<html>
<head>
  <title>Javascript Breakout</title>
  <?php include 'head.php'; ?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width", initial-scale=1.0, user-scalable="no"/>
  <link href="css/breakout.css" media="screen, print" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../../js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="js/saverecord.js"></script>
  <script type="text/javascript" src="./gamepad.js-master/gamepad.js"></script>
  <script type="text/javascript" src="./gamepad.js-master/ps4mapping.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="css/controlpanel.css" rel="stylesheet" type="text/css" />
</head>

<body style="background:white; margin: 0; height: 100%; overflow: hidden">
  <?php include 'nav.php'; ?>

  <?php include 'controlpanel.php'; ?>

  <div id="breakout" style="width:640; height:480; float:left; ">

    <canvas id="canvas" style="width:640; height:480;">
      <div class='unsupported'>
        Sorry, this example cannot be run because your browser does not support the &lt;canvas&gt; element
      </div>
    </canvas>

    <div id="levels">
      <img id="next" class="disabled" src="images/up.png"   title="next level">
      <img id="prev" class="disabled" src="images/down.png" title="previous level">
      <span id="label">level:</span><span id="level"></span>
    </div>
    <div id="controls">
      <input id='sound' type='checkbox' />
      <label for='sound'>sound</label>
    </div>
    <div id="instructions" style='display:none;'>
      <div class='keyboard'>
        <b>space</b> to start<br>
        <b>left/right</b> to move paddle<br>
        <b>up/down</b> to change level
      </div>
      <div class='touch'>
        <b>touch here</b> to start<br>
        <b>drag</b> paddle to move<br>
      </div>
    </div>
  </div>

  <script src="js/game.js"></script>
  <?php include 'breakout.php'; ?>
  <script src="js/levels.js"></script>
  <script>
  Game.ready(function() {
    var game = Game.start('canvas', Breakout);
  });
  </script>
</body>
</html>
