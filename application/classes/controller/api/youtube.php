<?php defined('SYSPATH') or die('No direct script access.');

class Controller_API_Youtube extends Controller_API_Base {
	
	public function action_playlist()
	{
		$id = $this->request->param('id', FALSE);
		
		if ($id)
		{
			$playlist = Cache::instance()->get('playlist_'.$id);
			
			if ( ! $playlist)
			{
				try
				{
					$playlist = Request::factory('http://gdata.youtube.com/feeds/api/playlists/'.$id)
					               ->query('v', 2)
					               ->query('alt', 'jsonc')
					               ->query('orderby', 'published')
					               ->execute()
					               ->body();
					
					Cache::instance()->set('playlist_'.$id, $playlist, 5000);
				}
				catch (Exception $e)
				{
					echo Debug::vars($e);
				}
			}
			
			if ($this->request->is_ajax())
			{
				$model = new Model_YouTube_Playlist($id, $playlist);
				$body = json_encode($model->projekktor_playlist());
			}
			else
			{
				$body = $playlist;
			}
			
			$this->response->body($body);
		}
	}
}