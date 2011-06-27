<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Debug extends Controller {
	
	public function action_vars()
	{
		$playlist = Request::factory('http://gdata.youtube.com/feeds/api/playlists/AA821F2D7F066FBD')
		               ->query('v', 2)
		               ->query('alt', 'jsonc')
		               ->query('orderby', 'published')
		               ->execute()
		               ->body();
		               
		echo Debug::vars(json_decode($playlist));
	}
}