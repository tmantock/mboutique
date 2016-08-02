//files contain the directive html templates for displaying the diffrent views for sign-in, sign-up, and checkout
app.directive("signUp", function() {
    return {
        restrict: 'E',
        scope: true,
        templateUrl: 'js/directives/views/signUp.html',
        //link for allowing ng-model in the csutom directive also allows ng-model to have the scope of the app
        link: function($scope, $element, $attr) {
            angular.element($element).append($scope[$attr.ngModel]);
        }
    };
});

app.directive("signIn", function() {
    return {
        restrict: 'E',
        scope: true,
        templateUrl: 'js/directives/views/signIn.html',
        //link for allowing ng-model in the csutom directive also allows ng-model to have the scope of the app
        link: function($scope, $element, $attr) {
            angular.element($element).append($scope[$attr.ngModel]);
        }
    };
});

app.directive("update", function() {
    return {
        restrict: 'E',
        scope: true,
        templateUrl: 'js/directives/views/update.html',
        //link for allowing ng-model in the csutom directive also allows ng-model to have the scope of the app
        link: function($scope, $element, $attr) {
            angular.element($element).append($scope[$attr.ngModel]);
        }
    };
});

app.directive("checkout", function () {
  return {
    restrict: 'E',
    scope: true,
    templateUrl: 'js/directives/views/confirmCheckout.html',
    //link for allowing ng-model in the csutom directive also allows ng-model to have the scope of the app
    link: function ($scope, $element, $attr) {
      angular.element($element).append($scope[$attr.ngModel]);
    }
  };
});

app.directive("guest", function () {
  return {
    restrict: 'E',
    scope: true,
    templateUrl: 'js/directives/views/guestCheckout.html',
    //link for allowing ng-model in the csutom directive also allows ng-model to have the scope of the app
    link: function ($scope, $element, $attr) {
      angular.element($element).append($scope[$attr.ngModel]);
    }
  };
});
