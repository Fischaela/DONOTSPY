/* global $ */

$(document).on('ready', function () {

	'use strict';
	$.post('../index.php/mail/json', $('#form').serialize ());

	$('#form').on('submit', function (event) {

		var $button = $('#is_form-btn'), // the submit button
      request = ''; // the data to be sent via ajax an read by $request by mailserver

		// collect the data from every field
    request = $(this).serialize();
		console.log(request);

		// prevent change of http location because of form action
    event.preventDefault();

		// disable button
		$button.prop('disabled', true).text($button.attr('data-sending'));

		$.ajax({
      type: 'POST',
      data: request,
			url: $(this).attr('action') + '/json',
      // url: 'config.json',
      success: function (data) {
        $('#is_form-success').show().find('.t_message').text(data.message);
        $('#form').hide();
      },
      error: function (data) {
        $('#is_form-error').show().find('.t_message').text(data.message);
        $('#form').hide();
      }
    });

	});

});
