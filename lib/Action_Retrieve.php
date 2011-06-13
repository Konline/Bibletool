<?php

require_once 'Action_Base.php';

/** Controller to return different ranges of bible verses for
 *  the same language.
 *  For interlinear support, please use Action_GetVerses
 */
class Action_Retrieve extends Action_Base
{
	/** Return verses in JSON format
	 */
	public function process()
	{
		$language = $_REQUEST['language'];
		$ranges = explode(',', $_REQUEST['ranges']);
		$results = array();

		foreach ($ranges as $range)
		{
			# range looks like "MAT:24:45-51"
			if (!preg_match('/([^:]+):([^:]+):(.*)/', $range, $match))
			{
				continue;
			}

			$book = $match[1];
			$chapter = $match[2];
			$verse_range = $match[3];
			list($start, $end) = explode('-', $verse_range);

			if (!is_numeric($book))
			{
				$book = $this->bible->getBookIndex($book);
			}

			$book_names = $this->bible->getBookNames($language, $book);
			$chapter_title = $this->bible->getChapterTitle($language, $book, $chapter);
			$verses = $this->bible->getVerses($language, $book, $chapter, $start, $end);

			$result = array(
				'book'   => $book_names['long_name'],
				'title'  => $chapter_title,
				'verses' => $verses,
			);

			$results[] = $result;
		}

		header('Content-type: application/json');
		print json_encode($results);
	}
}
