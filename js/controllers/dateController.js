//dateCOntroller is initialized to handle content on the homepage
app.controller("dateController", ['macaronCart', '$scope', '$log', '$timeout', 'cartCheckout', 'loginService', function(macaronCart, $scope, $log, $timeout, cartCheckout, loginService) {
    //self is declared to keep track of this
    var self = this;
    //macaron array is set to the array retrieved by the macaron service
    $scope.macarons = macaronCart.retrieveMacarons();
    //retrieves the array of macarons that have special date property from the macaron service
    self.days = macaronCart.getDays();
    $scope.cart = '';
    //retrieves the flavor of the day from the macaron service
    self.flavor = macaronCart.getFlavor();
    //Eventhandler for handling a broadcast message that is sent by the macaron service whenever the macaron array has been altered
    $scope.$on('handleBroadcast', function() {
        //retrieves any information that may have been updated for the macaron array, item count, special macaron array, and the flavor of the day
        $scope.macarons = macaronCart.macarons;
        $scope.cart = macaronCart.itemCount;
        $scope.days = macaronCart.days;
        self.flavor = macaronCart.flavor;
    });
    //method for changing the header text
    //jQuery and Angular do not play well on some cases, so this method only uses jQuery methods for DOM manipulation
    self.changeHeader = function() {
        //jQuery returns on every method call, which allows for method chaining.
        //This function utilizes that as well as a series of nested callback functions to update the text when the fade animation completes
        $("#home-header").text("MBoutique")
            .delay(4000)
            .fadeOut(1500, function() {
                $("#home-header").text("Sweet");
                $("#home-header").fadeIn(1500, function() {
                    $("#home-header").fadeOut(1500, function() {
                        $("#home-header").text("Beautiful");
                        $("#home-header").fadeIn(1500, function() {
                            $("#home-header").fadeOut(1500, function() {
                                $("#home-header").text("Decadent");
                                $("#home-header").fadeIn(1500, function() {
                                    $("#home-header").fadeOut(1500, function() {
                                        $("#home-header").text("MBoutique");
                                        $("#home-header").fadeIn(1500, function() {
                                            self.changeHeader();
                                        }).delay(500);
                                    }).delay(500);
                                }).delay(500);
                            }).delay(500);
                        }).delay(500);
                    }).delay(500);
                }).delay(500);
            }).delay(500);
    };
    //changeHeader method is called
    self.changeHeader();
}]);
