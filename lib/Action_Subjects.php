<?php

require_once 'Action_Base.php';

/** Subject data
 */
class Action_Subjects extends Action_Base
{
	public function __construct($bible, $smarty)
	{
		parent::__construct($bible, $smarty);
		// TODO(koyao): Turn cache back on once we find a way to force cache refresh
		$this->cacheable = false;
	}

	/** Return verses in JSON format
	 */
	public function process()
	{
		header('Content-type: application/json');
		print file_get_contents(dirname(__FILE__) . '/../data/subjects.json');
	}
}
