//User Auth function
var mongoose = require('mongoose');
var User = require('../models/user.js');

var console = process.console;

var login = function(request,response){
    //if(request.body.action == 'login'){ 
        if(request.body.username!=null){
            User.login(request.body.username,request.body.password,function(err,token,reason,admin){
                if(err) { response.json({message:err}); }
                else if (token) {
                    // handle login success
                    if(admin){
                        response.json({token:token,message:"SUCCESS",admin:true});
                        return;
                    }else{
                        response.json({token:token,message:"SUCCESS",admin:false});
                        return;
                    };
                    return;
                }else if(reason){
                    response.json({token:null,message:reason});
                    return;
                }
            })
        }else{ response.json({token:false,message:'NULL_TOKEN'}); return; }
    //}else{ response.json({token:false,message:"ACTION_ERROR"}); return; }
};


var logout = function(request,response){
    //if(request.body.action == 'logout'){
        if(request.body.token!=null){
            User.logout(request.body.token,function(err,msg,reason){
                if(err){ response.json({message:err}); }
                else if(msg){
                    response.json({message:"SUCCESS"});
                    return;
                }else{ response.json({message:false}); return; }
            });
        }else{ response.json({message:'NULL_TOKEN'}); return; }
    //}else{ response.json({message:'ACTION_ERROR'}); return; }
};

var authentication = function(request,response){
    auth(request).then(function(user){
        response.json({status:true,admin:user.admin});
    }).catch(function(err){
        response.json({status:false});
    });
};

var adduser = function(request,response){
		var newusername = request.body.username;
		var newuserpwd = request.body.password;
		
		return new Promise(function(resolve,reject){
		
		console.log("Adding User...");
        let user = {
             "username" : newusername,
             "password" : newuserpwd,
             "admin" : false
       }
       User.add(user,function(err,id){
           if(err){response.json({message:'USERNAME_MAYBE_EXIST'}); return;  reject(err);}
           else {resolve(id);response.json({status:true,message:'ACCOUNT_CREATED'}); return;}
		})

        })
 };


//-------- Operation Use Utils

//Initialise 
var init = function(){
    return new Promise(function(resolve,reject){
        User.search(null,function(err,users){
            if(err){
                console.log("Initialising User Table...");
                let user = {
                    "username" : "admin",
                    "password" : "admin",
                    "admin" : true
                }
                User.add(user,function(err,id){
                    if(err) reject(err);
                    else resolve(id);
                })
            }else{
                console.log("Database Initialised Before");
                resolve(true);
            }
        })
    })
};

//OAuth
var auth = function(request){
    return new Promise(function(resolve,reject){
        if(request.body.token!=null){
            User.auth(request.body.token,function(err,msg){
                if(err) { console.log(err); reject(err); }
                else if(msg){ resolve(msg);}
                else reject("UNKNOWN");
            });
        }else reject("NULL_TOKEN");
    });
};

var renew = function(token){
    return new Promise(function(resolve,reject){
        if(token!=null){
            User.renew(token,function(err,token){
                if(err) { reject(err); }
                else if (token){ resolve(token);}
                else reject("UNKNOWN");
            })
        }else reject("NULL_TOKEN");
    })
};

var securityCheck = function(token,callback){
    return new Promise(function(resolve,reject){
        if(token!=null){
            User.securityCheck(token,function(err,lv){
                if(err) { callback(err); return; }
                else if(lv===true) { callback(null,lv); return; }
                else if(lv===false) { callback('SECURITY_ERROR'); return; }
                else{ callback('UNKNOWN'); return;}
            });
        }
    });
};

module.exports.init = init;

module.exports.login = login;
module.exports.logout = logout;
module.exports.authentication = authentication;
module.exports.adduser = adduser;
module.exports.auth = auth;
module.exports.renew = renew;
module.exports.securityCheck = securityCheck;