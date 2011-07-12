<?php defined('SYSPATH') or die('No direct script access.');

class Model_YouTube_Playlist extends Model {
	
	protected $_id;
	protected $_data;
	protected $_playlist_cache_id;
	protected $_info_cache_id;
	
	public function __construct($id, $data)
	{
		$this->_id = $id;
		$this->_data = json_decode($data);
		
		$this->_playlist_cache_id = 'p_playlist_'.$this->_id;
		$this->_info_cache_id = 'playlist_'.$this->_id.'_info';
	}
	
	public function projekktor_playlist()
	{
		// check for cached playlist
		$playlist = Cache::instance()->get($this->_playlist_cache_id);
		
		if ( ! $playlist)
		{
			$playlist = array();
			
			$counter = 1;
			
			foreach ($this->_data->data->items as $item)
			{
				$video_src = 'http://www.youtube.com/watch?v='.$item->video->id;
				
				$playlist[] = array(
					0 => array(
						'src' => $video_src, 
						'type' => 'video/youtube',
					),
					'config' => array(
						'title' => 'Video '.$counter,
						'desc' => Text::auto_p($item->video->description)
					)
				);
				
				$counter++;
			}
			
			Cache::instance()->set($this->_playlist_cache_id, $playlist);
		}
		
		return $playlist;
	}
	
	public function playlist_info()
	{
		// check for cached info
		$info = Cache::instance()->get($this->_info_cache_id);
		
		if ( ! $info)
		{
			$info = array();
		
			foreach ($this->_data->data->items as $item)
			{
				$info[] = array(
					'link' => 'http://youtu.be/'.$item->video->id,
					'title' => $item->video->title,
					'description' => Text::auto_p($item->video->description),
					'timestamp' => Date::fuzzy_span(strtotime($item->video->uploaded))	
				);
			}
			
			Cache::instance()->set($this->_info_cache_id, $info);
		}
		
		return $info;
	}
}