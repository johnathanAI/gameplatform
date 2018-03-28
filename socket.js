function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


//clear cookie
function clear(){
	document.cookie = "Token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "User=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	console.log('DATA_CLEANED');
}
	

function call(action){
	var url = "http://localhost:8000/api/user/";
	var currentpage = getCookie("Page");
	
	// Login function

	function save(json, username){
		setCookie("Token", json.token, 30);
		setCookie("User", username, 30);
		console.log("Token saved - " + document.cookie);
	}
	
	function login(option) {
		var location = url + option;
		
		if(option == 'login' || option == 'adduser'){
			var nameValue = document.getElementById("username").value;
			var passValue = document.getElementById("password").value;
		
			var data = {
				'username': nameValue,
				'password': passValue
			}
		}
		
		else if(option == 'auth'|| option == 'logout'){
			var tokenValue = getCookie("Token");
			var data = {
				'token': tokenValue
			}
		}
		
		
        $.ajax({
            url: location,
            type: 'post',
            dataType: 'text',
			crossDomain: true,
			data: data,
            success:function(data) 
			//data: return data from server
        {
        	console.log ('ajax call success');
			var json = JSON.parse(data);
			if(option == 'login'){
				if(json.token != null){
					save(json, nameValue);
					window.location.reload();
				}
				else{
					console.log('ERROR: LOGIN_FAIL');
					clear();
				}
			}
			else if (option == 'auth'){
				if (json.status == false){
					console.log('ERROR: TOKEN_INVAILD');
					clear();
					return false;
				}
				else if(json.status == true){
					console.log('TOKEN_PASS');
					return true;
				}
				else{
					console.log('ERROR_OCCUR');
				}
			}
			else if (option == 'logout'){
				if (json.message == 'SUCCESS'){
					clear();
					console.log('LOGOUT_SUCCESS');
					window.location.reload();
				}
				else {
					console.log('LOGOUT_UNSUCCESS');
				}
			}
			else if (option == 'adduser'){
				if (json.status == true){
					console.log('SUCCESS_TO_ADD_USER');
				}
				else {
					console.log ('ERROR: UNSUCCESS_TO_ADD_USER');
				}
			}
			
        },
        error: function(data) 
        {
            //if ajax fails 
           alert(err.Message);  
        }
    });
	};
	// Login function end
	
	//Save function
	
	//Save function end
	
	
	if (getCookie("Token") == ""){
		var nameValue = document.getElementById("username").value;
		var passValue = document.getElementById("password").value;
		if (nameValue == null || passValue == null){
			console.log ('ERROR: INVAILD_LOGIN');
		}
		else{
			login(action);
		}
	}
	else{
		if(login('auth')){
			console.log('ERROR: TOKEN_IS_NOT_MATCH');
			clear();
			return false;
		}
		else{
			console.log('Token Vaild');
			if (action == 'logout'){
				login('logout');
			}
			//continue process
			if(action == 'save'){
				
			}
			
		}
		
	}	
}
