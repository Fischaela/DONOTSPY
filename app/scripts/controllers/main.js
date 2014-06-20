'use strict';

/**
 * @ngdoc function
 * @name donotspyApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the donotspyApp
 */
angular.module('donotspyApp')
  .controller('MainCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
