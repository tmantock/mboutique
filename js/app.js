var app = angular.module("mboutiqueApp",['ngRoute',]);

app.config(["$routeProvider",function ($routeProvider) {
    $routeProvider
        .when('/',{
            templateUrl: 'home.php',
            controller: 'dateController as dc',
            title: 'Mboutique'
        })
        .when('/macarons',{
                templateUrl: 'our-macarons.php',
                controller: 'shopController as sc',
                title: 'Shop'
        })
        .when('/gifts',{
                templateUrl: 'gifts-parties.php',
                controller: 'partyController as pc',
                title: 'GIfts & Parties'
        })
        .when('/contact',{
                templateUrl: 'contact.php',
                controller: 'contactController as cc',
                title: 'Contact'
        })
        .when('/cart',{
                templateUrl: 'cart.php',
                controller: 'cartController as crc',
                title: 'Cart'
        })
        .otherwise({
                redirectTo: '/'
        });
}]);

app.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
      if (current.hasOwnProperty('$$route')) {
        $rootScope.title = current.$$route.title;
      }
    });
}]);

app.controller("mainController",['macaronCart','$log','$scope',function(macaronCart,$log,$scope){
  var self = this;
  $scope.title = "Mboutique";
  $scope.macarons = macaronCart.retrieveMacarons();
  $scope.cart = '';
  $scope.$on('handleBroadcast', function() {
    $scope.macarons = macaronCart.macarons;
    $scope.cart = macaronCart.itemCount;
  });
}]);
