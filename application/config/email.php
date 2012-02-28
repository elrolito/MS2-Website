<?php defined('SYSPATH') OR die('No direct access allowed.');
return array(
	'driver' => 'smtp',
	'options' => array(
		'hostname' => 'securemail.myhosting.com',
		'username' => 'admin@ms2.ca',
		'password' => 't0rnad0',
		'port'     => '587',
		'encryption' => 'ssl'
	)
);