app.directive("guestCheckout", function() {
    return {
        restrict: 'E',
        scope: true,
        templateUrl: 'js/directives/views/guestCheckout.html',
        link: function($scope, $element, $attr) {
            angular.element($element).append($scope[$attr.ngModel]);
        }
    };
});

app.directive("signUp", function() {
    return {
        restrict: 'E',
        scope: true,
        templateUrl: 'js/directives/views/signUp.html',
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
        link: function($scope, $element, $attr) {
            angular.element($element).append($scope[$attr.ngModel]);
        }
    };
});
