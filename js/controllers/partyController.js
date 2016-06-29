app.controller("partyController", ['$scope', 'macaronCart','cartCheckout','loginService',function($scope, macaronCart,cartCheckout,loginService) {
    var self = this;
    $scope.macarons = macaronCart.retrieveMacarons();
    $scope.cart = '';
    $scope.title = "Gifts & Parties";
    $scope.$on('handleBroadcast', function() {
        $scope.macarons = macaronCart.macarons;
        $scope.cart = macaronCart.itemCount;
    });

    self.giftCartControl = function(gift, value, index) {
        index = index + 18;
        console.log($scope.macarons);
        if($scope.macarons[index].count >= 0 && value === 1) {
            $scope.macarons[index].count += 1;
        } else if ($scope.macarons[index].count > 0 && value === 0) {
            $scope.macarons[index].count -= 1;
        }
        self.sendToCart();
    };

    self.sendToCart = function() {
        for (var i = 0; i < $scope.macarons.length; i++) {
            var gift = $scope.macarons[i];
            if (gift.count > 0) {
                $scope.cart[gift.name] = gift.count;
            }
        }
        macaronCart.updateMacarons($scope.macarons);
    };
}]);
