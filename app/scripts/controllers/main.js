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
    $scope.name = '[Vorname Nachname]';
    $scope.email = '[E-Mail-Adresse]';
    $scope.domain = '[Betroffene Domain]';
  });
