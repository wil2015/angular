<!DOCTYPE html>
<html lang="en">
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
</head>

<body>
<div ng-app="userApp" ng-controller ="userController">
    <table id="searchResults">
    <tr><th>Id</th><th>Name</th></tr>
    <tr ng-repeat="data in usersData">
    <td>{{data.id}}</td>
    <td>{{data.name}}</td>
    </tr>
    </table>

</div>
<script>
var app = angular.module('userApp', []);
app.controller('userController', function($scope, $http) {
    $http.get("getusers.txt")
    .success(function(response) {$scope.usersData = response.users;});
});
</script>

</body>
</html>   
