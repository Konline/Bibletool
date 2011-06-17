<?php

require_once 'Action_Base.php';

/** Search bible verses.
 */
class Action_Search extends Action_Base
{

	public function __construct($bible, $smarty)
	{
		parent::__construct($bible, $smart);
		$this->cacheable = true;
	}

	/** Return verses in JSON format
	 */
	public function process()
	{
		$language = $_REQUEST['language'];
		$book_filter = explode(',', $_REQUEST['book_filter']);
		$q = $_REQUEST['q'];

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

		$verses = $this->bible->search($language, $q, $book_filter);

		header('Content-type: application/json');
		print json_encode($verses);
	}
}
