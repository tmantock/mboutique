app.factory('stateService', ['$http','$log', function ($http,$log) {
  return $http.get('./php/states-list.php').success(function (data) {
    console.log(data);
    return data;
  }).error(function (err) {
    $log.error(err);
  });
}]);
