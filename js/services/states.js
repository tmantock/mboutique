app.factory('stateService', ['$http','$log', function ($http,$log) {
  return $http.get('./php/states-call.php').success(function (data) {
    return data;
  }).error(function (err) {
    $log.error(err);
  });
}]);
