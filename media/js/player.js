var playerInstance;

$(document).ready(function() {

	playerInstance = projekktor('#main-player', {
		addplugins: ['Share'],
		controls: true,
		width: 640,
		height: 360,
		playlist: [{ 0 : { src : 'youtube/playlist/' + $('#main-player').attr('data-playlist-id'), type: 'text/json' }}]
	});
	
	playerInstance.addListener('item', updatePlayerItem);
	
	if ($('#playlist').length > 0) {
		updateShareLinks(0);
	}
	
});

updateShareLinks = function(index) {

	var link = $('#playlist li h3 a').eq(index).attr('href');
	var text = 'just watched this youtube video on http://ms2.ca';
	
	var linkEncoded = encodeURIComponent(link);
	var textEncoded = encodeURIComponent(text);
	
	$('#ms2ube-fb-like').replaceWith('<fb:like id="ms2ube-fb-like" href="'+link+'" send="true" layout="button_count" width="200" show_faces="false" font="verdana"></fb:like>');
	$('#ms2ube-tweet').replaceWith('<iframe id="ms2ube-tweet" allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?url=' + linkEncoded + '&via=ms2weathergirl&count=horizontal&text=' + textEncoded + '"style="width:130px; height:50px;"></iframe>');
	
	try {
		FB.XFBML.parse();
	} catch (e) {
	
	}
	
}

updatePlayerItem = function(data) {

	var index = playerInstance.getItemIdx();
	
	updateShareLinks(index);
	
	$('#playlist li:visible').fadeOut(500, function() {
		$('#playlist li').eq(index).delay(200).fadeIn(500);
	});
}