<?php

require_once 'Action_Base.php';

class Action_GetVerses extends Action_Base
{
	/** Return verses in JSON format
	 */
	public function process()
	{
		$language = $_REQUEST['language'];
		$book = $_REQUEST['book'];
		$chapter = $_REQUEST['chapter'];
		if (isset($_REQUEST['range']))
		{
			list($start, $end) = explode(',', $_REQUEST['range']);
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

		$book_names = $this->bible->getBookNames($language, $book);
		$chapter_title = $this->bible->getChapterTitle($language, $book, $chapter);
		$verses = $this->bible->getVerses($language, $book, $chapter, $start, $end);

		$result = array(
			'book' =>  $book_names['long_name'],
			'title' => $chapter_title,
			'verses' => $verses
		);

		header('Content-type: application/json');
		print json_encode($result);
	}
}
