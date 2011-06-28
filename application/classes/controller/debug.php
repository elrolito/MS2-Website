<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Debug extends Controller {
	
	public function action_vars()
	{
		$api = Request::factory('http://videoadvocate.tumblr.com/api/read')
		              ->execute()
		              ->body();
		
		$data = new SimpleXMLElement($api);
		
		$posts = get_object_vars($data->posts);
		
		echo Debug::vars($api, $posts['@attributes']);
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