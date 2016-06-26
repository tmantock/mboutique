app.controller("dateController", ['macaronCart','$scope','$log','$timeout',function(macaronCart, $scope,$log,$timeout) {
    var self = this;
    $scope.macarons = macaronCart.retrieveMacarons();
    self.days = macaronCart.getDays();
    $scope.cart = '';
    $scope.title = "Mboutique";
    self.flavor = macaronCart.getFlavor();
    $scope.$on('handleBroadcast', function() {
      $scope.macarons = macaronCart.macarons;
      $scope.cart = macaronCart.itemCount;
      $scope.days = macaronCart.days;
      self.flavor = macaronCart.flavor;
     });
}]);
