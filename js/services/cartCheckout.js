app.factory('cartCheckout',["$log","$http", function($log,$http){
  var self = this;
  self.checkout = function (user_info,array,total) {
    var cart = {};
    for(var i=0; i<array.length; i++){
      cart[array[i].name] = {
        id: array[i].id,
        quantity: array[i].count,
        cost: array[i].cost
      };
    }

    return $http({
      method: 'POST',
      url: '../php/checkout.php',
      data: {
        cart: cart,
        discount: 0,
        tax: 0,
        total: total
      }
    }).then(function successCallack(data) {
      $log.log("Success: " + data);
    }, function errorCallback (err) {
      $log.warn("Error: " + err);
    });
  };

  return self;
}]);
