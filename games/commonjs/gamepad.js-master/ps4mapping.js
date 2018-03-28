
	const gamepad = new Gamepad();

	function fireKeyboardEvent(event, keycode) {
    var keyboardEvent = document.createEventObject ?
        document.createEventObject() : document.createEvent("Events");

    if(keyboardEvent.initEvent) {
        keyboardEvent.initEvent(event, true, true);
    }

    keyboardEvent.keyCode = keycode;
    keyboardEvent.which = keycode;

    document.dispatchEvent ? document.dispatchEvent(keyboardEvent) 
                           : document.fireEvent(event, keyboardEvent);
  }

	gamepad.on('connect', e => {
		// connected event
		console.log(`controller ${e.index} connected!`);
	});
	
	gamepad.on('disconnect', e => {
		//disconnect event
		console.log(`controller ${e.index} disconnected!`);
	});
	
	gamepad.on('hold', 'stick_axis_left', e => {
	var leftveraxis =(`${e.value[0]}`);
	
	
	// move left and right with left stick
    if ( leftveraxis < -0.5){
        fireKeyboardEvent("keydown", 37);
		fireKeyboardEvent("keyup", 39);
	};

	
	if ( leftveraxis > 0.5){
        fireKeyboardEvent("keydown", 39);
		fireKeyboardEvent("keyup", 37);
	};

	});
	
	gamepad.on('hold', 'stick_axis_left', e => {
	var lefthoraxis = (`${e.value[1]}`);
	// move forward
	if ( lefthoraxis < -0.5){
		fireKeyboardEvent("keydown", 38);
		fireKeyboardEvent("keyup", 40);
	};
	
	
	if ( lefthoraxis > 0.5){
		fireKeyboardEvent("keydown", 40);
		fireKeyboardEvent("keyup", 38);
	};
	});
	gamepad.on('release', 'stick_axis_left', e => {
		fireKeyboardEvent("keyup", 40);
		fireKeyboardEvent("keyup", 38);
		fireKeyboardEvent("keyup", 39);
		fireKeyboardEvent("keyup", 37);
	});
	
/*
	gamepad.on('hold', 'stick_axis_right', e => {
	// move left and right with right stick
	var rightveraxis =(`${e.value[0]}`);
	
	
	// move left and right with left stick
    if ( rightveraxis < -0.5){
        fireKeyboardEvent("keydown", 37);
		fireKeyboardEvent("keyup", 39);
	};

	
	if ( rightveraxis > 0.5){
        fireKeyboardEvent("keydown", 39);
		fireKeyboardEvent("keyup", 37);
	};

	});
	gamepad.on('release', 'stick_axis_right', e => {
		fireKeyboardEvent("keyup", 39);
		fireKeyboardEvent("keyup", 37);
	});
	*/
	
	gamepad.on('hold', 'shoulder_bottom_right', () => {
		//hold R2 event
		console.log('button R2 was pressed!');
		fireKeyboardEvent("keydown", 38);
	});
	
	gamepad.on('release','shoulder_bottom_right', () => {
		console.log('button R2 was released!');
		fireKeyboardEvent("keyup", 38);
	});
	
	gamepad.on('hold', 'shoulder_bottom_left', () => {
		//hold L2 event
		console.log('button L2 was pressed!');
	});
	
	gamepad.on('hold', 'shoulder_top_left', () => {
		//hold L1 event
		console.log('button L1 was pressed!');
	});
	
	gamepad.on('hold', 'shoulder_top_right', () => {
		//hold R1 event
		console.log('button R1 was pressed!');
	});
	
	gamepad.on('press', 'select', () => {
		//Press select event
		console.log('button select was pressed!');
	});
	
	gamepad.on('press', 'start', () => {
		//Press start event
		console.log('button start was pressed!');
		fireKeyboardEvent("keydown", 32);
	});
	
	gamepad.on('release', 'start', () => {
		console.log('button start was released!');
		fireKeyboardEvent("keyup", 32);
	});
	
	gamepad.on('press', 'button_1', () => {
		console.log('button 1 was pressed!');
		fireKeyboardEvent("keydown", 37);
	});
	
	gamepad.on('press', 'button_2', () => {
		console.log('button 2 was pressed!');
		
	});
	
	gamepad.on('press', 'button_3', () => {
		console.log('button 3 was pressed!');
		fireKeyboardEvent("keydown", 39);
	});
	
	gamepad.on('press', 'button_4', () => {
		console.log('button 4 was pressed!');
	});
	
	gamepad.on('hold', 'button_1', () => {
		console.log('button 1 is being held!');
		
	});
	
	gamepad.on('hold', 'button_2', () => {
		console.log('button 2 is being held!');
		fireKeyboardEvent("keydown", 40);
	});
	
	gamepad.on('hold', 'button_3', () => {
		console.log('button 3 is being held!');
	});
	
	gamepad.on('hold', 'button_4', () => {
		console.log('button 4 is being held!');
		fireKeyboardEvent("keydown", 38);
	});
	
	gamepad.on('release', 'button_1', () => {
		console.log('button 1 was released!');
		fireKeyboardEvent("keyup", 37);
	});
	
	gamepad.on('release', 'button_2', () => {
		console.log('button 2 was released!');
		fireKeyboardEvent("keyup", 40);
	});
	
	gamepad.on('release', 'button_3', () => {
		console.log('button 3 was released!');
		fireKeyboardEvent("keyup", 39);
	});
	
	gamepad.on('release', 'button_4', () => {
		console.log('button 4 was released!');
		fireKeyboardEvent("keyup", 38);
	});
