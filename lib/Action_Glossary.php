<?php

require_once 'Action_Base.php';

/** Glossary data
 */
class Action_Glossary extends Action_Base
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
		$stroke = $_REQUEST['stroke'];
		$word = $_REQUEST['word'];
		$results = array();

		if (!isset($stroke) && !isset($word))
		{
			// Return index of strokes and letters
			$results = $this->bible->getGlossaryIndex();
		}
		elseif (isset($stroke))
		{
			// Return list of words matching given strokes or letter
			if (is_numeric($stroke))
			{
				$letter = null;
			}
			elseif (is_string($stroke))
			{
				$letter = $stroke;
				$stroke = null;
			}
			else
			{
				echo "ERROR: Invalid stroke\n";
				return;
			}
			$results = $this->bible->getGlossaryStroke($stroke, $letter);
		}
		elseif (isset($word))
		{
			// Return information about a particular word
			$results = $this->bible->getGlossaryWord($word);
		}

		header('Content-type: application/json');
		print json_encode($results);
	}
}
