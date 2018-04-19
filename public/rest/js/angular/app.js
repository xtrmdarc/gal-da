var app = angular.module('appRestpe', [
  'ngRoute'
]);

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/inicio', {
        templateUrl: 'inicio.php'
      }).
      when('/crudcliente', {
        templateUrl: 'view/cliente/tm_cliente_e.php'
      }).
      otherwise({
        redirectTo: '/inicio'
      });
  }]);