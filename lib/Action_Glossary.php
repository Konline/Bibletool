<?php

require_once 'Action_Base.php';

/**
 * Glossary data
 */
class Action_Glossary extends Action_Base
{
	public function __construct($bible, $smarty)
	{
		parent::__construct($bible, $smarty);
		$this->cacheable = true;
		$this->cache_entity = 'glossary';
	}

	/**
	 * Return verses in JSON format
	 */
	public function process()
	{
		$stroke = array_key_exists('stroke', $_REQUEST) ? $_REQUEST['stroke'] : null;
		$word = array_key_exists('word', $_REQUEST) ? $_REQUEST['word'] : null;
		$ranges = isset($_REQUEST['ranges']) ? explode(';', $_REQUEST['ranges']) : array();
		$results = array();

		if (!isset($stroke) && !isset($word) && empty($ranges))
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
		elseif (isset($ranges))
		{
			foreach ($ranges as $range)
			{
				$r = $this->bible->parseBibleRange($range);
				if (!$r)
				{
					continue;
				}

				list($languages, $book, $chapter, $start, $end) = $r;
				if (!is_numeric($book))
				{
					$book = $this->bible->getBookIndex($book);
				}
				$results = array_merge($results, $this->bible->getGlossaryByRange($book, $chapter, $start, $end));
			}
		}

		header('Content-type: application/json');
		print json_encode($results);
	}
}
