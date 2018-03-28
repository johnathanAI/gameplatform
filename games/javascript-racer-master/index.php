<?php include 'savesetting.php'; ?>
<html>
<head>
  <title>Javascript Racer - v4 (final)</title>
  <?php include 'head.php'; ?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link href="css/common.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../../js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="js/sendrecord.js"></script>
	  <script type="text/javascript" src="./gamepad.js-master/gamepad.js"></script>
  <script type="text/javascript" src="./gamepad.js-master/ps4mapping.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="css/controlpanel.css" rel="stylesheet" type="text/css" />
</head>

<body style="margin: 0; height: 100%; overflow: hidden">
  <?php include 'nav.php'; ?>
  <?php include 'controlpanel.php'; ?>
  <div id="racer">
    <div id="hud" style="width:640px">
      <span id="speed"            class="hud"><span id="speed_value" class="value">0</span> mph</span>
      <span id="current_lap_time" class="hud">Time: <span id="current_lap_time_value" class="value">0.0</span></span>
      <span id="last_lap_time"    class="hud">Last Lap: <span id="last_lap_time_value" class="value">0.0</span></span>
      <!--<span id="fast_lap_time"    class="hud">Fastest Lap: <span id="fast_lap_time_value" class="value">0.0</span></span>-->
    </div>
    <img id="changeStageMessage" width="220" height="277" src="images/maxresdefault.jpg" style="display:none;">
    <img id="winMessage" width="220" height="277" src="images/Congratulations-Winners.jpg" style="display:none;">
    <div id="toast" class="gameToast"></div>

    <canvas id="canvas" style="z-index: 0; background-color: #000000;">
      Sorry, this example cannot be run because your browser does not support the &lt;canvas&gt; element
    </canvas>
    <canvas id="firework" style="z-index: 1;width: 640px;height: 480px;">
      <!-- opacity:0; z-index: 1; top: 480;-->
      <!-- Sorry, this example cannot be run because your browser does not support the &lt;canvas&gt; element -->
    </canvas>
    Loading...
  </div>

  <span id="mute"></span>
  <input type="button" id="startbutton" value="start Game" onclick="startGame();" class="btn btn-primary" style="margin-left:60px;">
  <input type="button" value="Reload" onclick="location.reload();" class="btn btn-primary" style="margin-left:60px;">
  <!---<input type="button" value="Next Level" onclick="nextLevel();" class="btn btn-primary" style="margin-left:60px;"> -->
  
  <audio id='music'>
    <!--<source src="music/racer.ogg">-->
      <source id="audioSource" src="music/music1.mp3">
      </audio>
      <script src="js/stats.js"></script>
      <script src="js/common.js"></script>
      <script src="js/firework.js"></script>
      <script>
