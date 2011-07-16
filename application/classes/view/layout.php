<?php defined('SYSPATH') or die('No direct script access.');

class View_Layout extends Kostache_Layout {
	
	public $title;
	
	public $stylesheet;
	
	public $projekktor_styles;
	public $projekktor_script;
	
	public $player_script;
	
	public $main_script;
	
	public function is_production()
	{
		return Kohana::$environment === Kohana::PRODUCTION;
	}	
	
	public function browser()
	{
		$browser = Request::user_agent('browser');
		
		return strtolower(str_replace(' ', '-', $browser));
	}
	
	public function year()
	{
		return date('Y');
	}
	
	public function contact_email()
	{
		return HTML::mailto('info@ms2.ca', NULL, array('title' => 'Contact MS2 Productions'));
	}
	
	protected $_partials = array(
		'nav_link' => 'partials/nav_link'
	);
	
	protected $_nav_links = array(
		array(
			'name' => 'Home',
			'href' => ''
		),
		array(
			'name' => 'About',
			'href' => 'about-ms2'
		),
		array(
			'name' => 'Clients',
			'href' => 'clients'	
		),
		/*array(
			'name' => 'Social Media',
			'href' => 'social-media'
		),
		array(
			'name' => 'Contact',
			'href' => 'contact'
		)*/
	);
	
	public function nav()
	{
		$links = $this->_nav_links;
		
		return $this->_process_links($links);
	}
	
	public function sub_nav()
	{
		$links = $this->_sub_nav_links;
		
		return $this->_process_links($links, TRUE);
	}
	
	protected function _process_links($links, $secondary = FALSE)
	{
		foreach ($links as &$link)
		{			
			if ($params = Request::initial()->route()->matches($link['href']))
			{
				if (($secondary AND isset($params['action']) AND $params['action'] == Request::initial()->action()) OR
				    ( ! $secondary AND $params['controller'] == Request::initial()->controller()))
				{
					$link['selected'] = TRUE;
				}
			}
			
			$link['href'] = URL::site($link['href'], NULL, FALSE);
		}
		
		return $links;
	}
}