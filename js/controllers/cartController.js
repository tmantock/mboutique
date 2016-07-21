//cartController is initialized for managing data within the cart page
app.controller("cartController", ['$scope', 'macaronCart', 'cartCheckout', 'loginService', function($scope, macaronCart, cartCheckout, loginService) {
    //self is declared to keep track of this
    var self = this;
    //retrieve the authentication token from the login service
    $scope.token = loginService.retrieveToken();
    //retrieve the error message and error title from the login service for use in the error modal
    self.errorTitle = loginService.getErrorTitle();
    self.errorMessage = loginService.getErrorMessage();
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
    //retrieve the checkout total form the macaron service
    $scope.total = macaronCart.calculateTotal();
    //retrieve the password error message from the login service on bad attempt
    $scope.passwordMessage = loginService.getPasswordMessage();
    self.checkoutStatus = null;
    $scope.orderNumber = '';
    self.showSignUp = false;
    self.showSignIn = false;
    //Eventhandler for handling a broadcast message that is sent by the macaron service whenever the macaron array has been altered
    $scope.$on('handleBroadcast', function() {
        //update the macaron array, item count, cart total, and checkout array on any pertinent changes
        $scope.macarons = macaronCart.macarons;
        $scope.cart = macaronCart.itemCount;
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
        //checkCheckout method is called to handle a successful or unsuccessfulcheckout atttempt
        self.checkCheckout();
    });
    //array of states
    self.states = [
        {
            name: "Select a State",
            "addreviation": "Select"
        },
        {
            name: "Alabama",
            abbreviation: "AL"
        },
        {
            name: "Alaska",
            abbreviation: "AK"
        },
        {
            name: "American Samoa",
            abbreviation: "AS"
        },
        {
            name: "Arizona",
            abbreviation: "AZ"
        },
        {
            name: "Arkansas",
            abbreviation: "AR"
        },
        {
            name: "California",
            abbreviation: "CA"
        },
        {
            name: "Colorado",
            abbreviation: "CO"
        },
        {
            name: "Connecticut",
            abbreviation: "CT"
        },
        {
            name: "Delaware",
            abbreviation: "DE"
        },
        {
            name: "District of Columbia",
            abbreviation: "DC"
        },
        {
            name: "Federated States of Micronesia",
            abbreviation: "FM"
        },
        {
            name: "Florida",
            abbreviation: "FL"
        },
        {
            name: "Georgia",
            abbreviation: "GA"
        },
        {
            name: "Guam",
            abbreviation: "GU"
        },
        {
            name: "Hawaii",
            abbreviation: "HI"
        },
        {
            name: "Idaho",
            abbreviation: "ID"
        },
        {
            name: "Illinois",
            abbreviation: "IL"
        },
        {
            name: "Indiana",
            abbreviation: "IN"
        },
        {
            name: "Iowa",
            abbreviation: "IA"
        },
        {
            name: "Kansas",
            abbreviation: "KS"
        },
        {
            name: "Kentucky",
            abbreviation: "KY"
        },
        {
            name: "Louisiana",
            abbreviation: "LA"
        },
        {
            name: "Maine",
            abbreviation: "ME"
        },
        {
            name: "Marshall Islands",
            abbreviation: "MH"
        },
        {
            name: "Maryland",
            abbreviation: "MD"
        },
        {
            name: "Massachusetts",
            abbreviation: "MA"
        },
        {
            name: "Michigan",
            abbreviation: "MI"
        },
        {
            name: "Minnesota",
            abbreviation: "MN"
        },
        {
            name: "Mississippi",
            abbreviation: "MS"
        },
        {
            name: "Missouri",
            abbreviation: "MO"
        },
        {
            name: "Montana",
            abbreviation: "MT"
        },
        {
            name: "Nebraska",
            abbreviation: "NE"
        },
        {
            name: "Nevada",
            abbreviation: "NV"
        },
        {
            name: "New Hampshire",
            abbreviation: "NH"
        },
        {
            name: "New Jersey",
            abbreviation: "NJ"
        },
        {
            name: "New Mexico",
            abbreviation: "NM"
        },
        {
            name: "New York",
            abbreviation: "NY"
        },
        {
            name: "North Carolina",
            abbreviation: "NC"
        },
        {
            name: "North Dakota",
            abbreviation: "ND"
        },
        {
            name: "Northern Mariana Islands",
            abbreviation: "MP"
        },
        {
            name: "Ohio",
            abbreviation: "OH"
        },
        {
            name: "Oklahoma",
            abbreviation: "OK"
        },
        {
            name: "Oregon",
            abbreviation: "OR"
        },
        {
            name: "Palau",
            abbreviation: "PW"
        },
        {
            name: "Pennsylvania",
            abbreviation: "PA"
        },
        {
            name: "Puerto Rico",
            abbreviation: "PR"
        },
        {
            name: "Rhode Island",
            abbreviation: "RI"
        },
        {
            name: "South Carolina",
            abbreviation: "SC"
        },
        {
            name: "South Dakota",
            abbreviation: "SD"
        },
        {
            name: "Tennessee",
            abbreviation: "TN"
        },
        {
            name: "Texas",
            abbreviation: "TX"
        },
        {
            name: "Utah",
            abbreviation: "UT"
        },
        {
            name: "Vermont",
            abbreviation: "VT"
        },
        {
            name: "Virgin Islands",
            abbreviation: "VI"
        },
        {
            name: "Virginia",
            abbreviation: "VA"
        },
        {
            name: "Washington",
            abbreviation: "WA"
        },
        {
            name: "West Virginia",
            abbreviation: "WV"
        },
        {
            name: "Wisconsin",
            abbreviation: "WI"
        },
        {
            name: "Wyoming",
            abbreviation: "WY"
        }
    ];
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
            self.showSignUp = false;
            self.showSignIn = false;
            for (var index in self.customer) {
                self.customer[index] = '';
            }
            self.customer.address = 'Select a State'
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
        $scope.cart = 0;
        $scope.total = 0;
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
        cartCheckout.checkout($scope.token, $scope.checkout, $scope.cart, $scope.total);
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
        if (self.validate(false)) {
            loginService.httpLogin(self.customer, true);
        }
    };
    //login method for sendin the new customer to the login service. This method is alos used to handle setting up a new password for teh customer in teh event they forgot their password
    self.newCustomer = function(status) {
        //if the password and password confirmations pass tehn move on
        if (self.customer.password == self.customer.confirm) {
            //if it's a new customer and the validate method returns true then send teh customer to the login service with their status
            if (status === 1 && self.validate(true)) {
                loginService.httpLogin(self.customer, false);
            }
            //if it's an existing customer and the validate method returns true then send teh customer with a status of 'exist'
            else if (status === 0 && self.validate(false)) {
                loginService.httpLogin(self.customer, 'exist');
            }
        }
        //if the passwords do not match then display the error message to the user
        else {
            $scope.modalText = "Error! Please make sure that passwords are matching.";
            $scope.modalTile = "Login Error";
            $("#modal").modal("show");
        }
    };
    //logout method calls the login service's own logout method
    self.logout = function() {
        loginService.logout();
    };
    //validate method for validating the user's inputs. takes in one parameter a boolean to determine which regex methods to use
    self.validate = function(boolean) {
        //for loop for trimming the whitespaces/spaces of an inpput
        for (var index in self.customer) {
            self.customer[index].trim();
        }
        //if they are a new customer then call these regex methods, if they all return true then the validate method returns true
        if (boolean === true) {
            if (self.nameRegex(self.customer.name, true) && self.nameRegex(self.customer.city, false) && self.emailRegex(self.customer.email) && self.passwordRegex(self.customer.password) && self.phoneRegex(self.customer.phone) && self.zipRegex(self.customer.zip) && self.addressRegex(self.customer.address)) {
                return true;
            }
        }
        //if they are an existing customer then call on the regex methods for email and password only if they return true then the validate method returns true
        else if (boolean === false) {
            if (self.emailRegex(self.customer.email) && self.passwordRegex(self.customer.password)) {
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
