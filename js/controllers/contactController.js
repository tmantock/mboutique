app.controller("contactController", ['$scope','macaronCart','$timeout','cartCheckout','loginService',function($scope,macaronCart,$timeout, cartCheckout,loginService){
  var self = this;
  $scope.macarons = [];
  $scope.cart = '';
  $scope.title = "Contact";
  $scope.$on('handleBroadcast', function() {
    $scope.macarons = macaronCart.macarons;
    $scope.cart = macaronCart.itemCount;
   });

  angular.element(document).ready(function() {
    var map;
    var marker;
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 33.6501, lng: -117.7436},
          zoom: 14
        });

        marker = new google.maps.Marker({
            position: {lat: 33.6501, lng: -117.7436},
            map: map,
            title: 'MBoutique!'
          });
  });
}]);
