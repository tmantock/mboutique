//factory for making login or new customer requests. This controllers stores all login data and handles error messages regarding logins
app.factory("loginService", ["$http", "$log", "$rootScope", '$q', function($http, $log, $rootScope, $q) {
    //login object is declared to be returned
    var login = {};

    login.token = null;

    login.errorTitle = null;

    login.errorMessage = null;

    login.name = '';

    login.status = null;

    login.count = 0;

    login.passwordMessage = '';
    //getPasswordMessage method for returning the password message
    login.getPasswordMessage = function() {
        return login.passwordMessage;
    };
    //retrieveToken method for returning the token retrieved from the server call
    login.retrieveToken = function() {
        return login.token;
    };
    //getStatus method for returning the login status
    login.getStatus = function() {
        return login.status;
    };
    //getErrorTitle method for returning the error title
    login.getErrorTitle = function() {
        return login.errorTitle;
    };
    //getErrorMessage method for returning the error message
    login.getErrorMessage = function() {
        return login.errorMessage;
    };
    //getName method for returning the customer's name
    login.getName = function() {
        return login.name;
    };
    //setErrorMessage method takes in two parameters a title and a message. The login status and error messages are set here by setting thos variables equal to the title and message parameters
    login.setErrorMessage = function(title, message) {
        login.errorTitle = title;
        login.errorMessage = message;
        login.status = false;
        //brodcast method is called to send the message to the cartController
        login.broadcastCredentials();
    };
    //logout method for loging the user out. Sets all properties of the login object to their default values (logged out)
    login.logout = function() {
        login.status = null;
        login.token = null;
        login.name = null;
        login.errorTitle = null;
        login.errorMessage = null;
        login.passwordMessage = '';
        login.count = 0;
        //brodcast method is called to send the message to the cartController
        login.broadcastCredentials();
    };
    //broadcastCredentials method for sending a messgae to any controller that has a handler for the message
    login.broadcastCredentials = function() {
        $rootScope.$broadcast('loginBroadcast');
    };
    //httpLogin method for making an http post request to the server for logging a customer in or creating a new user. Takes teh customer object and customer status as parameters
    login.httpLogin = function(customer, boolean) {
        //defer the login
        var deferred = $q.defer();
        return $http({
            url: './php/api-call.php',
            method: 'POST',
            data: {
                password: customer.password,
                name: customer.name,
                email: customer.email,
                phone: customer.phone,
                address: customer.address,
                city: customer.city,
                state: customer.state,
                zip: customer.zip,
                status: boolean
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function successCallack(data) {
            var result = data.data;
            login.status = result.success;
            //if attempt was successful
            if (result.success === true) {
                login.passwordMessage = '';
                login.count = 0;
                login.token = result.token;
                login.name = result.name;
                $log.log("User Data Retrieved");
            }
            //if server returned an unsuccessful message
            else if (result.success === false) {
                login.errorMessage = result.error.message;
                //if the reason was the password was wrong
                if (result.error.password === false) {
                    login.status = null;
                    login.passwordMessage = "Password is incorrect.";
                    login.count++;
                    //if the user entered the wrong password 3 or more times
                    if (login.count >= 3) {
                        $("#password-modal").modal("show");
                    }
                }
                console.log("Error on login");
            }
            //broadcast the login credentials and status regardless of the result
            login.broadcastCredentials();
            //return the deferred results
            return deferred.resolve(result.success);
        }, function errorCallback(err) {
            console.error(err);
        });
    };
    return login;
}]);
