app.controller("partyController", ['$scope', 'macaronCart', function($scope, macaronCart) {
    var self = this;
    $scope.macarons = macaronCart.retrieveMacarons();
    $scope.cart = '';
    $scope.title = "Gifts & Parties";
    $scope.$on('handleBroadcast', function() {
        $scope.macarons = macaronCart.macarons;
        $scope.cart = macaronCart.itemCount;
    });

    self.day = day();

    self.giftCartControl = function(gift, value, index) {
        if (self.day == 'Sunday') {
            index = index + 17;
        } else {
            index = index + 17;
        }
        console.log($scope.macarons[index]);
        if ($scope.macarons[index].count >= 0 && value === 1) {
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

function day() {
    var date = new Date();
    var weekday = new Array(7);
    weekday[0] = "Sunday";
    weekday[1] = "Monday";
    weekday[2] = "Tuesday";
    weekday[3] = "Wednesday";
    weekday[4] = "Thursday";
    weekday[5] = "Friday";
    weekday[6] = "Saturday";
    var day = weekday[date.getDay()];
    return day;
}
