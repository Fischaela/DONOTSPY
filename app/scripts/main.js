/* global $ */

$(document).on('ready', function () {

	'use strict';
	$.post('../index.php/mail/json', $('#form').serialize ());

	$('#form').on('submit', function (event) {

		var $button = $('#is_form-btn'), // the submit button
      request = {}; // the data to be sent via ajax an read by $request by mailserver

		// collect the data from every field
    request = $(this).serializeArray();

		// prevent change of http location because of form action
    event.preventDefault();

		// disable button
		$button.prop('disabled', true).text($button.attr('data-sending'));

		$.ajax({
      type: 'POST',
      data: JSON.stringify(request),
      dataType: 'json',
      processData: false,
      contentType: 'application/json; charset=UTF-8',
      url: $(this).attr('action'),
      success: function () {
        $('#id_form-success').show();
        $('#form').hide();
      },
      error: function () {
        $('#is_form-error').show();
        $('#form').hide();
      }
    });

	});

});
