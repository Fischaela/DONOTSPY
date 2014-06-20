'use strict';

/**
 * @ngdoc overview
 * @name donotspyApp
 * @description
 * # donotspyApp
 *
 * Main module of the application.
 */
angular
  .module('donotspyApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/datenschutz', {
        templateUrl: 'views/privacy.html',
        controller: 'MainCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
