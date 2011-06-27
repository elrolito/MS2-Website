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
		
		// Get YouTube playlist for ms2ube player
		$playlist_id = $this->view->ms2ube_playlist_id;
		
		$ms2ube_data = Request::factory('youtube/playlist/'.$playlist_id)
		                          ->execute()
		                          ->body();
		                          
		$model = new Model_YouTube_Playlist($playlist_id, $ms2ube_data);
		$this->view->ms2ube_playlist = $model->playlist_info();
		
		$this->view->partial('ms2ube_player', 'partials/ms2ube_player');
		
		// Twitvids (ms2ube mobile)
		$twitvids = Request::factory('twitvid/playlist')
		                               ->execute()
		                               ->body();
		
		$this->view->twitvids = json_decode($twitvids);
		
		// Twitpic
		$twitpic = Request::factory('twitter/twitpic')
		                  ->execute()
		                  ->body();
		                  
		$this->view->twitpic = json_decode($twitpic);
	}
}