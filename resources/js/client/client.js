var currentBody = null;

var opc = new angular.module('opc', ['angular-loading-bar'])
    .config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeSpinner = false;
    }]);

opc.controller('SplashController', ['$scope', '$http', function($scope, $http) {
    $http.get('api/v1/body').success(function (result) {
        $scope.bodies = result.data;
        $('#splash').delay(250).modal({ 'show': true });
    });

    $scope.selectBody = function(id) {
        $http.get(id + '?include=legislativeTerm,organization').success(function (result) {
            currentBody = result.data;

            $('#main').fadeIn();
            $('#splash').delay(250).modal('hide');
        });
    };
}]);

opc.controller('MainController', ['$scope', '$http', function($scope, $http) {
    //$scope = currentBody;

    $scope.toggleBodyChange = function()
    {
        $('#main').fadeOut();
        $('#splash').modal('show');
    }
}]);