var mongoose = require('mongoose');
var uniqueValidator = require('mongoose-unique-validator');
var Schema = mongoose.Schema;
var console = process.console;

var gameSchema = new Schema({
    username: { type : String, required: true, unique: true, min:6 },
	setting: { type : Object },
    data: {	type : Object },
	meta:{ type : Object },
    update_at: Date
});


// Internal Methods 
gameSchema.statics.auth = function(token,callback){
    this.findOne({token: token},function(err,user){
        if(err){ callback('USER_OPERATION_ERROR'); return; }
        else if(!user || user=='' || user ==null){ callback('USER_TOKEN_NOT_FOUND',null);}
        else{
            user.verifyToken(token,function(verified){
                if(verified){
                    callback(null,user);
                }else callback('EXPIRED',null);
            });
        }
    });
};


userSchema.methods.verifyToken = function(token,callback) {
    var now = new Date();
    var expire = new Date(this.token_time.getTime());
    expire.setMinutes(expire.getMinutes() + 120);
    // Prevent Invalid Token
    var now = new Date();
    if(token==undefined || token == null){ console.log('no token');  callback(false); }
    else if (token.length<10) callback(false);
    else if (token == this.token && now < expire && now > this.token_time){ callback(true); }
    else {  callback(false); }
};

userSchema.methods.renewToken = function() {
    this.token = Math.random().toString(36).substr(2) + Math.random().toString(36).substr(2);
    this.token_time = new Date();
    this.save();
    return this.token;
};

userSchema.methods.destroyToken = function() {
    this.token = '';
    this.token_time = 0;
    this.save();
};

//------------ External Methods -----------------//

// Username Password Login
userSchema.statics.login = function(username,password,callback){
    this.findOne({username:username},function(err,user){
        if(err){ callback('USER_OPERATION_ERROR'); return; }
        else if(!user || user=='' || user ==null){ callback(null,null,"USER_NOT_FOUND"); return; }
        else{
            if(user.verifyPassword(password)){  // Login Successful
                var token = user.renewToken();
                if(user.admin){
                    callback(null,token,null,true);
                    return;
                }else{
                    callback(null,token,null,false);
                    return;
                }
            }else{
                callback(null,null,"USER_NOT_FOUND"); return;
            }
        }
    });
};




userSchema.statics.renew = function(token,callback){
    this.findOne({token: token},function(err,user){
        if(err) callback('USER_OPERATION_ERROR');
        else if(!user || user=='' || user ==null){ callback('USER_TOKEN_NOT_FOUND');}
        else{
            user.verifyToken(token,function(verified){
                if(verified){
                    var newtoken = user.renewToken();
                    callback(null,newtoken);
                }else{
                    callback('USER_NOT_FOUND');
                }
            });
        }
    });
};

userSchema.statics.securityCheck = function(token,callback){
    this.findOne({token: token},function(err,user){
        if(err){ callback('USER_OPERATION_ERROR'); return;}
        else if(!user || user=='' || user ==null){ callback('USER_TOKEN_NOT_FOUND',null);return;}
        else{
            user.verifyToken(token,function(verified){
                if(verified){
                    callback(null,user.admin);
                    return;
                }else callback('EXPIRED',null);
            });
        }
    });
};

//------------ CRUD Functions 

// Add User include validators
userSchema.statics.add = function(newUser,callback){
	this.findOne({username:newUser},function(err,user){
			var usr = new User(newUser);
			usr.token = '';
			usr.token_time = 0;
			usr.create_at = new Date();
			usr.update_at = new Date();
			usr.selfGenHash();
			usr.save(function(err){
            if(err){ console.log(err); callback('USER_OPERATION_ERROR'); }
            else callback(null,usr._id);
        });
	});
};

// Edit User 
userSchema.statics.edit = function(columns,callback){
    this.findById(columns.id,function(err,user){
        if(err) { console.log(err); callback('USER_OPERATION_ERROR'); }
        else if(!user || user=='' || user ==null){ callback('USER_NOT_FOUND',null); }
        else{
            if(columns.username!=null && columns.username!=undefined) user.username = columns.username;
            if(columns.password!=null && columns.password!=undefined) user.password = user.generateHash(columns.password);
            if(columns.admin!=null    && columns.admin!=undefined) user.admin = columns.admin;
            user.update_at = new Date();
            user.save(function(err){
                if(err) callback('USER_OPERATION_ERROR');
                else callback(null,user._id);
            });
        }
    });
};

// Delete User
userSchema.statics.removal = function(ids,callback){
    this.remove({_id: {$in: ids}},function(err){
        if(err) { console.log(err); callback('USER_OPERATION_ERROR'); }
        else{ 
            callback(null,true);
        }
    });
};

userSchema.statics.lastAdmin = function(){
    return new Promise((resolve,reject)=>{
        User.count({admin:true},function(err,total){
            if(err){ console.log('Last Admin Error: '+err); reject('USER_OPERATION_ERROR'); }
            else{
                if(total>1) resolve(false);
                else resolve(true);
            }
        })
    });
}

// Search User
userSchema.statics.search = function(id,callback){
    if(id==null){
        User.find({},function(err,users){
            if(err) { console.log(err); callback('USER_OPERATION_ERROR'); }
            else if(!users || users=='' || users ==null){ callback('USER_NOT_FOUND'); return; }
            else{
                var userList = [];
                users.forEach(function(user) {
                    var usr = {
                        "id": user._id,
                        "username": user.username,
                        "admin" : user.admin,
                        "create_at": user.create_at,
                        "update_at": user.update_at
                    }
                    userList.push(usr);
                });
                
                callback(null,userList);
            }
        });
    }else{      // Reserve only
        User.findById(id,function(err,user){
            if(err) { console.log(err); callback('USER_OPERATION_ERROR'); }
            else if(!usr || usr=='' || usr ==null) callback('USER_NOT_FOUND');
            else{
                var usr = {
                    "id": user._id,
                    "username": user.username,
                    "admin" : user.admin,
                    "create_at": user.create_at,
                    "update_at": user.update_at
                }
                callback(null,usr);
            }
        });
    }
};


var User = mongoose.model('User', userSchema);


module.exports = User;