<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html>
<script src="http://ajax.googleapis.bootcss.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<body>

<div ng-app="myApp" ng-controller="customersCtrl"> 

<table>
  <tr ng-repeat="x in data">
    <td>{{ x.id }}</td>
   
  </tr>
</table>

</div>

<script>
var app = angular.module('myApp', []);
app.controller('customersCtrl', function($scope, $http) {
    $http.get("lista_db_produtos_js.php")
    .success(function (response) {$scope.data = response.data;});
});
</script>

</body>
</html>
<!DOCTYPE html>
<html>
