app.factory("loginService", ["$http","$log","$rootScope",'$q', function($http,$log,$rootScope,$q){

  var login = {};

  login.token = null;

  login.message = null;

  login.username = null;

  login.name = '';

  login.status = false;

  login.broadcastCredentials = function () {
    $rootScope.$broadcast('loginBroadcast');
  };

  login.httpLogin = function (customer,boolean) {
     var deferred = $q.defer();
    return $http({
    url: './php/api_call.php',
    method: 'POST',
    data: {
      username : customer.username,
      password : customer.password,
      name: customer.name,
      email: customer.email,
      phone: customer.phone,
      address: customer.address,
      city: customer.city,
      state: customer.state,
      zip: customer.zip,
      status: boolean
    },
    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
  }).then(function successCallack (data){
    var result = data.data;
    console.log(result);
    login.status = result.success;
      if(result.success.success === true){
        login.token = result.success.token;
        login.name = result.success.name;
        login.broadcastCredentials();
      } else if(result.success === false){
        login.username = result.error.username;
        login.message = result.error.message;
        login.broadcastCredentials();
      }
      $log.log("User Data Retrieved");
      return deferred.resolve(data.success);
  }, function errorCallback (err){
    var result = data.data;
    if(result.success === false){
      login.status = result.success.success;
      login.message = result.error.message;
      login.broadcastCredentials();
    }
  });
};
  return login;
}]);
