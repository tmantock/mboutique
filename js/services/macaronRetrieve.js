app.service("macaronRetrieve",["$http","$log",function($http,$log){
  var self = this;
  self.retrieveMacarons = function () {
    return $http.get("./php/mysql_connect.php").success(function(data) {$log.log(data); return data;}).error(function (err) {$log.warn(err);return err;});
  };
}]);
