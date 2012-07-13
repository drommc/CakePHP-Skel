/*
App wide JS code
Author: Occitech
*/
;$(function() {
	$('.message')
		.prepend('<i class="icon-remove close" data-dismiss="alert"></i>')
		.alert();

	$('td.actions a[rel=tooltip]').tooltip({ placement: 'bottom' });
});