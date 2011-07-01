<?php

require_once 'Action_Base.php';

/** Subject data
 */
class Action_Subjects extends Action_Base
{
	public function __construct($bible, $smarty)
	{
		parent::__construct($bible, $smarty);
		$this->cacheable = false;
		$this->cache_entity = 'subjects';
	}

	/** Return verses in JSON format
	 */
	public function process()
	{
		header('Content-type: application/json');
		print file_get_contents(dirname(__FILE__) . '/../data/subjects.json');
	}
}
