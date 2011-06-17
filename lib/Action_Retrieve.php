<?php

require_once 'Action_Base.php';

/** Retrieve bible verses.  Supported format:
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
	}

	/** Return verses in JSON format
	 */
	public function process()
	{
		$ranges = explode(';', $_REQUEST['ranges']);

		$results = array();

		foreach ($ranges as $range)
		{
			if (empty($range))
			{
				continue;
			}

			$parts = explode(':', $range);
			$parts_count = count($parts);
			switch ($parts_count)
			{
				case 1:
					// Invalid range, ignore it
					break;

				case 2:
					// $book:$chapter
					list($book, $chapter) = $parts;
					$languages = array('UCV');
					$start = 1;
					$end = 1000;
					break;

				case 3:
					// $language:$book:$chapter, or
					//    UCV:GEN:1
					//    UCV:  1:1
					// $book:$chapter:$verses
					//    GEN:  1:1
					//      1:  1:1
					$valid_languages = array();
					foreach ($this->bible->getLanguages() as $lang)
					{
						$valid_languages[] = $lang['name'];
					}

					$languages = array();
					foreach (explode(',', $parts[0]) as $lang)
					{
						if (in_array($lang, $valid_languages))
						{
							$languages[] = $lang;
						}
					}

					if ($languages)
					{
						$languages = explode(',', $parts[0]);
						$book = $parts[1];
						$chapter = $parts[2];
						$start = 1;
						$end = 1000;
					}
					else
					{
						$languages = array('UCV');
						$book = $parts[0];
						$chapter = $parts[1];
						list($start, $end) = explode('-', $parts[2]);
						if (!isset($end))
							$end = $start;
					}
					break;

				case 4:
					// $language:$book:$chapter:$verses
					$languages = explode(',', $parts[0]);
					$book = $parts[1];
					$chapter = $parts[2];
					list($start, $end) = explode('-', $parts[3]);
					if (!isset($end))
						$end = $start;
					break;

				default:
					// Parse error, just ignore it
					continue;
			}

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
