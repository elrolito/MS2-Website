<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Clients extends Controller_Layout {
	
	public function action_index()
	{
		$playlist_id = $this->view->ms2ube_playlist_id;
		
		$ms2ube_data = Request::factory('youtube/playlist/'.$playlist_id.'?results=20')		                          
		                          ->execute()
		                          ->body();
		                          
		$model = new Model_YouTube_Playlist($playlist_id, $ms2ube_data);
		$this->view->ms2ube_playlist = $model->playlist_info();
		
		$this->view->partial('ms2ube_player', 'partials/ms2ube_player');
	}
}