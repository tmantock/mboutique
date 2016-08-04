//factory for handling sending the checkout cart to the server for purchase. This factory contains data relating to the checkout process
app.factory('cartCheckout', ["$log", "$http", "$q", "$rootScope", function($log, $http, $q, $rootScope) {
    //self declared to keep track of this
    var self = this;

    self.checkoutStatus = null;

    self.orderNumber = '';

    self.shipping_time = 2;

    self.errorTitle = '';

    self.errorMessage = '';

    self.setErrorMessage = function (title,message) {
      self.errorTitle = title;
      self.errorMessage = message;
      self.checkoutStatus = false;
      self.broadcastSuccess();
    }
    //broadcastSuccess method for sending a message to any controller that has a handler for the message
    self.broadcastSuccess = function() {
        $rootScope.$broadcast('checkoutBroadcast');
    };
    //checkout method makes an http request to the server. Takes the authentication token, checkout array, cart quantity, and cart total as parameters
    self.checkout = function(token, array, itemCount, shipping, total, customer, status) {
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
                total: total,
                customer: customer,
                customer_status: status
            }
        }).then(function successCallack(data) {
          console.log(data);
            //set the variables equal to what was recieved
            var result = data.data.success;
            self.checkoutStatus = result.success;
            self.orderNumber = result.order_number;
            self.shipping_time = result.shipping;
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
