<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Twitter extends Controller {

	protected $_user_api = 'http://api.twitter.com/1/users/show.json?screen_name=ms2weathergirl';
	protected $_timeline_api = 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=ms2weathergirl&trim_user=1&include_entities=1&count=3';
	
	public function action_user()
	{
		$twitter_user = Kohana::cache('twitter_user');
		
		if ( ! $twitter_user)
		{
			try
			{
				$twitter_user = Request::factory($this->_user_api)
				                       ->execute()
				                       ->body();
				
				Kohana::cache('twitter_user', $twitter_user, 5000);
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
		$timeline = Kohana::cache('timeline');
		
		if ( ! $timeline)
		{
			try
			{
				$timeline = Request::factory($this->_timeline_api)
				                 ->execute()
				                 ->body();
				                 
				Kohana::cache('timeline', $timeline, 1200);
			}
			catch (Exception $e)
			{
				$timeline = NULL;
			}
		}
		
		$this->response->body($timeline);
	}
	
	public function after()
	{
		if ($this->request->is_initial())
		{
			$body = $this->response->body();
		
			$this->response->body(Debug::vars(json_decode($body)));
		}
	}
}