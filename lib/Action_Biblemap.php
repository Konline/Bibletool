<?php

require_once 'Action_Base.php';

/** Biblemap data
 */
class Action_Biblemap extends Action_Base
{
	public function __construct($bible, $smarty)
	{
		parent::__construct($bible, $smarty);
		$this->cacheable = true;
		$this->cache_file = dirname(__FILE__) . '/../data/openbible_places.json');
	}

	/** Return verses in JSON format
	 */
	public function process()
	{
		header('Content-type: application/json');
		print file_get_contents(dirname(__FILE__) . '/../data/openbible_places.json');
	}
}
