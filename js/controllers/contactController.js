app.controller("contactController", ['$scope','macaronCart',function($scope,macaronCart){
  $scope.macarons = [];
  $scope.cart = '';
  $scope.title = "Contact";
  $scope.$on('handleBroadcast', function() {
    $scope.macarons = macaronCart.macarons;
    $scope.cart = macaronCart.itemCount;
   });
}]);
