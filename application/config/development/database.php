<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'mysql',
		'connection' => array(

			'hostname'   => 'roloscopedesigns.com',
			'database'   => 'ms2ca_wordpress',
			'username'   => 'ms2ca_wpadmin',
			'password'   => 't0rnad0t0rnad0',
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
);