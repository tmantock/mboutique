//shopController is initialized to manage the data for the main shop page
app.controller("shopController", ['macaronCart', '$log', '$scope', 'cartCheckout', 'loginService', function(macaronCart, $log, $scope, cartCheckout, loginService) {
    //self is declared to keep track of this
    var self = this;
    //Eventhandler for handling a broadcast message that is sent by the macaron service whenever the macaron array has been altered
    $scope.$on('handleBroadcast', function() {
        //on update the macaron array and cart item quantity is updated
        $scope.macarons = macaronCart.macarons;
        $scope.cart = macaronCart.itemCount;
    });
    //initial retrieve of the macaron array from teh macaron service
    $scope.macarons = macaronCart.retrieveMacarons();
    $scope.cart = '';

    //macaronCartControl method for handling a customer adding an item to the cart
    //takes in three arguments: the macaron item, a value which determines if its an additional item or removal request, and the idex within the macaron array.
    self.macaronCartControl = function(macaron, value) {
        var item = parseInt(macaron.id);
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
