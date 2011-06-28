<?php defined('SYSPATH') or die('No direct script access.');

class View_Blog extends View_Layout {
	
	public $title = 'The Video Advocate';
	
	public $tumblr_posts;
	
	public function posts()
	{
		$posts = array();
		
		foreach ($tumblr_posts as $post)
		{
			$attributes = $post->attributes();
			
			$post[] = array(
				'post_title' => $post->{'regular-title'},
				'post_body' => $post->{'regular-body'}
			);
		}
	}
}