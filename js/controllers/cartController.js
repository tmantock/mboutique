//cartController is initialized for managing data within the cart page
app.controller("cartController", ['$scope', 'macaronCart', 'cartCheckout', 'loginService', 'stateService', function($scope, macaronCart, cartCheckout, loginService, stateService) {
    //self is declared to keep track of this
    var self = this;
    //retrieve the authentication token from the login service
    $scope.token = loginService.retrieveToken();
    //retrieve the error message and error title from the login service for use in the error modal
    self.errorTitle = loginService.getErrorTitle();
    self.errorMessage = loginService.getErrorMessage();
    //retrieve teh user info from the database from the login service
    self.dbUser = loginService.getUser();
    //retrieve the status of a login attempt from the login service
    $scope.status = loginService.getStatus();
    //retrieve the macaron array form the macaron service
    $scope.macarons = macaronCart.retrieveMacarons();
    //retrieve the item count from the macaron service
    $scope.cart = macaronCart.itemCount;
    //retrieve the customers name from the macaron service
    $scope.name = loginService.getName();
    //retreive the checkout array from the macaron service
    $scope.checkout = macaronCart.generateCheckout();
    //retrieve the checkout total from the macaron service
    $scope.total = macaronCart.getTotal();
    //retrieve the checkout tax from the macaron service
    $scope.tax = macaronCart.getTax();
    //retrieve the checkout total form the macaron service
    $scope.shipping = macaronCart.getShipping();
    //retrieve the password error message from the login service on bad attempt
    $scope.passwordMessage = loginService.getPasswordMessage();
    self.checkoutStatus = null;
    $scope.orderNumber = '';
    self.showSignUp = false;
    self.showSignIn = false;
    self.update = false;
    self.shipping_time = 2;
    self.shipping = [2,3,5];
    //Eventhandler for handling a broadcast message that is sent by the macaron service whenever the macaron array has been altered
    $scope.$on('handleBroadcast', function() {
        //update the macaron array, item count, cart total, and checkout array on any pertinent changes
        $scope.macarons = macaronCart.macarons;
        $scope.cart = macaronCart.itemCount;
        $scope.tax = macaronCart.tax;
        $scope.shipping = macaronCart.shipping;
        $scope.total = macaronCart.total;
        $scope.checkout = macaronCart.checkoutArray;
    });
    //Eventhandler for handling a broadcast message that is sent by the login service whenever the a login attempt or new customer attempt has been made
    $scope.$on('loginBroadcast', function() {
        //update the token, status, and name on a successful user creation or login attempt.
        //update the error messages and status on a failed attempt
        $scope.token = loginService.token;
        self.errorTitle = loginService.errorTitle;
        self.errorMessage = loginService.errorMessage;
        self.dbUser = loginService.user;
        $scope.status = loginService.status;
        $scope.name = loginService.name;
        $scope.passwordMessage = loginService.passwordMessage;
        //check method is called to handle a successful or unsuccessful login or user creation attempt
        self.check();
    });
    //Eventhandler for handling a broadcast message that is sent by the checkout service whenever a request to send the cart to the server for checkout
    $scope.$on('checkoutBroadcast', function() {
        //updates the orderNumber on successful checkout.
        //updates checkout status on unsuccessful checkout attempt
        $scope.orderNumber = cartCheckout.orderNumber;
        self.checkoutStatus = cartCheckout.checkoutStatus;
        self.shipping_time = cartCheckout.shipping_time;
        self.errorTitle = cartCheckout.errorTitle;
        self.errorMessage = cartCheckout.errorMessage;
        //checkCheckout method is called to handle a successful or unsuccessfulcheckout atttempt
        self.checkCheckout();
    });
    //array of states
    self.states = stateService.success(function (data) {
      self.states = data;
    });
    //customer object that is sent for login
    self.customer = {
        name: '',
        email: '',
        password: '',
        confirm: '',
        phone: '',
        address: '',
        city: '',
        state: 'Select a State',
        zip: ''
    };
    //check method for handling a login attempt
    self.check = function() {
        //if a login attempt is successful then show the user the checkout page and empty the customer oject
        if ($scope.status === true) {
            self.calculateCost();
            self.showSignUp = false;
            self.showSignIn = false;
            self.update = false;
            for (var index in self.customer) {
                self.customer[index] = '';
            }
            self.customer.state = 'Select a State';
            $("#password-modal").modal('hide');
        }
        //if the loging attempt is unsuccessful then show the user the error message
        else if ($scope.status === false) {
            $scope.modalTitle = self.errorTitle;
            $scope.modalText = self.errorMessage;
            $("#modal").modal('show');
        }
    };
    //removeItem method for removing an item from the checkout array
    self.removeItem = function(item, index) {
        var macaron = parseInt(item.id);
        //loop through the macaron array to find the macaron within the macaron array by id. If there's a match then set the count property to zero for that item
        for (var i = 0; i < $scope.macarons.length; i++) {
            if (parseInt($scope.macarons[i].id) === macaron) {
                $scope.macarons[i].count = 0;
            }
        }
        //send updated macaron array to the macaron service
        macaronCart.updateMacarons($scope.macarons);
    };
    //resetCart method for setting all quantitiesand totals to zero
    self.resetCart = function() {
        macaronCart.itemCount = 0;
        macaronCart.total = 0;
        macaronCart.tax = 0;
        macaronCart.shipping = 0;
        for (var i = 0; i < $scope.macarons.length; i++) {
            $scope.macarons[i].count = 0;
        }
        //send updated macaron array to the macaron service
        macaronCart.updateMacarons($scope.macarons);
        console.log("Cart has been emptied");
    };
    //checkout method for calling the cart service's own checkout method.
    //send the the authentication token, cart, item count, and total
    self.checkout = function() {
      cartCheckout.checkout($scope.token, $scope.checkout, $scope.cart, self.shipping_time, $scope.total);
    };
    self.moveToCheckout = function () {
      if($scope.status === true){
        self.calculateCost();
      } else if($scope.status === false){
        
      }
    }
    self.calculateCost = function () {
      if($scope.checkout.length === 0){
        var title = "Cart Error";
        var message = "You cannot checkout with an empty cart";
        cartCheckout.setErrorMessage(title,message);
      }else{
        self.disableCheckout = false;
        macaronCart.calculateFinalCost(self.shipping_time,self.dbUser.state);
      }
    };
    //checkCheckout method for handling teh response of a checkout attempt
    self.checkCheckout = function() {
        //if the attempt was successful then the orderNumberis set and the reciept modal is displayed
        if (self.checkoutStatus === true) {
            self.name = $scope.name;
            self.orderNumber = $scope.orderNumber;
            $("#reciept-modal").modal("show");
        }
        //if the attempt failed then log the failed attempt in the console
        else if (self.checkoutStatus === false) {
          $scope.modalTitle = self.errorTitle;
          $scope.modalText = self.errorMessage;
          self.disableCheckout = true;
          $("#modal").modal('show');
            console.log("Error: On Checkout confirmation");
        }
    };
    //canel method for setting all inputs to an empty string and hiding the respective forms either sign-up or sign-in takes in one parameter a boolean
    self.cancel = function(option) {
        $('input').html('');
        if (option === 0) {
            self.showSignUp = false;
        } else if (option === 1) {
            self.showSignIn = false;
        }
    };
    //login method for sending the the customer to the login service for a login attempt
    self.login = function() {
        //if the validate method returns true then send the the customer to the login service along wih their status (new or existing)
        if (self.validate('login')) {
            loginService.httpLogin(self.customer, true, null);
        }
    };
    //login method for sendin the new customer to the login service. This method is alos used to handle setting up a new password for teh customer in teh event they forgot their password
    self.newCustomer = function(status) {
        //if the password and password confirmations pass tehn move on
        if (self.customer.password == self.customer.confirm) {
            //if it's a new customer and the validate method returns true then send the customer to the login service with their status
            if (status === 1 && self.validate('new')) {
                loginService.httpLogin(self.customer, false, null);
            }
            //if it's an existing customer who needs to update their password and the validate method returns true then send the customer with a status of 'exist' and reason of password
            else if (status === 0 && self.validate('password')) {
                loginService.httpLogin(self.customer, 'exist','password');
            }
        }
        //if the passwords do not match then display the error message to the user
        else {
            $("#modal-text").text("Error! Please make sure that passwords are matching.");
            $("#modal-title").text("Login Error");
            $("#modal").modal("show");
        }
    };
    //updateInfo method for allowing the user to change their information
    self.updateInfo = function () {
      self.customer.name = self.dbUser.name;
      self.customer.email = self.dbUser.email;
      self.customer.address = self.dbUser.street_address;
      self.customer.zip = self.dbUser.zip;
      self.customer.state = self.dbUser.state;
      self.customer.city = self.dbUser.city;
      self.customer.phone = self.dbUser.phone_number;
      $scope.status = false;
      self.update = true;
    };
    self.confirmUpdate = function () {
      //if it's an existing customer who wants to update their information and the validate method returns true then send the customer with a status of 'exist' and reason of update
      if(self.validate('update')) {
        loginService.httpLogin(self.customer,'exist','update');
      }
    };
    //logout method calls the login service's own logout method
    self.logout = function() {
        loginService.logout();
    };
    //validate method for validating the user's inputs. takes in one parameter a reason to determine which regex methods to use
    self.validate = function(reason) {
        //for loop for trimming the whitespaces/spaces of an inpput
        for (var index in self.customer) {
            self.customer[index].trim();
        }
        //if they are a new customer then call these regex methods, if they all return true then the validate method returns true
        if (reason === 'new') {
            if (self.nameRegex(self.customer.name, true) && self.nameRegex(self.customer.city, false) && self.emailRegex(self.customer.email) && self.passwordRegex(self.customer.password) && self.phoneRegex(self.customer.phone) && self.zipRegex(self.customer.zip) && self.addressRegex(self.customer.address)) {
                return true;
            }
        }
        //if they are an existing customer then call on the regex methods for email and password only if they return true then the validate method returns true
        else if (reason === 'login' || reason === 'password') {
            if (self.emailRegex(self.customer.email) && self.passwordRegex(self.customer.password)) {
                return true;
            }
        }
        //if the customer wants to update their information, check everything but the password and email
        else if(reason === 'update') {
          if (self.nameRegex(self.customer.name, true) && self.nameRegex(self.customer.city, false) && self.phoneRegex(self.customer.phone) && self.zipRegex(self.customer.zip) && self.addressRegex(self.customer.address) && self.passwordRegex(self.customer.password)) {
              return true;
          }
        }
    };

    //nameRegex property validates the inputs for the name field, takes a striing and a boolean as a parameter, since this method is also used to validate cities as well
    self.nameRegex = function(string, boolean) {
        //allow upper and lower case letters, periods, commas, apostrophes, and hyphens
        var exp = /^[a-z ,.'-]+$/i;
        var test = exp.test(string);
        var title;
        var message;
        //if the test returned false and the boolean queal to true then display name error messsage
        if (test === false && boolean === true) {
            title = "Form Error";
            message = "Please enter a valid name.";
            //calls login service error message method to handle error messages in one location
            loginService.setErrorMessage(title, message);
        }
        //if the test returned false and the boolean queal to true then display city error messsage
        else if (test === false && boolean === false) {
            title = "Form Error";
            message = "Please enter a valid city.";
            //calls login service error message method to handle error messages in one location
            loginService.setErrorMessage(title, message);
        }
        return test;
    };
    //emailRegex method for validating the email input.
    //takes string as a parameter
    self.emailRegex = function(string) {
        //email allows for letters,@, and .
        var exp = /\S+@\S+\.\S+/;
        var test = exp.test(string);
        if (test === false) {
            var title = "Form Error";
            var message = "Please enter a valid email.";
            //calls login service error message method to handle error messages in one location
            loginService.setErrorMessage(title, message);
        }
        return test;
    };
    //passwordRegex method for validating the password input.
    //takes string as a parameter
    self.passwordRegex = function(string) {
        //regex allows for letters and numbers. Must have at least one number, one uppercase letter, and one lowercase letter, nad it must be at least 8 characters long
        var exp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,50}$/;
        var test = exp.test(string);
        if (test === false) {
            var title = "Form Error";
            var message = "Please enter a valid password. The password should have at least 1 uppercase letter, 1 lowercase letter, 1 number, and be at least 8 characters long.";
            //calls login service error message method to handle error messages in one location
            loginService.setErrorMessage(title, message);
        }
        return test;
    };
    //phoneRegex method for validating the phone input.
    //takes string as a parameter
    self.phoneRegex = function(string) {
        //regex allows for numbers and dashes must follow a pattern and length
        var exp = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/;
        var test = exp.test(string);
        if (test === false) {
            var title = "Form Error";
            var message = "Please enter a valid phone number. Ex: 555-555-5555";
            //calls login service error message method to handle error messages in one location
            loginService.setErrorMessage(title, message);
        }
        return test;
    };
    //addressRegex method for validating the address input.
    //takes string as a parameter
    self.addressRegex = function(string) {
        //regex allows for up to numbers, letters, periods, pound symbols, hyphens, and spaces
        var exp = /^[A-Za-z0-9'\.\#\-\s\,]*$/;
        var test = exp.test(string);
        if (test === false) {
            var title = "Form Error";
            var message = "Please enter a valid address. Ex: 555 N. Maple Street";
            //calls login service error message method to handle error messages in one location
            loginService.setErrorMessage(title, message);
        }
        return test;
    };
    //zipRegex method for validating the zip input.
    //takes string as a parameter
    self.zipRegex = function(string) {
        //regex allows for up to 5 numbers
        var exp = /^[0-9]{5}$/;
        var test = exp.test(string);
        if (test === false) {
            var title = "Form Error";
            var message = "Please enter a valid zip code. Ex: 98495";
            //calls login service error message method to handle error messages in one location
            loginService.setErrorMessage(title, message);
        }
        return test;
    };
}]);
