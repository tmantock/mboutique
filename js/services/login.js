app.factory("loginService", ["$http","$log","$rootScope", function($http,$log,$rootScope){

  var login = {};

  login.token = null;

  login.message = null;

  login.broadcastCredentials = function () {
    console.log("Successful Broadcast");
    $rootScope.$broadcast('loginBroadcast');
  };

  login.httpLogin = function (username,password) {
    return $http({
    url: './php/api-call.php',
    method: 'POST',
    data: {
      username : username,
      password : password
    },
    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
  }).then(function successCallack (data){
    var result = data.data;
    console.log(result);
      if(result.success.success === true){
        login.token = result.success.token;
        login.broadcastCredentials();
    }
  }, function errorCallback (err){
    var result = data.data
    if(result.success === false){
      login.message = result.error.message;
      login.broadcastCredentials();
    }
  });
};
  return login;
}]);
