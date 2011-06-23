<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Youtube extends Controller {
	
	public function action_playlist()
	{
		$id = $this->request->param('id', FALSE);
		
		if ($id)
		{
			$playlist = Kohana::cache('playlist_'.$id);
			
			if ( ! $playlist)
			{
				try
				{
					$json = Request::factory('http://gdata.youtube.com/feeds/api/playlists/'.$id.'?v=2&alt=jsonc&orderby=published')
					               ->execute()
					               ->body();
					               
					$feed = json_decode($json);
					
					$playlist = array();
					
					foreach ($feed->data->items as $item)
					{
						$video_src = 'http://www.youtube.com/watch?v='.$item->video->id;
						
						$playlist[] = array(
							0 => array(
								'src' => $video_src, 
								'type' => 'video/youtube',
							),
							'config' => array(
								'title' => $item->video->title,
								'desc' => Text::auto_p($item->video->description)
							)
						);
					}
					
					Kohana::cache('playlist_'.$id, $playlist, 5000);
				}
				catch (Exception $e)
				{
					echo Debug::vars($e);
				}
			}
			
			$this->response->headers('Content-Type', 'application/json');
			$this->response->body(json_encode($playlist));
		}
	}
}