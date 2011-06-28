<?php defined('SYSPATH') or die('No direct script access.');

class View_About extends View_Layout {
	
	public $title = 'Meet the MS2 Team';
	
	public function ms2_team()
	{
		$team = Kohana::config('team');
		
		foreach ($team as &$member)
		{
			$member['photo'] = URL::site('media/images/team/'.$member['short_name'].'.jpg', NULL, FALSE);
			$member['email'] = array('obfuscated_email' => HTML::mailto($member['short_name'].'@ms2.ca', NULL, array('title' => 'send an email to '.ucfirst($member['short_name']))));
		}
		
		return $team;
	}
}