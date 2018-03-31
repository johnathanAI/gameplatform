var Auth = require('./controllers/auth');

// Required Data Models
var User = require('./models/user');
var console = process.console;

var userManager = function(request,response){
    Auth.auth(request).then(function(user){
        Auth.securityCheck(request.body.token,function(err,admin){
            if(err){ response.json({token:request.body.token,message:'SECURITY_ERROR'}); }
            else{
                Auth.renew(request.body.token).then(function(token){
                    switch(request.body.action){
                        case "add" :
                            User.add(request.body.user,function(err,id){
                                if(err) response.json({token:token,message:err});
                                else{ response.json({token:token,message:"SUCCESS",id:id});}
                            });
                            break;
                        case "edit" :
                            User.edit(request.body.user,function(err,id){
                                if(err) response.json({token:token,message:err});
                                else{ response.json({token:token,message:"SUCCESS",id:id});}
                            });
                            break;
                        case "remove" :
                            if(String(user._id)==request.body.id){
                                console.log('User Remove Error: Removal Same ID');
                                response.json({token:token,message:'SELF_REMOVAL'});
                            }else{
                                User.lastAdmin().then(last=>{
                                    User.findById(request.body.id,function(err2,user){
                                        if(err2){
                                            console.log('User Remove Error: '+err2);
                                            response.json({token:token,message:err2});
                                        }
                                        else if(last===true && user['admin']==true){
                                            console.log('User Remove Error: Last Admin');
                                            response.json({token:token,message:'LAST_ADMIN'});
                                        }
                                        else{
                                            User.removal(request.body.id,function(err,id){
                                                if(err) response.json({token:token,message:err});
                                                else{ response.json({token:token,message:"SUCCESS"});}
                                            });
                                        }
                                    })
                                }).catch(err=>{
                                    console.log('User Remove Error: '+err);
                                    response.json({token:token,message:err});
                                })
                            }
                            break;
                        case "search" :
                            User.search(request.body.id,function(err,usrs){
                                if(err) response.json({token:token,message:err});
                                else{ response.json({token:token,message:"SUCCESS",user:usrs});}
                            });
                            break;
                        default :
                        response.json({token:token , message:"ACTION_ERROR"});
                        break;
                    };
                },function(err){
                    response.json({message:"AUTH_ERROR"});
                });
            };
        });
    }).catch(function(err){
        response.json({message:"AUTH_ERROR"});
    });
};
module.exports.userRoute = userManager;