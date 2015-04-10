var currentBody = null;

var opc = new angular.module('opc', ['angular-loading-bar'])
    .config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeSpinner = false;
    }])
    .config(['$provide', function($provide){
        // http://stackoverflow.com/a/19498009/718752
        $provide.decorator('$rootScope', ['$delegate', function($delegate){

            Object.defineProperty($delegate.constructor.prototype, '$onRootScope', {
                value: function(name, listener){
                    var unsubscribe = $delegate.$on(name, listener);
                    this.$on('$destroy', unsubscribe);

                    return unsubscribe;
                },
                enumerable: false
            });

            return $delegate;
        }]);
    }]);;

opc.controller('SplashController', ['$scope', '$rootScope', '$http', function($scope, $rootScope, $http) {
    $http.get('api/v1/body').success(function (result) {
        $scope.bodies = result.data;
        $('#splash').delay(250).modal({ 'show': true, 'keyboard': false, 'backdrop': 'static' });
    });

    $scope.selectBody = function(id) {
        $http.get(id + '?include=legislativeTerm,organization').success(function (result) {
            currentBody = result.data;
            $rootScope.$emit('BodyUpdate');
        });
    };
}]);

opc.controller('MainController', ['$scope', '$http', function($scope, $http) {
    $scope.toggleBodyChange = function()
    {
        $('#main').fadeOut(250);
        $('#splash').delay(250).modal('show');
    }

    var bodyUpdateEvent = $scope.$onRootScope('BodyUpdate', function() {
        $scope.body = currentBody;

        $('#main').fadeIn(250);
        $('#splash').delay(250).modal('hide');
    });
}]);