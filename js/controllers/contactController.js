app.controller("contactController", ['$scope','macaronCart','$timeout',function($scope,macaronCart,$timeout){
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
          center: {lat: 33.6839, lng: -117.7947},
          zoom: 12
        });

        marker = new google.maps.Marker({
            position: {lat: 33.6839, lng: -117.7947},
            map: map,
            title: 'MBoutique!'
          });
  })
}]);
