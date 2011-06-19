<?php

abstract class Action_Base
{
	public function __construct($bible, $smarty)
	{
		$this->bible = $bible;
		$this->smarty = $smarty;
		$this->cacheable = false;
	}

	abstract protected function process();

	public function run()
	{
		if ($this->cacheable)
		{
			header('Cache-Control: max-age=3600, must-revalidate');
			ob_start('ob_gzhandler');
		}

		$this->process();

		if ($this->cacheable)
		{
			header('Content-Length: ' . ob_get_length());
			ob_end_flush();
		}
	}
}
