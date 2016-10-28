<!DOCTYPE html>
<html lang="en">
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
</head>

<body>



<div ng-app="userApp" ng-controller ="userController">
    
    <button type="button" class="btn btn-default" value="Verduras" ng-repeat="ind in lista"	ng-click="myFunction(ind)"><p class="text-left" > {{ind}}</p></button> 
  <input type="text" ng-model="filtro">
    <table id="searchResults">
    <tr><th>Id</th><th>Produto</th></tr>
    <tr ng-repeat="data in usersData | filter : filtro">
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
        $scope.lista = ["arroz", "feijao", "verdura"];
         $scope.myFunction = function(ind2) {
         $scope.filtro = ind2;
         console.log(data);
    }
    }, function myError(response) {
        $scope.myWelcome = response.statusText;
        console.log(myWelcome);
    });
   
});

</script>

</body>
</html>                            