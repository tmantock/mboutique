app.controller("dateController", ["macaronRetrieve",function(macaronRetrieve, $scope) {
    var self = this;

    self.day = function () {
      var date = new Date();
      var weekday = new Array(7);
      weekday[0] = "Sunday"; weekday[1]="Monday"; weekday[2]="Tuesday"; weekday[3]="Wednesday"; weekday[4]="Thursday"; weekday[5]="Friday"; weekday[6]="Saturday";
      var day = weekday[date.getDay()];
      return day;
    };

    angular.element(document).ready(function () {
      self.date = self.day();
      self.macarons = macaronRetrieve.retrieveMacarons();
    });
}]);
