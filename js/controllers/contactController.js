app.controller("contactController", ['$scope','macaronCart','$timeout','cartCheckout','loginService',function($scope, macaronCart, $timeout, cartCheckout,loginService){
  var self = this;
  $scope.macarons = [];
  $scope.cart = '';
  $scope.title = "Contact";
  $scope.modalText = '';
  $scope.modalTitle = '';
  $scope.$on('handleBroadcast', function() {
    $scope.macarons = macaronCart.macarons;
    $scope.cart = macaronCart.itemCount;
  });

  self.sendMessage = function () {
    var link = $('<a>',{
      text: 'Github repository.',
      href: 'https://github.com/tmantock/mboutique',
      class: 'link',
      target: '_blank'
    });
    $(".modal-title").html("Thank you for your message!");
    $(".modal-body p").html("Thank you for your message. For demostratice purposes, the mail function has been disabled, since this is not a full deployed product. If you would like to see the code please visit the ").append(link);
    $("#modal").modal("show");
  };

  self.clearInputs = function () {
    $("#inputName").html('');
    $("#inputEmail").html('');
    $("#inputPhone").html('');
    $("#inputSubject").html('');
    $("#conctactComments").html('');
  };

  angular.element(document).ready(function() {
    var map;
    var marker;
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 33.6501, lng: -117.7436},
          zoom: 14,
          scrollwheel: false
        });

        marker = new google.maps.Marker({
            position: {lat: 33.6501, lng: -117.7436},
            map: map,
            title: 'MBoutique!'
          });
  });
}]);
