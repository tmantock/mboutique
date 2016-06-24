var app = angular.module("mboutiqueApp",['ngRoute']);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/',{
            templateUrl: 'home.php',
            controller: 'dateController as dc'
        })
        .when('/macarons',{
                templateUrl: 'our-macarons.php',
                controller: 'shopController as sc'
        })
        .when('/gifts',{
                templateUrl: 'gifts-parties.php',
                controller: 'giftController as gc'
        })
        .when('/contact',{
                templateUrl: 'contact.php',
                controller: 'contactController as cc'
        })
        .when('/cart',{
                templateUrl: 'cart.php',
                controller: 'cartController as crc'
        })
        .otherwise({
                redirectTo: '/'
        });
});

app.controller("mainController",function () {

});
