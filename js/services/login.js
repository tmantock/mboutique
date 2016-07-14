app.factory("loginService", ["$http","$log","$rootScope",'$q', function($http,$log,$rootScope,$q){

  var login = {};

  login.token = null;

  login.message = null;

  login.name = '';

  login.status = false;

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
        login.broadcastCredentials();
      } else if(result.success === false){
        console.log("Error on login");
      }
      $log.log("User Data Retrieved");
      return deferred.resolve(result.success);
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
