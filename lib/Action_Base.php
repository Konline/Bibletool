<?php

abstract class Action_Base
{
	public function __construct($bible, $smarty)
	{
		$this->bible = $bible;
		$this->smarty = $smarty;
	}

	abstract protected function process();
}
