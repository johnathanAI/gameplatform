<?php include 'savesetting.php';?>
<html>
<head>
  <title>Pong!</title>
  <?php include 'head.php'; ?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link href="css/pong.css" media="screen, print" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../../js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="js/saverecord.js"></script>
  <link href="css/controlpanel.css" media="screen, print" rel="stylesheet" type="text/css" />
</head>

<body style="margin: 0; height: 100%; overflow: hidden">
  <?php include 'nav.php'; ?>
  <?php include 'controlpanel.php'; ?>
  <canvas id="game" style="width:640px; height:480px;">
    <div id="unsupported">
      Sorry, this example cannot be run because your browser does not support the &lt;canvas&gt; element
    </div>
  </canvas>
  <?php include 'game.php'; ?>
  <?php include 'pong.php'; ?>


  <script type="text/javascript">
  Game.ready(function() {

    var size        = document.getElementById('size');
    var sound       = document.getElementById('sound');
    //var stats       = document.getElementById('stats');
    var footprints  = document.getElementById('footprints');
    //var predictions = document.getElementById('predictions');

    var pong = Game.start('game', Pong, {
      sound:       sound.checked,
      //stats:       stats.checked,
      footprints:  footprints.checked,
      //predictions: predictions.checked,
    });

    Game.addEvent(sound,       'change', function() { pong.enableSound(sound.checked);           });
    //Game.addEvent(stats,       'change', function() { pong.showStats(stats.checked);             });
    Game.addEvent(footprints,  'change', function() { pong.showFootprints(footprints.checked);   });
    //Game.addEvent(predictions, 'change', function() { pong.showPredictions(predictions.checked); });

  });
  </script>
</body>
</html>
