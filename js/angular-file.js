// AngularJS alkalmazás definiálása
let app = angular.module('CowsApp', []);

// Kontroller hozzáadása
app.controller('CowsController', ['$scope', '$http', function($scope, $http) {
    $scope.cows = []; // A tehenek tömbje

    // Adatok betöltése a JSON API-ból
    $http.get('../admin/farm_state_json.php')
        .then(function(response) {
            $scope.cows = response.data;
        }, function(error) {
            console.error('Hiba történt az adatok betöltése közben', error);
        });
}]);
