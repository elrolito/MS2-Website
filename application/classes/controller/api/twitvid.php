<?php defined('SYSPATH') or die('No direct script access.');

class Controller_API_TwitVid extends Controller_API_Base {
	
	public function action_playlist()
	{
		$playlist = Cache::instance()->get('ms2ube_mobile');
		
		if ( ! $playlist)
		{
			try
			{
				$response = Request::factory('http://im.twitvid.com/api/getVideos')
				               ->method('post')
				               ->post('username', 'ms2weathergirl')
				               ->post('page_size', 6)
				               ->post('page', 1)
				               ->post('format', 'json')
				               ->execute()
				               ->body();
				               
				$data = json_decode($response);
				
				if ($data->rsp->stat == 'ok')
				{
					$playlist = array();
					
					foreach ($data->rsp->video as $video)
					{
						$playlist[] = array(
							'title' => $video->message,
							'id' => $video->media_id,
							'link' => $video->media_url
						);
					}
					
					Cache::instance()->set('ms2ube_mobile', $playlist);
				}
			}
			catch (Exception $e)
			{
			
			}
		}
		
		$this->response->body(json_encode($playlist));
	}
}