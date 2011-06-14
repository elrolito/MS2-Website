jQuery(document).ready(function($) {
	// resize content area
	$(window).resize(function() {
		resizeContentArea()
	})
	resizeContentArea()
})

resizeContentArea = function() {
	var nonContentHeight = $('#top').outerHeight() + $('#page-footer').outerHeight() + $('page-header').outerHeight() 
	
	$('#content').css('minHeight', window.innerHeight - nonContentHeight - 180)
}