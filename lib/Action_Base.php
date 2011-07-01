<?php

abstract class Action_Base
{
	public function __construct($bible, $smarty)
	{
		$this->bible = $bible;
		$this->smarty = $smarty;
		$this->cacheable = false;
		$this->cache_entity = '';
		$this->cache_file = '';
	}

	abstract protected function process();

	public function run()
	{
		if ($this->cacheable)
		{
			if ($this->cache_entity)
			{
				$ts = $this->bible->getCacheTimestamp($this->cache_entity);
			}
			elseif ($this->cache_file)
			{
				$ts = filemtime($this->cache_file);
			}
			else
			{
				$ts = null;
			}

			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $ts) . ' GMT');
			header('Cache-Control: max-age=0');

			if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $ts)
			{
				header("HTTP/1.1 304 Not Modified");
				exit;
			}
		}

		$this->process();
	}
}
