//partyController initialized for managing the data of the Gifts and Parties page
app.controller("partyController", ['$scope', 'macaronCart', 'cartCheckout', 'loginService', function($scope, macaronCart, cartCheckout, loginService) {
    //self declared to keep track of this
    var self = this;
    //macaron array set to the array retrieved by macaron service
    $scope.macarons = macaronCart.retrieveMacarons();
    $scope.cart = '';
    //Eventhandler for handling a broadcast message that is sent by the macaron service whenever the macaron array has been altered
    $scope.$on('handleBroadcast', function() {
        //retrieves updated macaron array and cart quantity on update message
        $scope.macarons = macaronCart.macarons;
        $scope.cart = macaronCart.itemCount;
    });

    //addClick method for automatically adding a macaron if the macaron count is zero and the add to cart button has been clicked.
    self.addClick =function (id) {
      //loop through the macaron to find a match
      for(var i = 0; i < $scope.macarons.length; i++){
        var macaron = $scope.macarons[i];
        //if there's a match add a macaron only if the count is equal to 0
        if(parseInt(macaron.id) === parseInt(id) && parseInt(macaron.count) === 0){
          macaron.count++
        }
      }
      //update the MacaronArray in the macaron factory which eill update the data shown in view
      macaronCart.updateMacarons($scope.macarons);
    };
    //giftCartControl method for handling a customer adding an item to the cart
    //takes in three arguments: the gift item, a value which determines if its an additional item or removal request, and the idex within the macaron array.
    self.giftCartControl = function(gift, value) {
        //gift items are at the end of the macaron cart array, however when they are put through ng-repeat they are given a new index starting at 0. The number of items before the gifts in the master array must be added to the index value provided by ng-repeat
        var item = parseInt(gift.id);
        for (var i = 0; i < $scope.macarons.length; i++) {
            if (parseInt($scope.macarons[i].id) === item) {
                //conditional for handling if the user requested a gift to be added or removed. Also doesn't allow the count property for the item to go below zero
                if ($scope.macarons[i].count >= 0 && value === 1) {
                    $scope.macarons[i].count += 1;
                } else if ($scope.macarons[i].count > 0 && value === 0) {
                    $scope.macarons[i].count -= 1;
                }
            }
        }
        //macaron service is sent the updated macaron array
        macaronCart.updateMacarons($scope.macarons);
    };
}]);
