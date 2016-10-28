<!DOCTYPE html>
<html lang="en">
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
</head>

<body>
<div ng-app="userApp" ng-controller ="userController">
    <table id="searchResults">
    <tr><th>Id</th><th>Produto</th></tr>
    <tr ng-repeat="data in usersData">
    <td>{{data.id}}</td>
    <td>{{data.produto}}</td>
    </tr>
    </table>

</div>
<script>
var app = angular.module('userApp', []);
app.controller('userController', function($scope, $http) {
    $http.get("lista_db_produtos_js.php")
    .then(function(response) {$scope.usersData = response.data.produtos;
    }, function myError(response) {
        $scope.myWelcome = response.statusText;
        console.log(myWelcome);
    });
   
});
</script>

</body>
</html>                            