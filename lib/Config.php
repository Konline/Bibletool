<?php

class Config
{
	static public $instance = null;

	static public function get_instance()
	{
		if (is_null(Config::$instance))
		{
			Config::$instance = new Config();
		}
		return Config::$instance;
	}

	public function __construct()
	{
		$config = parse_ini_file(__DIR__ . '/../etc/application.conf', true);
		foreach ($config as $section => $data)
		{
			$this->$section = (object) $data;
		}
	}
}
