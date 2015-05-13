/**
 * Created by hskim on 15. 5. 12.
 */
var BoardController = angular.module('BoardController', []);

BoardController.controller('PostsListCtrl', ['$scope', '$http',
	function($scope, $http) {
		$http({
			method:'GET',
			url:'http://localhost:8080/api/board/getList'
		}).success(function(data) {
			$scope.posts = data;
		}).error(function(data) {});

		$scope.orderProp = 'idx';
}]);

BoardController.controller('PostAddCtrl', ['$scope', '$http', '$location', function($scope, $http, $location) {
	$scope.add = function() {
		$http({
			method: 'POST',
			url: 'http://localhost:8080/api/board/addPost',
			data:
				'title='+ $scope.input.title +
				'&name='+ $scope.input.name  +
				'&passwd='+ $scope.input.passwd,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).success(function(data) {
			//alert(data);
			$location.path('/');
		});
	};
}]);