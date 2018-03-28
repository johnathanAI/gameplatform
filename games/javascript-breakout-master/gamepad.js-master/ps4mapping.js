
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
		console.log(`controller ${e.index} connected!`);
	});
	
	gamepad.on('disconnect', e => {
		console.log(`controller ${e.index} disconnected!`);
	});
	
	gamepad.on('hold', 'stick_axis_left', e => {
	var leftaxis =(`${e.value[0]}`);
    if ( leftaxis < -0.5){
		console.log('leftaxis-left');
        fireKeyboardEvent("keydown", 37);
	};
	if(leftaxis > -0.5){
		fireKeyboardEvent("keyup", 37);
	};
	
	if ( leftaxis > 0.5){
		console.log('leftaxis-right');
        fireKeyboardEvent("keydown", 39);
	};
	if(leftaxis < 0.5){
		fireKeyboardEvent("keyup", 39);
	}
	});

	gamepad.on('hold', 'stick_axis_right', e => {
	var rightaxis =(`${e.value[0]}`);
    if ( rightaxis < -0.5){
		console.log('rightaxis-left');
        fireKeyboardEvent("keydown", 37);
	};
	if(rightaxis > -0.5){
		fireKeyboardEvent("keyup", 37);
	};
	
	if ( rightaxis > 0.5){
		console.log('rightaxis-right');
        fireKeyboardEvent("keydown", 39);
	};
	if(rightaxis < 0.5){
		fireKeyboardEvent("keyup", 39);
	}
	});
	
	gamepad.on('press', 'shoulder_bottom_right', () => {
		console.log('button R2 was pressed!');
		fireKeyboardEvent("keydown", 38);
	});
	gamepad.on('release','shoulder_bottom_right', () => {
		console.log('button R2 was released!');
		fireKeyboardEvent("keyup", 38);
	});
	
	gamepad.on('press', 'button_1', () => {
		console.log('button 1 was pressed!');
         fireKeyboardEvent("keydown", 37);
	});
	
	gamepad.on('press', 'button_2', () => {
		console.log('button 2 was pressed!');
		fireKeyboardEvent("keydown", 40);
	});
	
	gamepad.on('press', 'button_3', () => {
		console.log('button 3 was pressed!');
		fireKeyboardEvent("keydown", 39);
	});
	
	gamepad.on('press', 'button_4', () => {
		console.log('button 4 was pressed!');
		fireKeyboardEvent("keydown", 38);
	});
	
	gamepad.on('hold', 'button_1', () => {
		console.log('button 1 is being held!');
	});
	
	gamepad.on('hold', 'button_2', () => {
		console.log('button 2 is being held!');
	});
	
	gamepad.on('hold', 'button_3', () => {
		console.log('button 3 is being held!');
	});
	
	gamepad.on('hold', 'button_4', () => {
		console.log('button 4 is being held!');
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
