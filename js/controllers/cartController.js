app.controller("cartController", ['$scope','macaronCart','cartCheckout','loginService',function($scope,macaronCart,cartCheckout,loginService){
  var self = this;
  $scope.token = null;
  $scope.message = null;
  $scope.status = false;
  self.checkoutStatus = null;
  $scope.macarons = macaronCart.retrieveMacarons();
  $scope.cart = macaronCart.itemCount;
  $scope.title = "Cart";
  $scope.name = '';
  $scope.orderNumber = '';
  self.showSignUp = false;
  self.showSignIn = false;
  $scope.checkout = macaronCart.generateCheckout();
  $scope.total = macaronCart.calculateTotal();
  $scope.$on('handleBroadcast', function() {
    $scope.macarons = macaronCart.macarons;
    $scope.cart = macaronCart.itemCount;
    $scope.total = macaronCart.total;
    $scope.checkout = macaronCart.checkoutArray;
  });

  $scope.$on('loginBroadcast', function(){
    $scope.token = loginService.token;
    $scope.message = loginService.message;
    $scope.status = loginService.status;
    $scope.name = loginService.name;
    self.check();
  });

  $scope.$on('successBroadcast', function () {
    $scope.orderNumber = cartCheckout.orderNumber;
    self.checkoutStatus = cartCheckout.checkoutStatus;
    self.checkCheckout();
  });

  self.states = [
    {name: 'Select a State', addreviation: 'Select'},
    { name: 'ALABAMA', abbreviation: 'AL'},
    { name: 'ALASKA', abbreviation: 'AK'},
    { name: 'AMERICAN SAMOA', abbreviation: 'AS'},
    { name: 'ARIZONA', abbreviation: 'AZ'},
    { name: 'ARKANSAS', abbreviation: 'AR'},
    { name: 'CALIFORNIA', abbreviation: 'CA'},
    { name: 'COLORADO', abbreviation: 'CO'},
    { name: 'CONNECTICUT', abbreviation: 'CT'},
    { name: 'DELAWARE', abbreviation: 'DE'},
    { name: 'DISTRICT OF COLUMBIA', abbreviation: 'DC'},
    { name: 'FEDERATED STATES OF MICRONESIA', abbreviation: 'FM'},
    { name: 'FLORIDA', abbreviation: 'FL'},
    { name: 'GEORGIA', abbreviation: 'GA'},
    { name: 'GUAM', abbreviation: 'GU'},
    { name: 'HAWAII', abbreviation: 'HI'},
    { name: 'IDAHO', abbreviation: 'ID'},
    { name: 'ILLINOIS', abbreviation: 'IL'},
    { name: 'INDIANA', abbreviation: 'IN'},
    { name: 'IOWA', abbreviation: 'IA'},
    { name: 'KANSAS', abbreviation: 'KS'},
    { name: 'KENTUCKY', abbreviation: 'KY'},
    { name: 'LOUISIANA', abbreviation: 'LA'},
    { name: 'MAINE', abbreviation: 'ME'},
    { name: 'MARSHALL ISLANDS', abbreviation: 'MH'},
    { name: 'MARYLAND', abbreviation: 'MD'},
    { name: 'MASSACHUSETTS', abbreviation: 'MA'},
    { name: 'MICHIGAN', abbreviation: 'MI'},
    { name: 'MINNESOTA', abbreviation: 'MN'},
    { name: 'MISSISSIPPI', abbreviation: 'MS'},
    { name: 'MISSOURI', abbreviation: 'MO'},
    { name: 'MONTANA', abbreviation: 'MT'},
    { name: 'NEBRASKA', abbreviation: 'NE'},
    { name: 'NEVADA', abbreviation: 'NV'},
    { name: 'NEW HAMPSHIRE', abbreviation: 'NH'},
    { name: 'NEW JERSEY', abbreviation: 'NJ'},
    { name: 'NEW MEXICO', abbreviation: 'NM'},
    { name: 'NEW YORK', abbreviation: 'NY'},
    { name: 'NORTH CAROLINA', abbreviation: 'NC'},
    { name: 'NORTH DAKOTA', abbreviation: 'ND'},
    { name: 'NORTHERN MARIANA ISLANDS', abbreviation: 'MP'},
    { name: 'OHIO', abbreviation: 'OH'},
    { name: 'OKLAHOMA', abbreviation: 'OK'},
    { name: 'OREGON', abbreviation: 'OR'},
    { name: 'PALAU', abbreviation: 'PW'},
    { name: 'PENNSYLVANIA', abbreviation: 'PA'},
    { name: 'PUERTO RICO', abbreviation: 'PR'},
    { name: 'RHODE ISLAND', abbreviation: 'RI'},
    { name: 'SOUTH CAROLINA', abbreviation: 'SC'},
    { name: 'SOUTH DAKOTA', abbreviation: 'SD'},
    { name: 'TENNESSEE', abbreviation: 'TN'},
    { name: 'TEXAS', abbreviation: 'TX'},
    { name: 'UTAH', abbreviation: 'UT'},
    { name: 'VERMONT', abbreviation: 'VT'},
    { name: 'VIRGIN ISLANDS', abbreviation: 'VI'},
    { name: 'VIRGINIA', abbreviation: 'VA'},
    { name: 'WASHINGTON', abbreviation: 'WA'},
    { name: 'WEST VIRGINIA', abbreviation: 'WV'},
    { name: 'WISCONSIN', abbreviation: 'WI'},
    { name: 'WYOMING', abbreviation: 'WY' }
];

  self.customer = {
    password: '',
    confirm:'',
    name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    state: '',
    zip: ''
  };

  self.removeItem = function (item,index) {
    var macaron = parseInt(item.id);
    for(var i = 0; i < $scope.macarons.length; i++){
      if(parseInt($scope.macarons[i].id) === macaron){
        $scope.macarons[i].count = 0;
      }
    }
    macaronCart.updateMacarons($scope.macarons);
  };

  self.resetCart = function () {
    $scope.checkout = [];
    $scope.cart = 0;
    $scope.total = 0;
    for(var i = 0; i < $scope.macarons.length; i++){
      $scope.macarons[i].count = 0;
    }
    console.log("Cart has been emptied");
  };

  self.newCustomer = function () {
    if(self.customer.password == self.customer.confirm){
      loginService.httpLogin(self.customer,false);
    }
    else {
      $scope.modalText = "Error! Please make sure that passwords are matching.";
      $("#modal").modal("show");
    }
  };

  self.checkout = function () {
    cartCheckout.checkout($scope.token,$scope.checkout,$scope.cart,$scope.total);
  };

  self.login = function () {
    var login = loginService.httpLogin(self.customer,true);
  };

  self.check = function () {
    console.log("Check called" , $scope.status);
    if($scope.status === false){
      $scope.modalText = $scope.message;
      $("#modal").modal('show');
    }
    if($scope.status === true){
      console.log("In Check");
      self.showSignUp = false;
      self.showSignIn = false;
    }
  };

  self.checkCheckout = function () {
    console.log("Checking");
    if(self.checkoutStatus === true){
      self.name = $scope.name;
      self.orderNumber = $scope.orderNumber;
      $("#reciept-modal").modal("show");
    } else if (self.checkoutStatus === false) {
      console.log("Error: On Checkout confirmation");
    }
  };

  self.cancel = function (option) {
    $('input').html('');
    if(option === 0){
      console.log("close sign up");
      self.showSignUp = false;
    } else if(option === 1){
      console.log("close sign in");
      self.showSignIn = false;
    }
  };
}]);
