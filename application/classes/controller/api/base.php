<?php defined('SYSPATH') or die('No direct script access.');

class Controller_API_Base extends Controller {
	
	public function after()
	{
		if (isset($_GET['debug']))
		{
			$body = Debug::vars(json_decode($this->response->body()));
			$this->response->headers('Content-Type', 'text/html');
			$this->response->body($body);
		}
		else
		{
			$this->response->headers('Content-Type', 'application/json');
		}
		
		parent::after();
	}
}