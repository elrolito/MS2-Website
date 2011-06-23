<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Layout {
	
	public function action_index()
	{
		// retrieve twitter profile
		$twitter_user = Request::factory('twitter/user')
		                       ->execute()
		                       ->body();
		                       
		$this->view->set('twitter_profile', json_decode($twitter_user));
		
		// get timeline
		$timeline = Request::factory('twitter/timeline')
		                   ->execute()
		                   ->body();
		                   
		$items = json_decode($timeline);
		
		$tweets = array();
		
		foreach ($items as $item)
		{
			$tweets[] = new Tweet($item);
		}
		
		$this->view->set('tweets', $tweets);
	}
}