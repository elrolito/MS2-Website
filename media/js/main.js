$(document).ready(function() {

	// resize content area
	$(window).resize(function() {
		resizeContentArea();
	})
	
	resizeContentArea();
	
	$('a[rel=external]').attr('target', 'external');
	
	if ($('#quote-form')) {
		$.getScript('media/js/jquery.validate.min.js', function() {
			$('#quote-form').validate({
				submitHandler: function(form) {
					$('.error').hide();
					form.submit();
				},
				messages: {
					email: {
						required: 'An email is required.',
					},
					name: {
						required: 'Please enter your name.'
					},
					message: {
						required: 'Please add a message.'
					}
				}
			});
		});
		
		$('.message').delay(3000).fadeOut(500);
	}
	
});

resizeContentArea = function() {

	var nonContentHeight = $('#top').outerHeight() + $('#page-footer').outerHeight() + $('page-header').outerHeight();
	
	$('#content').css('minHeight', window.innerHeight - nonContentHeight - 175);
	
}