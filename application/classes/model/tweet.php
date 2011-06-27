<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tweet extends Model {
	
	public $id;
	public $created_at;
	public $timestamp;
	public $text;
	
	public function __construct($data)
	{
		$this->id = $data->id;
		$this->created_at = strtotime($data->created_at);
		$this->timestamp = Date::fuzzy_span($this->created_at);
		
		$text = $data->text;
		
		foreach ($data->entities->hashtags as $hashtag)
		{
			$text = str_replace(
					'#'.$hashtag->text,
					HTML::anchor('http://twitter.com/search?q=%23'.$hashtag->text, '#'.$hashtag->text),
					$text
				);
		}
		
		foreach ($data->entities->urls as $link)
		{
			$text = str_replace(
					$link->url,
					HTML::anchor($link->url, null),
					$text
				);
		}
		
		foreach ($data->entities->user_mentions as $mention)
		{
			$text = str_replace(
					'@'.$mention->screen_name,
					'@'.HTML::anchor('http://twitter.com/'.$mention->screen_name, $mention->screen_name),
					$text
				);
		}
		
		$this->text = $text;
	}
}