var playerInstance

jQuery(document).ready(function($) {
	// resize content area
	$(window).resize(function() {
		resizeContentArea()
	})
	resizeContentArea()
	
	playerInstance = projekktor('#main-player', {
		addplugins: ['Share'],
		useYTIframeAPI: true,
		controls: true,
		width: 960,
		height: 540,
		playlist: [{ 0 : { src : 'youtube/playlist/AA821F2D7F066FBD', type: 'text/json' }}]
	})
	
	playerInstance.addListener('item', updatePlayerItem)
})

updatePlayerItem = function(data) {
	alert(playerInstance.getItemIdx())
}

resizeContentArea = function() {
	var nonContentHeight = $('#top').outerHeight() + $('#page-footer').outerHeight() + $('page-header').outerHeight() 
	
	$('#content').css('minHeight', window.innerHeight - nonContentHeight - 175)
}