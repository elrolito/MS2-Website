<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Debug extends Controller {
	
	public function action_vars()
	{
		$api = Request::factory('http://api.twitpic.com/2/users/show.json')
		              ->query('username', 'ms2weathergirl')
		              ->execute()
		              ->body();
		              
		$data = json_decode($api);
		
		$image = $data->images[0];
		
		$twitpic = array(
			'id' => $image->short_id,
			'title' => $image->message,
			'timestamp' => $image->timestamp,
			'fuzzy_time' => Date::fuzzy_span(strtotime($image->timestamp))
		);
		               
		echo Debug::vars($image,$twitpic);
	}
}