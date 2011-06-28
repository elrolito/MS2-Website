<?php defined('SYSPATH') or die('No direct script access.');

class Kohana extends Kohana_Core {
    
    // Change default environment for easier Netfirms hosting
    public static $environment = Kohana::PRODUCTION;
    
    // Array of environment names
    protected static $_environment_names = array('', 'production', 'staging', 'testing', 'development');
    
    // return string environment name instead of integer constant
    public static function environment()
    {
        return self::$_environment_names[self::$environment];
    }
}