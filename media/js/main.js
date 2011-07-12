$(document).ready(function() {

	// resize content area
	$(window).resize(function() {
		resizeContentArea();
	})
	
	resizeContentArea();
	
	$('a[rel=external]').attr('target', 'external');
	
});

resizeContentArea = function() {

	var nonContentHeight = $('#top').outerHeight() + $('#page-footer').outerHeight() + $('page-header').outerHeight();
	
	$('#content').css('minHeight', window.innerHeight - nonContentHeight - 175);
	
}