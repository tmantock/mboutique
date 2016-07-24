//contactController is initialized to manage data for the tcontact page
app.controller("contactController", ['$scope', 'macaronCart', 'cartCheckout', 'loginService', function($scope, macaronCart, cartCheckout, loginService) {
    //self is declared to keep track of this
    var self = this;
    //intializing variables
    $scope.macarons = [];
    $scope.cart = '';
    $scope.modalText = '';
    $scope.modalTitle = '';
    //Eventhandler for handling a broadcast message that is sent by the macaron service wheever the macaron array has been altered
    $scope.$on('handleBroadcast', function() {
        //Macaron service send an update message whenever the macaron array has been altered.
        //Retrieved updated macaron array and item count
        $scope.macarons = macaronCart.macarons;
        $scope.cart = macaronCart.itemCount;
    });

    //sendMessage method for adding text to the modal that appears when a user tries to send a message
    //method primarily uses jQuery methods. Experienced proplems using angular methods
    self.sendMessage = function() {
        //variable set to an 'a' element with its properties
        var link = $('<a>', {
            text: 'Github repository.',
            href: 'https://github.com/tmantock/mboutique',
            class: 'link',
            target: '_blank'
        });
        //Text gets added to the modal and the a tag get appended to the modal.
        $("#modal-title").html("Thank you for your message!");
        $("#modal-text").html("Thank you for your message. For demonstration purposes, the mail function has been disabled, since this is not a fully deployed production website used by an actual company. I expect that that users will most likely use fake email accounts, which is perfectly fine, so it would be best to not have email functionality active. If you would like to see the code please see the mailer in the php folder by visiting the ").append(link);
        $("#modal").modal("show");
    };
    //method for clearing the contants of the inputs upon a successful message send
    self.clearInputs = function() {
        $("#inputName").html('');
        $("#inputEmail").html('');
        $("#inputPhone").html('');
        $("#inputSubject").html('');
        $("#conctactComments").html('');
    };
    //angular's method for document ready used for intializing the google map on the contact page
    angular.element(document).ready(function() {
        var map;
        var marker;
        map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: 33.6501,
                lng: -117.7436
            },
            zoom: 14,
            scrollwheel: false
        });

        marker = new google.maps.Marker({
            position: {
                lat: 33.6501,
                lng: -117.7436
            },
            map: map,
            title: 'MBoutique!'
        });
    });
}]);
