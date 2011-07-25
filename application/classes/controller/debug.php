<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Debug extends Controller {
	
	public function action_vars()
	{
		$vlog_data = Request::factory('youtube/playlist/94F99707686679FC')
		                    ->query('results', 3)
		                    ->execute()
		                    ->body();
		
		$vlog = new Model_YouTube_Playlist('94F99707686679FC', $vlog_data);
		//$test = $vlog->playlist_info();
		
		echo Debug::vars($vlog_data, $vlog);
	}
	
	public function action_db()
	{
		$results = DB::select('*')
		             ->from('wp_posts')
		             ->where('post_status', '=', 'publish')
		             ->where('post_type', '=', 'post')
		             ->order_by('post_date', 'DESC')
		             ->execute();
		
		foreach ($results as $post)
		{
			echo Debug::vars($post);
		}
	}
}