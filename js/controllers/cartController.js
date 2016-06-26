app.controller("cartController", ['$scope','macaronCart',function($scope,macaronCart){
  $scope.macarons = [];
  $scope.cart = '';
  $scope.title = "Cart";
  $scope.checkout = macaronCart.generateCheckout();
  $scope.$on('handleBroadcast', function() {
    $scope.macarons = macaronCart.macarons;
    $scope.cart = macaronCart.itemCount;
   });
}]);
