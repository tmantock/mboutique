//Angular app is initiazlied
var app = angular.module("mboutiqueApp", ['ngRoute','ngAnimate','ui.bootstrap']);
//Routes are set
app.config(["$routeProvider", function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'home.html',
            controller: 'dateController as dc',
            title: 'MBoutique'
        })
        .when('/macarons', {
            templateUrl: 'our-macarons.html',
            controller: 'shopController as sc',
            title: 'Shop'
        })
        .when('/gifts', {
            templateUrl: 'gifts-parties.html',
            controller: 'partyController as pc',
            title: 'Gifts & Parties'
        })
        .when('/contact', {
            templateUrl: 'contact.html',
            controller: 'contactController as cc',
            title: 'Contact'
        })
        .when('/cart', {
            templateUrl: 'cart.html',
            controller: 'cartController as crc',
            title: 'Cart'
        })
        .otherwise({
            redirectTo: '/'
        });
}]);

//Run block initiated to kickstart the application.
app.run(['$location', '$rootScope','$window', function($location, $rootScope, $window) {
    //Eventhandler for handling the change of a route. This handler changes the title of the page to the corresponding page title as defined in the router config
    $rootScope.$on('$routeChangeSuccess', function(event, current, previous) {
        if (current.hasOwnProperty('$$route')) {
            $rootScope.title = current.$$route.title;
        }
    });
}]);
//default MainController is initialized
app.controller("mainController", ['macaronCart', '$log', '$scope','cartCheckout','$timeout', function(macaronCart, $log, $scope, cartCheckout,$timeout) {
    //variable self set to this to keep track of this
    var self = this;
    //macaron array is retrieved from the macaron service
    $scope.macarons = macaronCart.retrieveMacarons();
    $scope.cart = '';
    //Eventhandler for handling a broadcast message that is sent by the macaron service whenever the macaron array has been altered
    $scope.$on('handleBroadcast', function() {
        //macaron array is set to updated macaron array
        $scope.macarons = macaronCart.macarons;
        //cart total is updated to the updated cart total
        $scope.cart = macaronCart.itemCount;
    });
    //method for allowing the navbar to collapse when a link is pressed
    angular.element(document).ready(function() {
        $('.navbar a.n_link').click(function() {
            $timeout(function() {
                var navbar_toggle = $('.navbar-toggle');
                if (navbar_toggle.is(':visible')) {
                    navbar_toggle.trigger('click');
                }
            }, 300);
        });
    });
}]);
