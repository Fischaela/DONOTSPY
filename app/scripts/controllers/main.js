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

    var init = function () {
      $scope.formData = {
        name: '',
        mailaddress: '',
        domain: '',
        mailsubject: 'Überwachung meines Internetverkehrs'
      };
      document.getElementById('form').reset();
    };

    init();

    $scope.message = {
      text: '',
      class: ''
    };

    $scope.processForm = function () {

      $scope.formData.emailtext = angular.element(document.querySelector('#emailtext')).text();

      $http({
        method: 'POST',
        url: '/mailserver',
        data: $scope.formData
      })
      .success(function () {
        $scope.message.text = 'E-Mail mit Verifizierungslink wurde erfolgreich versendet.';
        $scope.message.class = 't_message-success';
        init();
      })
      .error(function () {
        $scope.message.text = 'Entschuldigung, ein Fehler ist aufgetreten. Bitte versuchen Sie es noch einmal.';
        $scope.message.class = 't_message-error';
      });
    };

  });
