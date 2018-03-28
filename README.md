# BME3S02 Web Game Platform

This project is for Hong Kong Polytechnic University BME3S02-SL.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Installing

A step by step series of how to build up the development environment

Install node.js

* [Node.js](https://nodejs.org/en/download/package-manager/#windows) - The web framework used
Please confirm that npm is intaslled with node.js !

Install MongoDB

* [MongoDB](https://docs.mongodb.com/manual/installation/) - The one-type of NO-SQL DataBase

Install apache web server

* [Apache](https://httpd.apache.org/download.cgi) - The web server sevice provider

Install Robo 3T

* [Robo 3T](https://robomongo.org/download) - GUI for mongoDB

Install Postman

* [Postman](https://www.getpostman.com/) - Tools for testing the node.js api

## Start-up the service

Test npm install
```
npm -v
```

Update npm
```
npm install npm -g
```

Install express
```
npm install express
```

Start MongoDB
```
cd C:\Program Files\MongoDB\Server\3.4\bin
mongod --port 27017
```


### Shutdown Service

Shutdown mongoDB

```
mongod --shutdown
```


## Nodejs API Deployment

### Login System API

Startup
```
node app.js
```

Login Request

```
$.ajax({
	url: http://localhost:8000/api/user/login,
	type: 'post',
	dataType: 'text',
	crossDomain: true,
	data: {	'username': nameValue,
			'password': passValue
	},
	success:function(data) 
	//data: return data from server
	{
		console.log ('ajax call success');
	}
```

Login Response
```
{
    "token": string,
    "message": string,
    "admin": boolean
}
```

Authentication Request
```
$.ajax({
	url: http://localhost:8000/api/user/auth,
	type: 'post',
	dataType: 'text',
	crossDomain: true,
	data: {	'token': tokenValue,
	},
	success:function(data) 
	//data: return data from server
	{
		console.log ('ajax call success');
	}
```

Authentication Response
```
{
    "status": boolean,
    "admin": boolean
}
```

Logout Request
```
$.ajax({
	url: http://localhost:8000/api/user/logout,
	type: 'post',
	dataType: 'text',
	crossDomain: true,
	data: {	'token': tokenValue,
	},
	success:function(data) 
	//data: return data from server
	{
		console.log ('ajax call success');
	}
```

Logout Response
```
{
    "message": string
}
```

Add New Account Request
```
$.ajax({
	url: http://localhost:8000/api/user/adduser,
	type: 'post',
	dataType: 'text',
	crossDomain: true,
	data: {	'username': nameValue,
			'password': passValue
	},
	success:function(data) 
	//data: return data from server
	{
		console.log ('ajax call success');
	}
```

Add New Account Response
```
{
    "status": boolean,
    "message": string
}
```

## Resources 
* [Web Development Tutorial] (https://www.w3cschool.cn/) - HTML, PHP, Node.js, ROR Tutorial
* [HTML Game](http://codeincomplete.com/games/) - Many HTML game can be found in Here
* [Nodejs Tutorial](https://www.w3schools.com/nodejs/) - Dependency Management
* [Electronjs Official Website](https://electronjs.org/) - Final pickage tools

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [GitLab](https://gitlab.com/) for versioning. For the versions available, see the [tags on this repository](https://gitlab.com/tszfung0105/bme3s02). 

## Authors

* **Johnathan Leung** - *Initial work*
* **Tim** - *Initial work*


## License

This project is licensed under the License
