/**
 * Created by hskim on 15. 5. 13.
 */
var app = angular.module('boardApp', [
	'ngRoute',
	'BoardController'
]);

app.config(['$routeProvider', function($routeProvider) {
	$routeProvider.
		when('/', {
			controller: 'PostsListCtrl',
			templateUrl: 'app/board/template/list.html'
		}).
		when('/add', {
			controller: 'PostAddCtrl',
			templateUrl: 'app/board/template/input.html'
		}).
		otherwise({
			redirectTo: '/'
		});
}]);