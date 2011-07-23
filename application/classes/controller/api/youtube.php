<?php defined('SYSPATH') or die('No direct script access.');

class Controller_API_Youtube extends Controller_API_Base {
	
	public function action_playlist()
	{
		$id = $this->request->param('id', FALSE);
		
		$count = (isset($_GET['results'])) ? $_GET['results'] : 10;
		
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
					               ->query('orderby', 'position')
					               ->query('max-results', $count)
					               ->execute()
					               ->body();
					
					Cache::instance()->set('playlist_'.$id, $playlist, 5000);
				}
				catch (Exception $e)
				{
					$playlist = NULL;
				}
			}
			
			if ($this->request->is_ajax())
			{
				try
				{
					$model = new Model_YouTube_Playlist($id, $playlist);
					$body = json_encode($model->projekktor_playlist());
				}
				catch (Exception $e)
				{
					$body = NULL;
				}
			}
			else
			{
				$body = $playlist;
			}
			
			$this->response->body($body);
		}
	}
}