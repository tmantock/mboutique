app.factory('cartCheckout',["$log","$http", function($log,$http){
  var self = this;
  self.checkout = function (token,array,itemCount,total) {
    var cart = {};
    for(var i=0; i<array.length; i++){
      cart[array[i].name] = {
        id: array[i].id,
        quantity: array[i].count,
        cost: array[i].cost,
      };
    }

    return $http({
      url: 'tevinmantock.com/mb_php/checkout.php',
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
      $log.log("Cart Successfully sent: ", data);
    }, function errorCallback (err) {
      $log.warn("Error: ", err);
    });
  };

  return self;
}]);
