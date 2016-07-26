//factory for handling sending the checkout cart to the server for purchase. This factory contains data relating to the checkout process
app.factory('cartCheckout', ["$log", "$http", "$q", "$rootScope", function($log, $http, $q, $rootScope) {
    //self declared to keep track of this
    var self = this;

    self.checkoutStatus = null;

    self.orderNumber = '';
    //broadcastSuccess method for sending a message to any controller that has a handler for the message
    self.broadcastSuccess = function() {
        $rootScope.$broadcast('checkoutBroadcast');
    };
    //checkout method makes an http request to the server. Takes the authentication token, checkout array, cart quantity, and cart total as parameters
    self.checkout = function(token, array, itemCount, shipping, total) {
        //creates the cart object to be sent to the server
        var cart = {};
        //loops over the array and changes each index into a key value pair in the cart object
        for (var i = 0; i < array.length; i++) {
            cart[array[i].name] = {
                id: array[i].id,
                count: array[i].count,
                cost: array[i].cost,
            };
        }
        //defer the response
        var deffered = $q.defer();

        return $http({
            url: './php/checkout.php',
            method: 'POST',
            data: {
                token: token,
                shipping_time: shipping,
                quantity: itemCount,
                cart: cart,
                total: total
            }
        }).then(function successCallack(data) {
            //set the variables equal to what was recieved
            console.log(data);
            var result = data.data.success;
            self.checkoutStatus = result.success;
            self.orderNumber = result.order_number;
            //broadcast the message for a successful cart checkout
            self.broadcastSuccess();
            //return the deferred response
            return deffered.resolve(result.success);
        }, function errorCallback(err) {
            $log.warn("Error: ", err);
        });
    };
    return self;
}]);
