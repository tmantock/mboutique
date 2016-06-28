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
        name: user_info.name,
        email: user_info.email,
        phone: user_info.phone,
        street_address: user_info.address,
        city: user_info.city,
        state: user_info.state,
        zip: user_info.zip,
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
