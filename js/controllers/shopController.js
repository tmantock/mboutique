app.controller("shopController", ['macaronCart','$log','$scope','cartCheckout',function(macaronCart,$log,$scope,cartCheckout){
  var self = this;
  $scope.$on('handleBroadcast', function() {
    $scope.macarons = macaronCart.macarons;
    $scope.cart = macaronCart.itemCount;
  });

  $scope.title = "Shop";
  $scope.macarons = macaronCart.retrieveMacarons();
  $scope.cart = '';

  self.macaronCartControl = function (macaron,value,index) {
    if($scope.macarons[index].count >= 0 && value === 1){
      $scope.macarons[index].count += 1;
    }else if ($scope.macarons[index].count > 0 && value === 0) {
      $scope.macarons[index].count -= 1;
    }
      self.sendToCart();
  };

  self.sendToCart = function () {
    for(var i=0; i<$scope.macarons.length; i++){
      var macaron = $scope.macarons[i];
      if(macaron.count>0){
        $scope.cart[macaron.name]= macaron.count;
      }
    }
    macaronCart.updateMacarons($scope.macarons);
  };
}]);
