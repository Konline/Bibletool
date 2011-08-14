<?php

require_once 'Action_Base.php';

/**
 * Retrieve bible verses.  Supported format:
 * [$languages:]$book:$chapter[:$verses];...
 * 
 * Where:
 * - $languages: optional, comma-separated list of Bible languages (eg. UCV,KJV)
 * - $book: either the English short name (eg. GEN) or the book index (1~66)
 * - $chapter: Integer, chapter number
 * - $verses: A single verse, or a verse range separated by -
 */
class Action_Retrieve extends Action_Base
{
	public function __construct($bible, $smarty)
	{
		parent::__construct($bible, $smarty);
		$this->cacheable = true;
		$this->cache_entity = 'languages';
	}

	/**
	 * Return verses in JSON format
	 */
	public function process()
	{
		$ranges = explode(';', $_REQUEST['ranges']);

		$results = array();

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

			foreach ($languages as $language)
			{
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
		}

		header('Content-type: application/json');
		print json_encode($results);
	}
}
