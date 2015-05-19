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
		when('/:page/search/:searchText', {
			controller: 'PostsListCtrl',
			templateUrl: 'app/board/template/list.html'
		}).
		when('/view/:page/post/:idx', {
			controller: 'PostsListCtrl',
			templateUrl: 'app/board/template/list.html'
		}).
		when('/view/:page/post/:idx/search/:searchText', {
			controller: 'PostsListCtrl',
			templateUrl: 'app/board/template/list.html'
		}).
		when('/add/:page', {
			controller: 'PostAddCtrl',
			templateUrl: 'app/board/template/input.html'
		}).
		when('/mod/:page/post/:idx', {
			controller: 'PostModCtrl',
			templateUrl: 'app/board/template/input.html'
		}).
		when('/mod/:page/post/:idx/search/:searchText', {
			controller: 'PostModCtrl',
			templateUrl: 'app/board/template/input.html'
		}).
		when('/del/:page/post/:idx', {
			controller: 'PostDelCtrl',
			templateUrl: 'app/board/template/passwd.html'
		}).
		when('/del/:page/post/:idx/search/:searchText', {
			controller: 'PostDelCtrl',
			templateUrl: 'app/board/template/passwd.html'
		}).
		when('/modComment/:page/post/:boardIdx/comment/:idx', {
			controller: 'CommentModCtrl',
			templateUrl: 'app/board/template/comment.html'
		}).
		when('/modComment/:page/post/:boardIdx/comment/:idx/search/:searchText', {
			controller: 'CommentModCtrl',
			templateUrl: 'app/board/template/comment.html'
		}).
		when('/delComment/:page/post/:boardIdx/comment/:idx', {
			controller: 'CommentDelCtrl',
			templateUrl: 'app/board/template/passwd.html'
		}).
		when('/delComment/:page/post/:boardIdx/comment/:idx/search/:searchText', {
			controller: 'CommentDelCtrl',
			templateUrl: 'app/board/template/passwd.html'
		}).
		otherwise({
			redirectTo: '/1'
		});
}]);