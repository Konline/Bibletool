<?php

require_once 'Action_Base.php';

/**
 * Search bible verses.
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

	/**
	 * Return verses in JSON format
	 */
	public function process()
	{
		$language = $_REQUEST['language'];
		$book_filter = $this->getBookFilter($_REQUEST['book_filter']);
		$q = $_REQUEST['q'];
		$page = $_REQUEST['page'];

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

		$location = $this->getLocationFromQuery($q);
		if ($location && count($location) == 5)
		{
			// This is a location based query, such as "John 3:16",
			// or "約 3:16".
			$languages_unused = $location[0];
			$book = $location[1];
			$chapter = $location[2];
			$start = $location[3];
			$end = $location[4];
			$verses = $this->bible->getVerses(array($language), $book, $chapter, $start, $end);

			// To minimize changes to the frontend, we "wrap" the result to look 
			// like a search result.
			$verses = array(
				'page' => -1, // no need to paginate.
				'verses' => $verses,
			);
		}
		else
		{
			$verses = $this->bible->search($language, $q, $book_filter, $page, self::VERSES_PER_PAGE);
		}

		header('Content-type: application/json');
		print json_encode($verses);
	}

	/**
	 * Parses a string representing a book range.
	 * The input can be a range, eg. "GEN-REV", or a comma-delimited list of 
	 * books, eg. GEN,EXO,PSA.
	 * @param $book_filter: String (eg. GEN-REV, or GEN,EXO,PSA)
	 * @return Array: list of book indices covering the filter.
	 */
	private function getBookFilter($book_filter)
	{
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
		return $book_filter;
	}

	/**
	 * Extracts any location information from the user query.
	 * For example: "John 3:16" should return the language, book, chapter,
	 * start verse, end verse.
	 * If there's no location information, then return null.
	 * @param $query: String, user query
	 * @returns: Array of (language, book, chapter, start verse, end verse).
	 */
	private function getLocationFromQuery($query)
	{
		// Bible::parseBibleRange() function already provides a similar 
		// functionality.  The only things we need to do are:
		// 1. Convert any book names into 3-letter English acronym.
		// 2. Convert spaces to ":".
		$new_query = str_replace(' ', ':', $this->bible->convertBookNames($query));
		return $this->bible->parseBibleRange($new_query);
	}
}
