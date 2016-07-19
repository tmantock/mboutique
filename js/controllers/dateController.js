app.controller("dateController", ['macaronCart', '$scope', '$log', '$timeout', 'cartCheckout', 'loginService', function(macaronCart, $scope, $log, $timeout, cartCheckout, loginService) {
    var self = this;
    $scope.macarons = macaronCart.retrieveMacarons();
    self.days = macaronCart.getDays();
    $scope.cart = '';
    $scope.title = "MBoutique";
    self.flavor = macaronCart.getFlavor();
    $scope.$on('handleBroadcast', function() {
        $scope.macarons = macaronCart.macarons;
        $scope.cart = macaronCart.itemCount;
        $scope.days = macaronCart.days;
        self.flavor = macaronCart.flavor;
    });

    self.changeHeader = function() {
        $("#home-header").text("MBoutique")
            .delay(750)
            .fadeOut(2000, function() {
                $("#home-header").text("Sweet");
                $("#home-header").fadeIn(2000, function() {
                    $("#home-header").fadeOut(2000, function() {
                        $("#home-header").text("Beautiful");
                        $("#home-header").fadeIn(2000, function() {
                            $("#home-header").fadeOut(2000, function() {
                                $("#home-header").text("Decadent");
                                $("#home-header").fadeIn(2000, function() {
                                    $("#home-header").fadeOut(2000, function() {
                                        $("#home-header").text("MBoutique");
                                        $("#home-header").fadeIn(2000, function() {
                                            self.changeHeader();
                                        }).delay(750);
                                    }).delay(750);
                                }).delay(750);
                            }).delay(750);
                        }).delay(750);
                    }).delay(750);
                }).delay(750);
            }).delay(750);
    };

    self.changeHeader();
}]);