<!-- ***************************************************************** -->
       $( document ).ready(function() {
        ParametersInitialization();
        reset();
	$.getJSON('getConfig.php',function(data){
		console.log(data);
		if (data.length == 3){
		$('#'+data[0].parameter).val(data[0].value);
		$('#'+data[1].parameter).val(data[1].value);
		$('#'+data[2].parameter).val(data[2].value);
		Dom.get('currentRoadWidth').innerHTML      = Dom.get('roadWidth').value      ;
        Dom.get('currenttotalCars').innerHTML      = Dom.get('totalCars').value      ;
        Dom.get('currentmaxSpeed').innerHTML       = Dom.get('maxSpeed').value       ;
		Dom.get('allowcrashTime').innerHTML       = Dom.get('crashTime').value       ;
		}
       ParametersInitialization();
        reset();
		});
	refreshTweakUI();

      });
	  /*************************
	   *                       *
	   *    Global variable    *
	   *                       *
	   *************************/

     function refreshTweakUI() {
       Dom.get('lanes').selectedIndex = lanes-1;
       Dom.get('currentRoadWidth').innerHTML      = Dom.get('roadWidth').value      = roadWidth;
       Dom.get('currenttotalCars').innerHTML      = Dom.get('totalCars').value      = totalCars;
       Dom.get('currentmaxSpeed').innerHTML       = Dom.get('maxSpeed').value       = maxSpeed;
       Dom.get('currentmaxTime').innerHTML        = Dom.get('maxTime').value        = maxTime;
	   Dom.get('allowcrashTime').innerHTML       = Dom.get('crashTime').value       = maxcrashcount;
     }


     function reset(options) {
       //console.log("called reset");

         options       = options || {};
         canvas.width  = width  = Util.toInt(options.width,          width);
         canvas.height = height = Util.toInt(options.height,         height);
         lanes                  = Util.toInt(options.lanes,          lanes);
         totalCars              = Util.toInt(options.totalCars,      totalCars);
         roadWidth              = Util.toInt(options.roadWidth,      roadWidth);
         maxSpeed               = Util.toInt(options.maxSpeed,       maxSpeed);
         segmentLength          = Util.toInt(options.segmentLength,  segmentLength);
         rumbleLength           = Util.toInt(options.rumbleLength,   rumbleLength);
		 maxcrashcount          = Util.toInt(options.maxcrashcount,  maxcrashcount);
         cameraDepth            = 1 / Math.tan((fieldOfView/2) * Math.PI/180);
         playerZ                = (cameraHeight * cameraDepth);
         resolution             = height/480;
         maxTime                = Util.toInt(options.maxTime,        maxTime);
       refreshTweakUI();

       if ((segments.length==0) || (options.segmentLength) || (options.rumbleLength) || (options.totalCars))
       resetRoad(); // only rebuild road when necessary
     }

     function stop(){

       document.dispatchEvent(new Event('finished'));
       keyLeft = keyRight = keySlower = keyFaster = false;
       displayToast("The End","inf");
       fire();
       //setTimeout(function(){ location.reload();},  3000);

    }



    function clear(){ ctx.clearRect(0,0,c.width,c.height); }

    function displayToast(msg, time) {
      var toast = $("#toast");
      var hide = function () { toast.removeClass("show");}
      toast.html(msg);
      toast.addClass("show");
      clearTimeout(hide);
      if(time != "inf") setTimeout(hide, time||2000);
    }

  function ParametersInitialization() {
	    // Declare global variables
	      fps            = 60;                      // how many 'update' frames per second
		  step           = 1/fps;                   // how long is each frame (in seconds)
		  width          = 1024;                    // logical canvas width
          height         = 768;                     // logical canvas height
          centrifugal    = 0.3;                     // centrifugal force multiplier when going around curves
          offRoadDecel   = 0.99;                    // speed multiplier when off road (e.g. you lose 2% speed each update frame)
          skySpeed       = 0.001;                   // background sky layer scroll speed when going around curve (or up hill)
          hillSpeed      = 0.002;                   // background hill layer scroll speed when going around curve (or up hill)
          treeSpeed      = 0.003;                   // background tree layer scroll speed when going around curve (or up hill)
          skyOffset      = 0;                       // current sky scroll offset
          hillOffset     = 0;                       // current hill scroll offset
          treeOffset     = 0;                       // current tree scroll offset
		  segments       = [];                      // array of road segments
          cars           = [];                      // array of cars on the road
          stats          = Game.stats('fps');       // mr.doobs FPS counter
          canvas         = Dom.get('canvas');       // our canvas...
          ctx            = canvas.getContext('2d'); // ...and its drawing context
          background     = null;                    // our background image (loaded below)
          sprites        = null;                    // our spritesheet (loaded below)
          resolution     = null;                    // scaling factor to provide resolution independence (computed)
          roadWidth      = $("#roadWidth").val();                   // actually half the roads width, easier math if the road spans from -roadWidth to +roadWidth
          segmentLength  = 300;                     // length of a single segment
          rumbleLength   = 3;                       // number of segments per red/white rumble strip
          trackLength    = 100;                    // z length of entire track (computed)
          lanes          = 5;                       // number of lanes
          fieldOfView    = 100;                     // angle (degrees) for field of view
          cameraHeight   = 1000;                    // z height of camera
          cameraDepth    = null;                    // z distance camera is from screen (computed)
          drawDistance   = 300;                     // number of segments to draw
          playerX        = 0;                       // player x offset from center of road (-1 to 1 to stay independent of roadWidth)
          playerZ        = null;                    // player relative z distance from camera (computed)
          fogDensity     = 5;                       // exponential fog density
          position       = 0;                       // current camera Z position (add playerZ to get player's absolute Z position)
          speed          = 0;                       // current speed
          maxSpeed       = $("#maxSpeed").val();    // top speed (ensure we can't move more than 1 segment in a single frame to make collision detection easier)
          accel          =  maxSpeed/5;             // acceleration rate - tuned until it 'felt' right
          breaking       = -maxSpeed;               // deceleration rate when braking
          decel          = -maxSpeed/5;             // 'natural' deceleration rate when neither accelerating, nor braking
          offRoadDecel   = -maxSpeed/2;             // off road deceleration is somewhere in between
          offRoadLimit   =  maxSpeed/4;             // limit when off road deceleration no longer applies (e.g. you can always go at least this speed even when off road)
          totalCars      = $("#totalCars").val();                     // total number of cars on the road
          currentLapTime = 0;                       // current lap time
          lastLapTime    = null;                    // last lap time
          keyLeft        = false;
          keyRight       = false;
          keyFaster      = true;
          keySlower      = false;
          maxTime = $("#maxTime").val();
          
          crashcount     = 0;
		  maxcrashcount  = 20;

		  hud = {
            speed:            { value: null, dom: Dom.get('speed_value')            },
            current_lap_time: { value: null, dom: Dom.get('current_lap_time_value') },
            last_lap_time:    { value: null, dom: Dom.get('last_lap_time_value')    },
            fast_lap_time:    { value: null, dom: Dom.get('fast_lap_time_value')    }
          }

	  }

    function update(dt) {
      ////console.log("called update");
      var n, car, carW, sprite, spriteW;
      var playerSegment = findSegment(position+playerZ);
      var playerW       = SPRITES.PLAYER_STRAIGHT.w * SPRITES.SCALE;
      var speedPercent  = speed/maxSpeed;
      var dx            = dt * 2 * speedPercent; // at top speed, should be able to cross from left to right (-1 to 1) in 1 second
      var startPosition = position;

      updateCars(dt, playerSegment, playerW);

      position = Util.increase(position, dt * speed, trackLength);

      if (keyLeft)
      playerX = playerX - dx;
      else if (keyRight)
      playerX = playerX + dx;

      playerX = playerX - (dx * speedPercent * playerSegment.curve * centrifugal);

      if (keyFaster)
      speed = Util.accelerate(speed, accel, dt);
      else if (keySlower)
      speed = Util.accelerate(speed, breaking, dt);
      else
      speed = Util.accelerate(speed, decel, dt);


      if ((playerX < -1) || (playerX > 1)) {

        if (speed > offRoadLimit)
        speed = Util.accelerate(speed, offRoadDecel, dt);

        for(n = 0 ; n < playerSegment.sprites.length ; n++) {
          sprite  = playerSegment.sprites[n];
          spriteW = sprite.source.w * SPRITES.SCALE;
          if (Util.overlap(playerX, playerW, sprite.offset + spriteW/2 * (sprite.offset > 0 ? 1 : -1), spriteW)) {
            speed = maxSpeed/5;
            position = Util.increase(playerSegment.p1.world.z, -playerZ, trackLength); // stop in front of sprite (at front of segment)
            break;
          }
        }
      }

      for(n = 0 ; n < playerSegment.cars.length ; n++) {
        car  = playerSegment.cars[n];
        carW = car.sprite.w * SPRITES.SCALE;
        if (speed > car.speed) {
          if (Util.overlap(playerX, playerW, car.offset, carW, 0.8)) {
                var audio = new Audio('music/crash.mp3');
            audio.play();
            crashcount++;
			if (crashcount == maxcrashcount){
				stop();
				ParametersInitialization();
				reset();
				
			}
			console.log( crashcount );
            speed    = car.speed * (car.speed/speed);
            position = Util.increase(car.z, -playerZ, trackLength);
            break;
          }
        }
      }

      playerX = Util.limit(playerX, -3, 3);     // dont ever let it go too far out of bounds
      speed   = Util.limit(speed, 0, maxSpeed); // or exceed maxSpeed

      skyOffset  = Util.increase(skyOffset,  skySpeed  * playerSegment.curve * (position-startPosition)/segmentLength, 1);
      hillOffset = Util.increase(hillOffset, hillSpeed * playerSegment.curve * (position-startPosition)/segmentLength, 1);
      treeOffset = Util.increase(treeOffset, treeSpeed * playerSegment.curve * (position-startPosition)/segmentLength, 1);

      if (position > playerZ) {

        if (currentLapTime && (startPosition < playerZ)) {
          //alert("hellos");//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          displayToast("You won!");
          lastLapTime    = currentLapTime;
          //currentLapTime = 0;
          if (lastLapTime <= Util.toFloat(Dom.storage.fast_lap_time)) {
            Dom.storage.fast_lap_time = lastLapTime;
            updateHud('fast_lap_time', formatTime(lastLapTime));
            Dom.addClassName('fast_lap_time', 'fastest');
            Dom.addClassName('last_lap_time', 'fastest');
          }
          else {
            Dom.removeClassName('fast_lap_time', 'fastest');
            Dom.removeClassName('last_lap_time', 'fastest');
          }
          updateHud('last_lap_time', formatTime(lastLapTime));
          Dom.show('last_lap_time');
        }
        else {
          currentLapTime += dt;
        }
      }

      updateHud('speed',            5 * Math.round(speed/500));
      updateHud('current_lap_time', formatTime(currentLapTime));
    }

    //-------------------------------------------------------------------------

    function updateCars(dt, playerSegment, playerW) {
      //console.log("called updateCars");
      var n, car, oldSegment, newSegment;
      for(n = 0 ; n < cars.length ; n++) {
        car         = cars[n];
        oldSegment  = findSegment(car.z);
        car.offset  = car.offset + updateCarOffset(car, oldSegment, playerSegment, playerW);
        car.z       = Util.increase(car.z, dt * car.speed, trackLength);
        car.percent = Util.percentRemaining(car.z, segmentLength); // useful for interpolation during rendering phase
        newSegment  = findSegment(car.z);
        if (oldSegment != newSegment) {
          index = oldSegment.cars.indexOf(car);
          oldSegment.cars.splice(index, 1);
          newSegment.cars.push(car);
        }
      }
    }

    function updateCarOffset(car, carSegment, playerSegment, playerW) {
      ////console.log("called updateCarOffset");
      var i, j, dir, segment, otherCar, otherCarW, lookahead = 20, carW = car.sprite.w * SPRITES.SCALE;

      // optimization, dont bother steering around other cars when 'out of sight' of the player
      if ((carSegment.index - playerSegment.index) > drawDistance)
      return 0;

      for(i = 1 ; i < lookahead ; i++) {
        segment = segments[(carSegment.index+i)%segments.length];

        if ((segment === playerSegment) && (car.speed > speed) && (Util.overlap(playerX, playerW, car.offset, carW, 1.2))) {
          if (playerX > 0.5)
          dir = -1;
          else if (playerX < -0.5)
          dir = 1;
          else
          dir = (car.offset > playerX) ? 1 : -1;
          return dir * 1/i * (car.speed-speed)/maxSpeed; // the closer the cars (smaller i) and the greated the speed ratio, the larger the offset
        }

        for(j = 0 ; j < segment.cars.length ; j++) {
          otherCar  = segment.cars[j];
          otherCarW = otherCar.sprite.w * SPRITES.SCALE;
          if ((car.speed > otherCar.speed) && Util.overlap(car.offset, carW, otherCar.offset, otherCarW, 1.2)) {
            if (otherCar.offset > 0.5)
            dir = -1;
            else if (otherCar.offset < -0.5)
            dir = 1;
            else
            dir = (car.offset > otherCar.offset) ? 1 : -1;
            return dir * 1/i * (car.speed-otherCar.speed)/maxSpeed;
          }
        }
      }

      // if no cars ahead, but I have somehow ended up off road, then steer back on
      if (car.offset < -0.9)
      return 0.1;
      else if (car.offset > 0.9)
      return -0.1;
      else
      return 0;
    }

    //-------------------------------------------------------------------------

    function updateHud(key, value) { // accessing DOM can be slow, so only do it if value has changed
      ////console.log("called updateHud");
      if (hud[key].value !== value) {
        hud[key].value = value;
        Dom.set(hud[key].dom, value);
      }
    }

    function formatTime(dt) {
      ////console.log("called formatTime");
      var minutes = Math.floor(dt/60);
      var seconds = Math.floor(dt - (minutes * 60));
      var tenths  = Math.floor(10 * (dt - Math.floor(dt)));
      if (minutes > 0)
      return minutes + "." + (seconds < 10 ? "0" : "") + seconds + "." + tenths;
      else
      return seconds + "." + tenths;
    }

    //=========================================================================
    // RENDER THE GAME WORLD
    //=========================================================================

    function render() {
      ////console.log("called render");
      var baseSegment   = findSegment(position);
      var basePercent   = Util.percentRemaining(position, segmentLength);
      var playerSegment = findSegment(position+playerZ);
      var playerPercent = Util.percentRemaining(position+playerZ, segmentLength);
      var playerY       = Util.interpolate(playerSegment.p1.world.y, playerSegment.p2.world.y, playerPercent);
      var maxy          = height;

      var x  = 0;
      var dx = - (baseSegment.curve * basePercent);

      ctx.clearRect(0, 0, width, height);

      Render.background(ctx, background, width, height, BACKGROUND.SKY,   skyOffset,  resolution * skySpeed  * playerY);
      Render.background(ctx, background, width, height, BACKGROUND.HILLS, hillOffset, resolution * hillSpeed * playerY);
      Render.background(ctx, background, width, height, BACKGROUND.TREES, treeOffset, resolution * treeSpeed * playerY);


      var n, i, segment, car, sprite, spriteScale, spriteX, spriteY;

      for(n = 0 ; n < drawDistance ; n++) {

        segment        = segments[(baseSegment.index + n) % segments.length];
        segment.looped = segment.index < baseSegment.index;
        segment.fog    = Util.exponentialFog(n/drawDistance, fogDensity);
        segment.clip   = maxy;

        Util.project(segment.p1, (playerX * roadWidth) - x,      playerY + cameraHeight, position - (segment.looped ? trackLength : 0), cameraDepth, width, height, roadWidth);
        Util.project(segment.p2, (playerX * roadWidth) - x - dx, playerY + cameraHeight, position - (segment.looped ? trackLength : 0), cameraDepth, width, height, roadWidth);

        x  = x + dx;
        dx = dx + segment.curve;

        if ((segment.p1.camera.z <= cameraDepth)         || // behind us
        (segment.p2.screen.y >= segment.p1.screen.y) || // back face cull
        (segment.p2.screen.y >= maxy))                  // clip by (already rendered) hill
        continue;

        Render.segment(ctx, width, lanes,
          segment.p1.screen.x,
          segment.p1.screen.y,
          segment.p1.screen.w,
          segment.p2.screen.x,
          segment.p2.screen.y,
          segment.p2.screen.w,
          segment.fog,
          segment.color);

          maxy = segment.p1.screen.y;
        }

        for(n = (drawDistance-1) ; n > 0 ; n--) {
          segment = segments[(baseSegment.index + n) % segments.length];

          for(i = 0 ; i < segment.cars.length ; i++) {
            car         = segment.cars[i];
            sprite      = car.sprite;
            spriteScale = Util.interpolate(segment.p1.screen.scale, segment.p2.screen.scale, car.percent);
            spriteX     = Util.interpolate(segment.p1.screen.x,     segment.p2.screen.x,     car.percent) + (spriteScale * car.offset * roadWidth * width/2);
            spriteY     = Util.interpolate(segment.p1.screen.y,     segment.p2.screen.y,     car.percent);
            Render.sprite(ctx, width, height, resolution, roadWidth, sprites, car.sprite, spriteScale, spriteX, spriteY, -0.5, -1, segment.clip);
          }

          for(i = 0 ; i < segment.sprites.length ; i++) {
            sprite      = segment.sprites[i];
            spriteScale = segment.p1.screen.scale;
            spriteX     = segment.p1.screen.x + (spriteScale * sprite.offset * roadWidth * width/2);
            spriteY     = segment.p1.screen.y;
            Render.sprite(ctx, width, height, resolution, roadWidth, sprites, sprite.source, spriteScale, spriteX, spriteY, (sprite.offset < 0 ? -1 : 0), -1, segment.clip);
          }

          if (segment == playerSegment) {
            Render.player(ctx, width, height, resolution, roadWidth, sprites, speed/maxSpeed,
              cameraDepth/playerZ,
              width/2,
              (height/2) - (cameraDepth/playerZ * Util.interpolate(playerSegment.p1.camera.y, playerSegment.p2.camera.y, playerPercent) * height/2),
              speed * (keyLeft ? -1 : keyRight ? 1 : 0),
              playerSegment.p2.world.y - playerSegment.p1.world.y);
            }
          }
        }

  function findSegment(z) {
    ////console.log("called findSegment");
    return segments[Math.floor(z/segmentLength) % segments.length];
  }

  //=========================================================================
  // BUILD ROAD GEOMETRY
  //=========================================================================

  function lastY() {/*console.log("called lastY");*/ return (segments.length == 0) ? 0 : segments[segments.length-1].p2.world.y; }

  function addSegment(curve, y) {
    ////console.log("called addSegment");
    var n = segments.length;
    segments.push({
      index: n,
      p1: { world: { y: lastY(), z:  n   *segmentLength }, camera: {}, screen: {} },
      p2: { world: { y: y,       z: (n+1)*segmentLength }, camera: {}, screen: {} },
      curve: curve,
      sprites: [],
      cars: [],
      color: Math.floor(n/rumbleLength)%2 ? COLORS.DARK : COLORS.LIGHT
    });
  }

  function addSprite(n, sprite, offset) {
    ////console.log("called addSprite");
    segments[n].sprites.push({ source: sprite, offset: offset });
  }

  function addRoad(enter, hold, leave, curve, y) {
    ////console.log("called addRoad");
    var startY   = lastY();
    var endY     = startY + (Util.toInt(y, 0) * segmentLength);
    var n, total = enter + hold + leave;
    for(n = 0 ; n < enter ; n++)
    addSegment(Util.easeIn(0, curve, n/enter), Util.easeInOut(startY, endY, n/total));
    for(n = 0 ; n < hold  ; n++)
    addSegment(curve, Util.easeInOut(startY, endY, (enter+n)/total));
    for(n = 0 ; n < leave ; n++)
    addSegment(Util.easeInOut(curve, 0, n/leave), Util.easeInOut(startY, endY, (enter+hold+n)/total));
  }

  var ROAD = {
    LENGTH: { NONE: 0, SHORT:  25, MEDIUM:   50, LONG:  100 },
    HILL:   { NONE: 0, LOW:    20, MEDIUM:   40, HIGH:   60 },
    CURVE:  { NONE: 0, EASY:    2, MEDIUM:    4, HARD:    6 }
  };

  function addStraight(num) {
    ////console.log("called addStraight");
    num = num || ROAD.LENGTH.MEDIUM;
    addRoad(num, num, num, 0, 0);
  }

  function addHill(num, height) {
    ////console.log("called addHill");
    num    = num    || ROAD.LENGTH.MEDIUM;
    height = height || ROAD.HILL.MEDIUM;
    addRoad(num, num, num, 0, height);
  }

  function addCurve(num, curve, height) {
    ////console.log("called addCurve");
    num    = num    || ROAD.LENGTH.MEDIUM;
    curve  = curve  || ROAD.CURVE.MEDIUM;
    height = height || ROAD.HILL.NONE;
    addRoad(num, num, num, curve, height);
  }

  function addLowRollingHills(num, height) {
    ////console.log("called addLowRollingHills");
    num    = num    || ROAD.LENGTH.SHORT;
    height = height || ROAD.HILL.LOW;
    addRoad(num, num, num,  0,                height/2);
    addRoad(num, num, num,  0,               -height);
    addRoad(num, num, num,  ROAD.CURVE.EASY,  height);
    addRoad(num, num, num,  0,                0);
    addRoad(num, num, num, -ROAD.CURVE.EASY,  height/2);
    addRoad(num, num, num,  0,                0);
  }

  function addSCurves() {
    ////console.log("called addSCurves");
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM,  -ROAD.CURVE.EASY,    ROAD.HILL.NONE);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM,   ROAD.CURVE.MEDIUM,  ROAD.HILL.MEDIUM);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM,   ROAD.CURVE.EASY,   -ROAD.HILL.LOW);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM,  -ROAD.CURVE.EASY,    ROAD.HILL.MEDIUM);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM,  -ROAD.CURVE.MEDIUM, -ROAD.HILL.MEDIUM);
  }

  function addBumps() {
    ////console.log("called addBumps");
    addRoad(10, 10, 10, 0,  5);
    addRoad(10, 10, 10, 0, -2);
    addRoad(10, 10, 10, 0, -5);
    addRoad(10, 10, 10, 0,  8);
    addRoad(10, 10, 10, 0,  5);
    addRoad(10, 10, 10, 0, -7);
    addRoad(10, 10, 10, 0,  5);
    addRoad(10, 10, 10, 0, -2);
  }

  function addDownhillToEnd(num) {
    ////console.log("called addDownhillToEnd");
    num = num || 200;
    addRoad(num, num, num, -ROAD.CURVE.EASY, -lastY()/segmentLength);
  }

  function resetRoad() {
    ////console.log("called resetRoad");
    segments = [];

    addStraight(ROAD.LENGTH.SHORT);
    addLowRollingHills();
    addSCurves();
    addCurve(ROAD.LENGTH.MEDIUM, ROAD.CURVE.MEDIUM, ROAD.HILL.LOW);
    addBumps();
    addLowRollingHills();
    addCurve(ROAD.LENGTH.LONG*2, ROAD.CURVE.MEDIUM, ROAD.HILL.MEDIUM);
    addStraight();
    addHill(ROAD.LENGTH.MEDIUM, ROAD.HILL.HIGH);
    addSCurves();
    addCurve(ROAD.LENGTH.LONG, -ROAD.CURVE.MEDIUM, ROAD.HILL.NONE);
    addHill(ROAD.LENGTH.LONG, ROAD.HILL.HIGH);
    addCurve(ROAD.LENGTH.LONG, ROAD.CURVE.MEDIUM, -ROAD.HILL.LOW);
    addBumps();
    addHill(ROAD.LENGTH.LONG, -ROAD.HILL.MEDIUM);
    addStraight();
    addSCurves();
    addDownhillToEnd();

    resetSprites();
    resetCars();

    segments[findSegment(playerZ).index + 2].color = COLORS.START;
    segments[findSegment(playerZ).index + 3].color = COLORS.START;
    for(var n = 0 ; n < rumbleLength ; n++)
    segments[segments.length-1-n].color = COLORS.FINISH;

    trackLength = segments.length * segmentLength;
  }

  function resetSprites() {
    console.log("called resetSprites");
    var n, i;

  /*    addSprite(20,  SPRITES.BILLBOARD07, -1);
        addSprite(40,  SPRITES.BILLBOARD06, -1);
         addSprite(60,  SPRITES.BILLBOARD08, -1);
         addSprite(80,  SPRITES.BILLBOARD09, -1);
         addSprite(100, SPRITES.BILLBOARD01, -1);
          addSprite(120, SPRITES.BILLBOARD02, -1);
          addSprite(140, SPRITES.BILLBOARD03, -1);
        addSprite(160, SPRITES.BILLBOARD04, -1);
          addSprite(180, SPRITES.BILLBOARD05, -1);
      addSprite(240,                  SPRITES.BILLBOARD07, -1.2);
          addSprite(240,                  SPRITES.BILLBOARD06,  1.2);
          addSprite(segments.length - 25, SPRITES.BILLBOARD07, -1.2);
          addSprite(segments.length - 25, SPRITES.BILLBOARD06,  1.2);
*/
    for(n = 10 ; n < 200 ; n += 4 + Math.floor(n/100)) {
      addSprite(n, SPRITES.PALM_TREE, 0.5 + Math.random()*0.5);
      addSprite(n, SPRITES.PALM_TREE,   1 + Math.random()*2);
    }

    for(n = 250 ; n < 1000 ; n += 5) {
      addSprite(n,     SPRITES.COLUMN, 1.1);
      addSprite(n + Util.randomInt(0,5), SPRITES.TREE1, -1 - (Math.random() * 2));
      addSprite(n + Util.randomInt(0,5), SPRITES.TREE2, -1 - (Math.random() * 2));
    }

    for(n = 200 ; n < segments.length ; n += 3) {
      addSprite(n, Util.randomChoice(SPRITES.PLANTS), Util.randomChoice([1,-1]) * (2 + Math.random() * 5));
    }

    var side, sprite, offset;
    for(n = 1000 ; n < (segments.length-50) ; n += 100) {
      side      = Util.randomChoice([1, -1]);
      addSprite(n + Util.randomInt(0, 50), Util.randomChoice(SPRITES.BILLBOARDS), -side);
      //  for(i = 0 ; i < 20 ; i++) {
      //  sprite = Util.randomChoice(SPRITES.PLANTS);
      //offset = side * (1.5 + Math.random());
      //  addSprite(n + Util.randomInt(0, 50), sprite, offset);
      //  }

    }

  }

  function resetCars() {
    //console.log("called resetCars");
    cars = [];
    var n, car, segment, offset, z, sprite, speed;
    for (var n = 0 ; n < totalCars ; n++) {
      offset = Math.random() * Util.randomChoice([-0.8, 0.8]);
      z      = Math.floor(Math.random() * segments.length) * segmentLength;
      sprite = Util.randomChoice(SPRITES.CARS);
      speed  = maxSpeed/4 + Math.random() * maxSpeed/(sprite == SPRITES.SEMI ? 4 : 2);
      car = { offset: offset, z: z, sprite: sprite, speed: speed };
      segment = findSegment(car.z);
      segment.cars.push(car);
      cars.push(car);
    }
  }

  Dom.on('roadWidth',      'change', function(ev) { /*console.log("changing");*/Dom.blur(ev);reset({ roadWidth:     Util.limit(Util.toInt(ev.target.value), Util.toInt(ev.target.getAttribute('min')), Util.toInt(ev.target.getAttribute('max'))) });});
  Dom.on('totalCars',      'change', function(ev) { /*console.log("changing");*/Dom.blur(ev); reset({ totalCars:     Util.limit(Util.toInt(ev.target.value), Util.toInt(ev.target.getAttribute('min')), Util.toInt(ev.target.getAttribute('max'))) }); });
  Dom.on('maxSpeed',       'change', function(ev) { /*console.log("changing");*/Dom.blur(ev); reset({ maxSpeed:      Util.limit(Util.toInt(ev.target.value), Util.toInt(ev.target.getAttribute('min')), Util.toInt(ev.target.getAttribute('max'))) }); });
  Dom.on('maxTime',        'change',
    function(ev) { /*console.log("changing");*/
      Dom.blur(ev);
      reset({ maxTime:       Util.limit(Util.toInt(ev.target.value), Util.toInt(ev.target.getAttribute('min')), Util.toInt(ev.target.getAttribute('max'))) });
      if(Stage.stagePtr < Stage.stageList.length-1)
      {
        clearTimeout(Stage.changeStage);
        setTimeout(Stage.changeStage, maxTime * 1000);
      }
      else if(Stage.stagePtr == Stage.stageList.length-1)
      {
        clearTimeout(stop);
        setTimeout(stop, maxTime * 1000);
      }

  });
     Dom.on('crashTime',      'change', function(ev) { console.log("changing");Dom.blur(ev);reset({ maxcrashcount:     Util.limit(Util.toInt(ev.target.value), Util.toInt(ev.target.getAttribute('min')), Util.toInt(ev.target.getAttribute('max'))) });});

  function startGame(){
    //console.log("called startGame");

	   //if(Stage.NewGame) ParametersInitialization();
     Stage.NewGame = false;
	 document.getElementById("startbutton").style.visibility = 'hidden';
     Game.run({
      canvas: canvas, render: render, update: update, stats: stats, step: step,
      images: ["background1", "sprites1"],
      keys: [
        { keys: [KEY.LEFT,  KEY.A], mode: 'down', action: function() { keyLeft   = true;  } },
        { keys: [KEY.RIGHT, KEY.D], mode: 'down', action: function() { keyRight  = true;  } },
        { keys: [KEY.UP,    KEY.W], mode: 'down', action: function() { keyFaster = true;  } },
        { keys: [KEY.DOWN,  KEY.S], mode: 'down', action: function() { keySlower = true;  } },
        { keys: [KEY.LEFT,  KEY.A], mode: 'up',   action: function() { keyLeft   = false; } },
        { keys: [KEY.RIGHT, KEY.D], mode: 'up',   action: function() { keyRight  = false; } }
      ],
      ready: function(images) {
        background = images[0];
        sprites    = images[1];
        reset();
        //Dom.storage.fast_lap_time = Dom.storage.fast_lap_time || 180;
        displayToast("Start Game");
        Stage.stageList = Util.shuffle(Stage.stageList);
        console.log(Stage.stageList);
        setTimeout(Stage.changeStage, maxTime * 1000);
      }
    });

  }

</script>
        </body>
        </html>
