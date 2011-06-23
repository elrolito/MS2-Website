<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Layout extends Controller {
	
	public $view;
	
	protected $_paths = array(
		'stylesheet' => 'media/css/styles.css',
		'main_script' => 'media/js/main.js',
		'projekktor_styles' => 'media/projekktor/theme/style.css',
		'projekktor_script' => 'media/projekktor/projekktor.min.js'
	);
	
	public function before()
	{
		parent::before();
		
		$controller = $this->request->controller();
		
		$view_class = 'View_'.ucfirst($controller);
		
		try
		{
			$this->view = new $view_class;
			
			$this->view->stylesheet = URL::site($this->_paths['stylesheet'], NULL, FALSE);
			$this->view->main_script = URL::site($this->_paths['main_script'], NULL, FALSE);
			$this->view->projekktor_styles = URL::site($this->_paths['projekktor_styles'], NULL, FALSE);
			$this->view->projekktor_script = URL::site($this->_paths['projekktor_script'], NULL, FALSE);
			
			$this->view->partial('header', 'headers/'.$controller.'-header');
		}
		catch (Exception $e)
		{
			$this->view = Debug::vars($e);
		}
	}
	
	public function after()
	{
		$this->response->body($this->view);
		
		parent::after();
	}
}