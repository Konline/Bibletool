<?php

require_once 'Action_Base.php';

/** Controller to return bible verses of one contiguous range,
 *  across multiple languages.
 *  For a list of disjoint verses, please use Action_Retrieve
 */
class Action_GetVerses extends Action_Base
{
	/** Return verses in JSON format
	 */
	public function process()
	{
		$languages = explode(',', $_REQUEST['languages']);

		$book = $_REQUEST['book'];
		if (!is_numeric($book))
		{
			$book = $this->bible->getBookIndex($book);
		}

		$chapter = $_REQUEST['chapter'];
		if (isset($_REQUEST['range']))
		{
			list($start, $end) = explode('-', $_REQUEST['range']);
			if (!isset($end))
			{
				$end = $start;
			}
		}
		else
		{
			$start = 1;
			$end = 1000;
		}

		$result = array();

		$book_names = $this->bible->getBookNames($languages[0], $book);
		$result['book'] = $book_names['long_name'];

		if (count($languages) == 1)
		{
			$chapter_title = $this->bible->getChapterTitle($languages[0], $book, $chapter);
			$result['title'] = $chapter_title;
		}

		$verses = $this->bible->getVerses($languages, $book, $chapter, $start, $end);

		$result['verses'] = $verses;

		header('Content-type: application/json');
		print json_encode($result);
	}
}
