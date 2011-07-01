<?php

require_once 'Action_Base.php';

/** Search bible verses.
 */
class Action_Search extends Action_Base
{
	const VERSES_PER_PAGE = 20;

	public function __construct($bible, $smarty)
	{
		parent::__construct($bible, $smarty);
		$this->cacheable = true;
		$this->cache_entity = 'languages';
	}

	/** Return verses in JSON format
	 */
	public function process()
	{
		$language = $_REQUEST['language'];
		$book_filter = $_REQUEST['book_filter'];
		$q = $_REQUEST['q'];
		$page = $_REQUEST['page'];

		if (strpos($book_filter, '-') !== FALSE)
		{
			list($start, $end) = explode('-', $book_filter);
			if (!is_numeric($start))
			{
				$start = $this->bible->getBookIndex($start);
			}
			if (!is_numeric($end))
			{
				$end = $this->bible->getBookIndex($end);
			}
			$book_filter = range($start, $end);
		}
		else
		{
			$book_filter = explode(',', $book_filter);
		}

		if (!isset($page))
		{
			$page = 1;
		}

		$temp = array();
		foreach ($book_filter as $book)
		{
			if (empty($book))
				continue;

			if (!is_numeric($book))
			{
				$temp[] = $this->bible->getBookIndex($book);
			}
			else
			{
				$temp[] = $book;
			}
		}
		$book_filter = $temp;

		$verses = $this->bible->search($language, $q, $book_filter, $page, self::VERSES_PER_PAGE);

		header('Content-type: application/json');
		print json_encode($verses);
	}
}
