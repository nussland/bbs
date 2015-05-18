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
				url:'api/board/view/' + idx
			}).success(function(data) {
				$scope.view = data;
				$('#viewHtml').html(data.note);
			});
			$http({
				method:'GET',
				url:'api/comment/getList/' + idx
			}).success(function(data) {
				$scope.comment = data;
			});

			$scope.addComment = function() {
				$http({
					method: 'POST',
					url: 'api/comment/add',
					data:
					'boardIdx='+ idx  +
					'&name='+ $scope.input.name  +
					'&passwd='+ $scope.input.passwd +
					'&note='+ $scope.input.note ,
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function(data) {
					$location.path('/view/' + page + '/post/' + idx + param);
				});
			};
			$scope.modComment = function() {
				$http({
					method: 'POST',
					url: 'api/comment/modify',
					data:
					'boardIdx='+ idx  +
					'&idx='+ $scope.input.idx  +
					'&passwd='+ $scope.input.passwd +
					'&note='+ $scope.input.note,
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function(data) {
					if (data == 0) {
						alert("Update Success.");
						$location.path('/view/' + page + '/post/' + idx + param);
					} else {
						alert("Update Fail: password do not match");
						$scope.input.passwd = '';
					}
				});
			};
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
		$scope.action = function() {
			$http({
				method: 'POST',
				url: 'api/board/add',
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
		var param = '';

		if (searchText && searchText != '') {
			param += '/search=' + searchText;
		}

		$('#inputName').attr('disabled', 'disabled');

		$http({
			method:'GET',
			url:'api/board/viewPost/' + idx
		}).success(function(data) {
			$scope.input = data;
			$('.note-editor').html(data.note);
			$('#input-note').val(data.note);
		});

		$scope.action = function() {
			$http({
				method: 'POST',
				url: 'api/board/modify',
				data:
				'idx='+ idx  +
				'&passwd='+ $scope.input.passwd +
				'&title='+ $scope.input.title+
				'&note='+ $('#input-note').val(),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).success(function(data) {
				if (data == 0) {
					alert("Update Success.");
					$location.path('/view/' + page + '/post/' + idx + param);
				} else {
					alert("Update Fail: password do not match");
					$scope.input.passwd = '';
				}
			});
		};
	}
]);

BoardController.controller('PostDelCtrl', ['$scope', '$http', '$routeParams', '$location',
	function($scope, $http, $routeParams, $location) {
		var page = $routeParams.page;
		var searchText = $routeParams.searchText;
		var idx = $routeParams.idx;
		var param = '';

		if (searchText && searchText != '') {
			param += '/search=' + searchText;
		}

		$scope.action = function() {
			$http({
				method: 'POST',
				url: 'api/board/delete',
				data:
				'idx='+ idx  +
				'&passwd='+ $scope.input.passwd,
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).success(function(data) {
				if (data == 0) {
					alert("Delete Success.");
					$location.path('/' + page + param);
				} else {
					alert("Delete Fail: password do not match");
					$scope.input.passwd = '';
				}
			});
		};
	}
]);