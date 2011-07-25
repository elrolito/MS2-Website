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
		
		$tweets = Cache::instance()->get('tweets');
		
		if ( ! $tweets)
		{
			$tweets = array();
			
			try
			{
				foreach ($items as $item)
				{
					$tweets[] = new Model_Tweet($item);
				}
				
				Cache::instance()->set('tweets', $tweets);
			}
			catch (Exception $e)
			{
				$tweets = NULL;
			}
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
		
		// Vlog
		$vlog_data = Request::factory('youtube/playlist/94F99707686679FC')
		                    ->query('results', 3)
		                    ->execute()
		                    ->body();
		
		$vlog = new Model_YouTube_Playlist('94F99707686679FC', $vlog_data);
		$this->view->vlog = $vlog->playlist_info();
		
		$this->view->partial('vlog', 'partials/ms2_vlog');
		
		// Twitpic
		$twitpic = Request::factory('twitter/twitpic')
		                  ->execute()
		                  ->body();
		                  
		$this->view->twitpic = json_decode($twitpic);
	}
}