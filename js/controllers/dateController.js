app.controller("dateController", ['macaronCart','$scope','$log','$timeout','cartCheckout','loginService',function(macaronCart, $scope,$log,$timeout,cartCheckout,loginService) {
    var self = this;
    $scope.macarons = macaronCart.retrieveMacarons();
    self.days = macaronCart.getDays();
    $scope.cart = '';
    $scope.title = "MBoutique";
    self.flavor = macaronCart.getFlavor();
    $scope.$on('handleBroadcast', function() {
      $scope.macarons = macaronCart.macarons;
      $scope.cart = macaronCart.itemCount;
      $scope.days = macaronCart.days;
      self.flavor = macaronCart.flavor;
     });
}]);
