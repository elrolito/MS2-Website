<?php defined('SYSPATH') or die('No direct script access.');

class Controller_API_Twitter extends Controller_API_Base {

	protected $_user_api = 'http://api.twitter.com/1/users/show.json';
	protected $_timeline_api = 'http://api.twitter.com/1/statuses/user_timeline.json';
	
	public function action_user()
	{
		$twitter_user = Cache::instance()->get('twitter_user');
		
		if ( ! $twitter_user)
		{
			try
			{
				$twitter_user = Request::factory($this->_user_api)
				                       ->query('screen_name', 'ms2weathergirl')
				                       ->execute()
				                       ->body();
				
				Cache::instance()->set('twitter_user', $twitter_user, 5000);
			}
			catch (Exception $e)
			{
				$twitter_user = NULL;
			}
		}
		
		$this->response->body($twitter_user);
	}
	
	public function action_timeline()
	{
		$timeline = Cache::instance()->get('timeline');
		
		if ( ! $timeline)
		{
			try
			{
				$timeline = Request::factory($this->_timeline_api)
				                   ->query('screen_name', 'ms2weathergirl')
				                   ->query('trim_user', 1)
				                   ->query('include_entities', 1)
				                   ->query('count', 3)
				                   ->execute()
				                   ->body();
				                 
				Cache::instance()->set('timeline', $timeline, 1200);
			}
			catch (Exception $e)
			{
				$timeline = NULL;
			}
		}
		
		$this->response->body($timeline);
	}
	
	public function action_twitpic()
	{
		$twitpic = Cache::instance()->get('twitpic');
		
		if ( ! $twitpic)
		{
			try
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
				
				Cache::instance()->set('twitpic', $twitpic);
			}
			catch (Exception $e)
			{
				$twitpic = NULL;
			}
		}
		
		$this->response->headers('Content-Type', 'application/json');
		$this->response->body(json_encode($twitpic));
	}
}