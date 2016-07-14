app.factory('cartCheckout',["$log","$http","$q","$rootScope", function($log,$http,$q,$rootScope){
  var self = this;

  self.checkoutStatus = null;

  self.orderNumber = '';

  self.broadcastSuccess = function () {
    console.log("Broadcasting");
    $rootScope.$broadcast('successBroadcast');
  };

  self.checkout = function (token,array,itemCount,total) {
    var cart = {};
    for(var i=0; i<array.length; i++){
      cart[array[i].name] = {
        id: array[i].id,
        quantity: array[i].count,
        cost: array[i].cost,
      };
    }

    var deffered = $q.defer();

    return $http({
      url: './php/checkout.php',
      method: 'POST',
      data: {
        token: token,
        quantity: itemCount,
        cart: cart,
        discount: 0,
        tax: 0,
        total: total
      }
    }).then(function successCallack(data) {
      var result = data.data.success;
      console.log(result);
      self.checkoutStatus = result.success;
      self.orderNumber = result.order_number;
      console.log(self.orderNumber);
      self.broadcastSuccess();
      return deffered.resolve(result.success);
    }, function errorCallback (err) {
      $log.warn("Error: ", err);
    });
  };

  return self;
}]);
