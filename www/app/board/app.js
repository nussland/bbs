/**
 * Created by hskim on 15. 5. 13.
 */
var app = angular.module('boardApp', [
	'ngRoute',
	'BoardController'
]);

app.config(['$routeProvider', function($routeProvider) {
	$routeProvider.
		when('/:page', {
			controller: 'PostsListCtrl',
			templateUrl: 'app/board/template/list.html'
		}).
		when('/add/:page', {
			controller: 'PostAddCtrl',
			templateUrl: 'app/board/template/input.html'
		}).
		when('/view/:page/post/:idx', {
			controller: 'PostViewCtrl',
			templateUrl: 'app/board/template/list.html'
		}).
		otherwise({
			redirectTo: '/1'
		});
}]);