app.factory("loginService", ["$http","$log","$rootScope",'$q', function($http,$log,$rootScope,$q){

  var login = {};

  login.token = null;

  login.message = null;

  login.name = '';

  login.status = false;

  login.retrieveToken = function () {
    return login.token;
  };

  login.getStatus = function () {
    return login.status;
  };

  login.getMessage = function () {
    return login.message;
  };

  login.getName = function () {
    return login.name;
  };

  login.broadcastCredentials = function () {
    $rootScope.$broadcast('loginBroadcast');
  };

  login.httpLogin = function (customer,boolean) {
    var deferred = $q.defer();
    return $http({
    url: './php/api-call.php',
    method: 'POST',
    data: {
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
    console.log(data);
    login.status = result.success;
      if(result.success === true){
        login.token = result.token;
        login.name = result.name;
        $log.log("User Data Retrieved");
      } else if(result.success === false){
        login.message = result.error.message;
        console.log("Error on login");
      }
      login.broadcastCredentials();
      return deferred.resolve(result.success);
  }, function errorCallback (err){
      console.error(err);
  });
};
  return login;
}]);
