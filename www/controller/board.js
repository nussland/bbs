/**
 * Created by hskim on 15. 5. 12.
 */
var app = angular.module('boardApp', ['ngRoute']);

app.config(function($routeProvider) {
	$routeProvider.when('/', {
		controller: 'BoardListController as boardList',
		templateUrl: 'view/board/list.html'
	}).otherwise({
		redirectTo: '/'
	});
}).controller('BoardListController', ['$scope', '$http', function($scope, $http) {
	$http({
		method:'GET',
		url:'http://localhost:8080/api/board/getList'
	}).success(function(data, status, headers, config) {
		$scope.posts = data;
	}).error(function(data, status, headers, config) {});
}]);