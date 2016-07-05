app.directive("imageBackground", function(){
  return function(scope, element, attr){
  attr.$observe("value", function(actual_value){
      element.val("value=" + actual_value);
      var url =  attr.value;
      element.css({
        'background': 'linear-gradient(rgba(0,0,0,.15),rgba(0,0,0,.15)), url(' + url + ')',
        'background-size': 'cover',
        'background-repeat': 'no-repeat',
        'background-position': 'center center'
      });
        });
  };
});
