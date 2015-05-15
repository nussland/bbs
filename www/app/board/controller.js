/**
 * Created by hskim on 15. 5. 12.
 */
var BoardController = angular.module('BoardController', []);

BoardController.controller('PostsListCtrl', ['$scope', '$http', '$routeParams', '$location',
	function($scope, $http, $routeParams, $location) {
		var page = $routeParams.page;
		var searchText = $routeParams.searchText;
		var idx = $routeParams.idx;
		var param = '?page='+ page;

		if (searchText && searchText != '') {
			param += '&search=' + searchText;
			$scope.searchText = searchText;
			$scope.viewSearchText = '/search/' + searchText;

		} else {
			$scope.searchText = 'Search';
			$scope.viewSearchText = '';
		}

		$scope.currentPage = page;
		$scope.orderProp = '-idx';

		if (idx && idx != '') {
			$http({
				method:'GET',
				url:'api/board/viewPost/' + idx
			}).success(function(data) {
				$scope.view = data;
				$('#viewHtml').html(data.note);
			});
		}

		$http({
			method:'GET',
			url:'api/board/getList' + param
		}).success(function(data) {
			$scope.posts = data;
		});

		$http({
			method:'GET',
			url:'api/board/getPage' + param
		}).success(function(data) {
			$scope.pageInfo = data;
		});

		$scope.findPost = function(KeyboardEvent) {
			if (KeyboardEvent['keyCode'] == 13) {
				$location.path('/1/search/'+ $scope.search.text);
			}
		};
	}
]);

BoardController.controller('PostAddCtrl', ['$scope', '$http', '$location',
	function($scope, $http, $location) {
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

BoardController.controller('PostModCtrl', ['$scope', '$http', '$routeParams', '$location',
	function($scope, $http, $routeParams, $location) {
		var page = $routeParams.page;
		var searchText = $routeParams.searchText;
		var idx = $routeParams.idx;
		var param = '?page='+ page;

		$http({
			method:'GET',
			url:'api/board/viewPost/' + idx
		}).success(function(data) {
			$scope.input = data;
		});

		$('#inputName').attr('disabled', 'disabled');
	}
]);