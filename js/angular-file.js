let app = angular.module('CowsApp', []);

app.controller('CowsController', ['$scope', '$http', function($scope, $http) {
    $scope.cows = []; 

    $http.get('../admin/farm_state_json.php')
        .then(function(response) {
            $scope.cows = response.data;
        }, function(error) {
            console.error('Hiba történt az adatok betöltése közben', error);
        });
}]);

