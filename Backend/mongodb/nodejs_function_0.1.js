var http = require('http');
var express = require('express');
var app = express();
var bodyParser = require('body-parser');
var request = require('request');

// 1. install a local mongodb
var MongoClient = require('mongodb').MongoClient;
var url = "mongodb://localhost:27017/";

// Configure the API to get data from a POST
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Set Header for API

app.use(function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    next();
});

var router = express.Router();

//test connection
MongoClient.connect(url, function(err, db) {
	if (err) {
		console.log("Database connected Error! Please contact the admin.");
		throw err;
	}
	if(!err){
		console.log("Database connected!");
		db.close();
	}
});

var createDB = function(req,res) {
  var dbname = req.body.dbname;
  //console.log(dbname);
  //return;
	var MongoClient = require('mongodb').MongoClient;
	var url = "mongodb://localhost:27017/"+dbname;

	MongoClient.connect(url, function(err, db) {
		//console.log(request.body.dbname);
		if (err) throw err;
		console.log("Database created!");
		db.close();

	});
  res.sendStatus(200);
}

var createCollect = function(req,res){
	var dbname = req.body.dbname;

	var collectionname = req.body.collectionname;
	var MongoClient = require('mongodb').MongoClient;
	var url = "mongodb://localhost:27017/"+dbname;

	MongoClient.connect(url, function(err, db) {
		if (err) throw err;

		db.createCollection(req.body.collectionname, function(err, res) {
		if (err) throw err;
		console.log("Collection created!");
    db.close();
  });
});
res.sendStatus(200);
}

var insertDB = function(req,res) {
	var dbname = req.body.dbname;
	var collectionname = req.body.collectionname;
	var MongoClient = require('mongodb').MongoClient;
	var url = "mongodb://localhost:27017/"+dbname;


	MongoClient.connect(url, function(err, db) {
		if (err) throw err;
		var myobj = req.body.data;
    console.log(myobj);
    var dbcollection = db.collection(collectionname);
		dbcollection.insertOne(myobj, function(err, res) { // DB name
		if (err) throw err;
		console.log(res.insertedCount +"document inserted");
		db.close();
	});
	});
  res.sendStatus(200);
}

var searchDB = function(req,res) {
	var dbname = req.body.dbname;
	var query = req.body.search;
	var collectionname = request.body.collectionname;
	var MongoClient = require('mongodb').MongoClient;
	var url = "mongodb://localhost:27017/"+dbname;

	MongoClient.connect(url, function(err, db) {
	if (err) throw err;
	var query = { _id: request.body.id };
	db.collection(collectionname).find(query).toArray(function(err, result) {		//DB name
    if (err) throw err;
	console.log(result);
    db.close();

	response.json(result);return;
	});
	});
  res.sendStatus(200);
}

var deleteRecord = function(req,res) {
	var dbname = req.body.dbname;
	var collectionname = req.body.collectionname;
	var MongoClient = require('mongodb').MongoClient;
	var url = "mongodb://localhost:27017/"+dbname;
	var query = request.body.search;

	MongoClient.connect(url, function(err, db) {
		if (err) throw err;
		var myquery = query;
		db.collection(collectionname).deleteOne(myquery, function(err, obj) {
			if (err) throw err;
			console.log("1 record deleted deleted");
			db.close();
		});
	});
  res.sendStatus(200);
}

var updateDB = function(req,res){
	var dbname = req.body.dbname;
	var collectionname = req.body.collectionname;
	var MongoClient = require('mongodb').MongoClient;
	var url = "mongodb://localhost:27017/"+dbname;
	var query = request.body.request;

	MongoClient.connect(url, function(err, db) {
		if (err) throw err;
		var myquery = query; // where
		var newvalues = myquery; // value set
		db.collection(collectionname).updateOne(myquery, newvalues, function(err, res) {
			if (err) throw err;
			console.log("1 updated updated");
			db.close();
		});
	});
  res.sendStatus(200);
}


/// POST Routes
router.post('/createDB',createDB);
router.post('/createCollect',createCollect);
router.post('/insertDB',insertDB);
router.post('/searchDB',searchDB);
router.post('/deleteRecord',deleteRecord);
router.post('/updateDB',updateDB);

// All controllers will be prefixed with /api
app.use('/', router);

// Configure Server Port
var port = process.env.PORT || 3000;


// Start Server
app.listen(port);

console.log('Server Started on port : ' + port + ' at : ' + new Date());
