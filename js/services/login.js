app.factory("loginService", ["$http","$log","$rootScope",'$q', function($http,$log,$rootScope,$q){

  var login = {};

  login.token = null;

  login.errorTitle = null;

  login.errorMessage = null;

  login.name = '';

  login.status = null;

  login.count = 0;

  login.passwordMessage = '';

  login.getPasswordMessage = function () {
    return login.passwordMessage;
  };

  login.retrieveToken = function () {
    return login.token;
  };

  login.getStatus = function () {
    return login.status;
  };

  login.getErrorTitle = function () {
    return login.errorTitle;
  };

  login.getErrorMessage = function () {
    return login.errorMessage;
  };

  login.getName = function () {
    return login.name;
  };

  login.setErrorMessage = function (title, message) {
    login.errorTitle = title;
    login.errorMessage = message;
    login.status = false;
    login.broadcastCredentials();
  };

  login.logout = function () {
    login.status = null;
    login.token = null;
    login.name = null;
    login.errorTitle = null;
    login.errorMessage = null;
    login.passwordMessage = '';
    login.count = 0;
    login.broadcastCredentials();
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
    login.status = result.success;
      if(result.success === true){
        login.passwordMessage = '';
        login.count = 0;
        login.token = result.token;
        login.name = result.name;
        $log.log("User Data Retrieved");
      } else if(result.success === false){
        login.errorMessage = result.error.message;
        if(result.error.password === false){
          login.status = null;
          login.passwordMessage = "Password is incorrect.";
          login.count++;
          if(login.count >= 3){
            $("#password-modal").modal("show");
          }
        }
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
