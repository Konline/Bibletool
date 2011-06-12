<?php

/* Model layer to access Bible verses from the database.
 * This layer provides read-only access to the Bible.
 */

require_once 'Config.php';

class Bible
{
	private static $instance;
	private $db;

	public function getInstance()
	{
		if (!self::$instance)
		{
			$config = new Config();
			self::$instance = new Bible($config);
		}
		return self::$instance;
	}

	private function __construct($config)
	{
		$this->db = mysql_connect($config->database->host, $config->database->user, $config->database->pass);
		mysql_select_db($config->database->dbname);
		mysql_query('SET NAMES utf-8');
	}

	/** Return verses given the range
	 * @param $languages: Array, language name (eg. ["UCV", "KJV"])
	 * @param $book: Integer, book number
	 * @param $chapter: Integer, chapter number
	 * @param $start: Integer, optional starting verse
	 * @param $end: Integer, optional ending verse
	 * @return Array of verses
	 */
	public function getVerses($languages, $book, $chapter, $start=1, $end=1000)
	{
		if (!is_array($languages))
		{
			$languages = array($languages);
		}
		$languages = array_map('mysql_real_escape_string', $languages);
		$languages_str = "'" . implode("','", $languages) . "'";

		$sql = sprintf("
			SELECT b.short_name AS book, v.chapter AS chapter, v.verse AS verse, v.body AS content
			FROM verses v
				INNER JOIN books b ON (v.language_id=b.language_id AND v.book=b.book)
				INNER JOIN languages l ON (v.language_id=l.id)
			WHERE l.name IN (%s) AND b.book = '%s' AND v.chapter = '%s' AND verse >= '%s' AND verse <= '%s'
			ORDER BY v.book, v.chapter, v.verse, v.language_id
				",
			$languages_str,
			mysql_real_escape_string($book),
			mysql_real_escape_string($chapter),
			mysql_real_escape_string($start),
			mysql_real_escape_string($end)
		);

		$result = mysql_query($sql);
		if (!$result)
		{
			echo "ERROR: Bad query: " . mysql_error();
			return array();
		}

		$verses = array();
		while ($row = mysql_fetch_assoc($result))
		{
			$verses[] = $row;
		}
		mysql_free_result($result);

		return $verses;
	}

	/** Return list of Bible languages
	 * @return Array of languages
	 */
	public function getLanguages()
	{
		$sql = sprintf("
			SELECT name, description
			FROM languages");

		$result = mysql_query($sql);

		$languages = array();
		while ($row = mysql_fetch_assoc($result))
		{
			$languages[] = $row;
		}

		return $languages;
	}

	/** Return list of Bible books, given a language
	 * @param $language: String, language name (eg. "KJV")
	 * @return Array of book names
	 */
	public function getBooks($language)
	{
		$sql = sprintf("
			SELECT book, short_name, long_name
			FROM books b INNER JOIN languages l ON (b.language_id=l.id)
			WHERE l.name='%s'
			ORDER BY book ASC", $language);

		$result = mysql_query($sql);

		$books = array();
		while ($row = mysql_fetch_assoc($result))
		{
			$books[] = $row;
		}

		return $books;
	}

	/** Return number of chapters, given a book
	 * @param $book: Integer, book index
	 * @return Integer, number of chapters
	 */
	public function getNumChapters($book)
	{
		$sql = sprintf("
			SELECT COUNT(DISTINCT(chapter)) AS cnt
			FROM verses
			WHERE language_id='1' AND book='%s'", $book);

		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		return $row['cnt'];
	}

	/** Return book name for the requested language
	 * @param $language: String, language name (eg. "KJV")
	 * @param $book: Integer, book id
	 * @return Array, (short_name, long_name)
	 */
	public function getBookNames($language, $book)
	{
		$sql = sprintf("
			SELECT b.short_name, b.long_name
			FROM books b INNER JOIN languages l ON (b.language_id=l.id)
			WHERE l.name='%s' AND b.book='%s'",
			mysql_real_escape_string($language),
			mysql_real_escape_string($book)
		);
		$result = mysql_query($sql);
		return mysql_fetch_assoc($result);
	}

	/** Return chapter title
	 * @param $language: String, language name (eg. "KJV")
	 * @param $book: Integer, book id
	 * @param $chapter: Integer, book id
	 * @return String, chapter title
	 */
	public function getChapterTitle($language, $book, $chapter)
	{
		$sql = sprintf("
			SELECT c.title
			FROM chapters c INNER JOIN languages l ON (c.language_id=l.id)
			WHERE l.name='%s' AND c.book='%s' AND c.chapter='%s'",
			mysql_real_escape_string($language),
			mysql_real_escape_string($book),
			mysql_real_escape_string($chapter)
		);
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		return $row['title'];
	}
};
