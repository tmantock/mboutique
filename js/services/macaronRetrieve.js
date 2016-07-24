//factory for retrieving shopping data from the server and managing any changes to that data. The data that all the controllers require for the macarons for shopping are stored in this factory.
app.factory("macaronCart", ["$http", "$log", "$rootScope", function($http, $log, $rootScope) {
    //cart object declared for storing properties
    var cart = {};

    cart.macarons = [];

    cart.days = [];

    cart.itemCount = 0;

    cart.flavor = {};

    cart.checkoutArray = [];

    cart.total = 0;

    cart.tax = 0;

    cart.shipping = 0;
    //retrieveMacarons method retrieving the macaron array on request. Returns the macaron array
    cart.retrieveMacarons = function() {
        return cart.macarons;
    };
    //getFlavor method for retrieving the flavor of the day. Returns the flavor of the day
    cart.getFlavor = function() {
        return cart.flavor;
    };
    //getDays method for retrieving the macarons with special day properties. Returns an array of special macarons
    cart.getDays = function() {
        return cart.days;
    };
    //generateFlavor method for generating the array of special macarons
    cart.generateFlavor = function(date) {
        //loops through the array of macarons and finds the ones with special day properties.
        for (var i = 0; i < cart.macarons.length; i++) {
            //if macaron with speacial date property matches today's date
            if (cart.macarons[i].day == date) {
                //reassign the category to work with the ng-filter on the shop page
                cart.macarons[i].category = '1';
                //assigns the macaron to the flavor variable
                cart.flavor = cart.macarons[i];
                //takes the macaron out of the macaron array
                cart.macarons.splice(i, 1);
                //pushes the macaron to the front of the array
                cart.macarons.unshift(cart.flavor);
                //calls the broadcastItem method to send a message to all controllers that have a handler
                cart.broadcastItem();
            }
        }
    };
    //generateCheckout method for finding all macarons that have a quantity greater than 0 and adding them to the checkout array
    cart.generateCheckout = function() {
        var checkoutArray = [];
        //loop through the macaron array to find macarons and push added macarons to the checkout array
        for (var i = 0; i < cart.macarons.length; i++) {
            var item = cart.macarons[i];
            if (item.count > 0) {
                item.itemTotal = item.count * item.cost;
                checkoutArray.push(item);
            }
        }
        //set the checkoutArray variable to the checkoutArray
        cart.checkoutArray = checkoutArray;
        //return the checkoutArray
        return cart.checkoutArray;
    };
    cart.calculateFinalCost = function (shipping,state) {
      cart.httpCalculate(cart.checkoutArray,shipping,state);
    };
    //updateMacarons method takes in an array as a parameter. Sets the local macaron array to the array it was sent calls other methods to update the item count, total, and checkout array, then calls the broadcast function to transmit the message
    cart.updateMacarons = function(array) {
        cart.macarons = array;
        cart.getItemCount();
        cart.calculateTotal();
        cart.generateCheckout();
        cart.broadcastItem();
    };
    //getItemCount method determing the number of macarons the user has added.
    cart.getItemCount = function() {
        var counter = 0;
        //loops through the macaron array and totals all the items in the array
        for (var i = 0; i < cart.macarons.length; i++) {
            var macaron = cart.macarons[i];
            counter += macaron.count;
        }
        cart.itemCount = counter;
    };
    //getTotal method to return cart total
    cart.getTotal = function () {
      return cart.total;
    };
    //getTax method to return cart tax
    cart.getTax = function () {
      return cart.tax;
    };
    //getShipping method to return cart shipping
    cart.getShipping = function () {
      return cart.shipping;
    };
    //calculateTotal method for calculating the cart total
    cart.calculateTotal = function() {
        var total = 0;
        //loops throug the checkout array and multiplies the quantiy by the cost to find the total
        for (var i = 0; i < cart.checkoutArray.length; i++) {
            total += cart.checkoutArray[i].cost * cart.checkoutArray[i].count;
        }
        cart.total = total;
    };
    //broadcastItem method for broadcasting any changes to controllers with a handler
    cart.broadcastItem = function() {
        $rootScope.$broadcast('handleBroadcast');
    };
    //httpMacaron method for making an http request to the server to retrieve the macarons from the database
    cart.httpMacaron = function() {
        return $http.get("./php/mysql_connect.php")
            .success(function(data) {
                //on success get today's date
                var date = new Date();
                //set an array of days
                var weekday = new Array(7);
                weekday[0] = "Sunday";
                weekday[1] = "Monday";
                weekday[2] = "Tuesday";
                weekday[3] = "Wednesday";
                weekday[4] = "Thursday";
                weekday[5] = "Friday";
                weekday[6] = "Saturday";
                var day = weekday[date.getDay()];
                //get the macarons with a special date property and push them to the days array
                var days = [];
                for (var index in data) {
                    data[index].count = 0;
                    //Cannot protect object due to Amgular adding $$hashKey to keep track of objects
                    //Object.seal(data[index]);
                    if (parseInt(data[index].category) === 2) {
                        days.push(data[index]);
                    }
                }

                cart.days = days;
                cart.macarons = data;
                cart.generateFlavor(day);

                $log.log("Shopping Data Retrieved");
                return data;
            })
            .error(function(err) {
                $log.warn(err);
                return err;
            });
    };

    cart.httpCalculate = function (array,shipping, state) {
      return $http({
        url: './php/calculate.php',
        method: 'POST',
        data: {
          cart: array,
          shipping_time: shipping,
          state: state
        },
        headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
        }
      }).then(function successCallack(data){
        console.log(data);
        var result = data.data;
        if(result.success === true){
          cart.total = result.total;
          cart.tax = result.tax;
          cart.shipping = result.shipping;
          cart.broadcastItem();
        }
      },function errorCallback(err) {
        $log.err(err);
      });
    };

    cart.httpMacaron();

    return cart;
}]);
