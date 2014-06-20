'use strict';

/**
 * @ngdoc function
 * @name donotspyApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the donotspyApp
 */
angular.module('donotspyApp')
  .controller('MainCtrl', function ($scope, $http) {
    $scope.formData = {
      'mailsubject': 'Überwachung meines Internetverkehrs'
    };
    $scope.processForm = function () {
      $scope.formData.emailtext = angular.element(document.querySelector('#emailtext')).text();
      $http({
        method: 'POST',
        url: '/someUrl',
        data: $scope.formData
      })
      .success(function (data) {
        console.log(data);
      })
      .error(function (data) {
        console.log(data);
      });
    };
  });
