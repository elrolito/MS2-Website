<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Debug extends Controller {
	
	public function action_vars()
	{
		$test = Request::factory('http://gdata.youtube.com/feeds/api/playlists/AA821F2D7F066FBD?v=2&alt=jsonc&orderby=published')
		               ->execute()
		               ->body();
		               
		echo Debug::vars($test, json_decode($test));
	}
}