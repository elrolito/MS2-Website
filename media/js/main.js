$(document).ready(function() {

	// resize content area
	$(window).resize(function() {
		resizeContentArea();
	})
	
	resizeContentArea();
	
	$('a[rel=external]').attr('target', 'external');
	
});

updatePlayerItem = function(data) {

	var index = playerInstance.getItemIdx();
	
	updateShareLinks(index);
	
	$('#playlist li:visible').fadeOut(500, function() {
		$('#playlist li').eq(index).delay(200).fadeIn(500);
	});
}

resizeContentArea = function() {

	var nonContentHeight = $('#top').outerHeight() + $('#page-footer').outerHeight() + $('page-header').outerHeight();
	
	$('#content').css('minHeight', window.innerHeight - nonContentHeight - 175);
	
}