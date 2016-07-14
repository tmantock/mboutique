var app = angular.module("mboutiqueApp", ['ngRoute','ngAnimate']);

app.config(["$routeProvider", function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'home.html',
            controller: 'dateController as dc',
            title: 'Mboutique'
        })
        .when('/macarons', {
            templateUrl: 'our-macarons.html',
            controller: 'shopController as sc',
            title: 'Shop'
        })
        .when('/gifts', {
            templateUrl: 'gifts-parties.html',
            controller: 'partyController as pc',
            title: 'GIfts & Parties'
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

app.run(['$location', '$rootScope','$window', function($location, $rootScope, $window) {
    $rootScope.$on('$routeChangeSuccess', function(event, current, previous) {
        if (current.hasOwnProperty('$$route')) {
            $rootScope.title = current.$$route.title;
        }
    });
}]);

app.controller("mainController", ['macaronCart', '$log', '$scope','$location','cartCheckout', function(macaronCart, $log, $scope, $location, cartCheckout) {
    var self = this;
    $scope.title = "MBoutique";
    $scope.macarons = macaronCart.retrieveMacarons();
    $scope.cart = '';
    $scope.$on('handleBroadcast', function() {
        $scope.macarons = macaronCart.macarons;
        $scope.cart = macaronCart.itemCount;
    });
    $scope.collapse = function () {
      $scope.isCollapsed = true;
    };
}]);
