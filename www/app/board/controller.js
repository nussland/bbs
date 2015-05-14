/**
 * Created by hskim on 15. 5. 12.
 */
var BoardController = angular.module('BoardController', []);

BoardController.controller('PostsListCtrl', ['$scope', '$http', '$routeParams',
	function($scope, $http, $routeParams) {
		var page = $routeParams.page;

		$scope.currentPage = page;
		$scope.orderProp = '-idx';

		$http({
			method:'GET',
			url:'api/board/getList/'+ page
		}).success(function(data) {
			$scope.posts = data;
		});

		$http({
			method:'GET',
			url:'api/board/getPage/'+ page
		}).success(function(data) {
			$scope.pageInfo = data;
		});
	}
]);

BoardController.controller('PostAddCtrl', ['$scope', '$http', '$location',
	function($scope, $http, $routeParams, $location) {
		$scope.add = function() {
			$http({
				method: 'POST',
				url: 'api/board/addPost',
				data:
					'name='+ $scope.input.name  +
					'&passwd='+ $scope.input.passwd +
					'&title='+ $scope.input.title+
					'&note='+ $('#input-note').val(),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).success(function(data) {
				$location.path('/1');
			});
		};
	}
]);

BoardController.controller('PostViewCtrl', ['$scope', '$http', '$routeParams',
	function($scope, $http, $routeParams) {
		var page = $routeParams.page;
		var idx = $routeParams.idx;

		$scope.currentPage = page;
		$scope.orderProp = '-idx';

		$http({
			method:'GET',
			url:'api/board/viewPost/' + idx
		}).success(function(data) {
			$scope.view = data;
		});

		$http({
			method:'GET',
			url:'api/board/getList/'+ page
		}).success(function(data) {
			$scope.posts = data;
		});
	}
]);