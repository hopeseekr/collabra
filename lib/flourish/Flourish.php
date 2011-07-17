<?php

class Flourish
{
	private function __construct() { }

	protected static function autoload($className)
	{
		if (!file_exists(FLOURISH_LIB_PATH . '/' . $className . '.php'))
		{
			throw new RuntimeException('Cannot find file for class "' . $className . '"');
		}

		require FLOURISH_LIB_PATH . '/' . $className . '.php';
	}

	public static function init()
	{
		define('FLOURISH_LIB_PATH', dirname(__FILE__));
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}
}
