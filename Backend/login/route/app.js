var express = require('express');
var app = express();
var bodyParser = require('body-parser');
var http = require('http');
var mongoose = require('mongoose');
var path = require('path');
var auto_increment = require('mongoose-auto-increment');

var scribe = require('scribe-js')({createDefaultConsole : true});

// Configure the API to get data from a POST
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Configure Server Port
var port = process.env.PORT || 8000;

// Configuration API
var console = process.console;

// Database Connection
var db = mongoose.connect('mongodb://localhost/login', {useMongoClient: true});
mongoose.connection.on('error',function (err) {  
    console.log('Mongoose default connection error: ' + err);
    process.exit(1);
}); 
mongoose.Promise = global.Promise;
auto_increment.initialize(db);


var gamedb = mongoose.connect('mongodb://localhost/BME3S02', {useMongoClient: true});
mongoose.connection.on('error',function (err) {  
    console.log('Mongoose default connection error: ' + err);
    process.exit(1);
}); 
mongoose.Promise = global.Promise;
auto_increment.initialize(gamedb);

// API Router Configuration



var router = express.Router();

// Set Header for API 

app.use(function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    if ('OPTIONS' == req.method) {
        res.send(200);
    }
    else {
        next();
    }
});

// Auth Routes
var auth = require('./controllers/auth.js');

// API Routes
var routes = require('./route.js');


auth.init().then(id=>{
    console.log("Filename: "+__dirname + '/debug.log');
    if(id!=true)
        console.log('Initial ID: '+id);
    else
        console.log('Initialisation Finished');
}).catch(err=>{
    console.log('User Initialisation Failed('+err+')');
});

app.use(scribe.express.logger());
app.use('/logs', scribe.webPanel());

// Authentication API
router.post('/api/user/login',auth.login);
router.post('/api/user/logout',auth.logout);
router.post('/api/user/auth',auth.authentication);
router.post('/api/user/adduser',auth.adduser);

// User API
router.post('/api/user',routes.userRoute);

// All controllers will be prefixed with /api
app.use('/', router);


// Start Server
app.listen(port);

console.log('Server Started at : ' + new Date() + ' (P'+port+')');