var app = angular.module('saludNatural', ['ngDialog']);

app.filter('booleanExpression', function () {
  return function (item) {
      if(item == 1){
        return "Sí";
      }
      else{
          return "No";
      }
  };
});



app.controller('MainController', ['$scope', 'ngDialog', function($scope, ngDialog){
    
    $scope.aboutMe = function () {
        ngDialog.open({
            template:'about.html'
        });
    };
    
    $scope.login = function () {
        ngDialog.open({
            template: 'login.html'
        });
    };
    
}]);

app.controller('ProductController', ['$scope','$http', 'ngDialog',  function($scope , $http, ngDialog) {
    
    $http.get("/WebService/v1/lugares").
    success(function(data){
        $scope.locations = data;
    }).
    error(function(data){
        console.log(data);
    });
    
    $http.get("/WebService/v1/productos").
    success(function(data){
        $scope.products = data;
    }).
    error(function(data){
        console.log(data);
    });
    
    $scope.productInformation = function() {
        ngDialog.open({
            template: 'product-information.html',
            scope: $scope
        });
    };
    
    $scope.toSelect = function(index){
        $scope.actualProduct = $scope.products[index];
    };
}]);

app.directive("navbar", function(){
    return{
        restrict: 'E',
        templateUrl: "navbar.html"
    };
});