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
	}

	/* Return verses given the range
	 * @param $language: String, language name (eg. "UCV" or "KJV")
	 * @param $book: Integer, book number
	 * @param $chapter: Integer, chapter number
	 * @param $start: Integer, starting verse
	 * @param $end: Integer, optional ending verse
	 * @return Array of verses
	 */
	public function getVerses($language, $book, $chapter, $start, $end=1000)
	{
		$sql = sprintf("
			SELECT b.short_name AS book, v.chapter AS chapter, v.verse AS verse, v.body AS body
			FROM verses v
				INNER JOIN books b ON (v.language_id=b.language_id AND v.book=b.book)
				INNER JOIN languages l ON (v.language_id=l.id)
			WHERE l.name = '%s' AND b.book = '%s' AND v.chapter = '%s' AND verse >= '%s' AND verse <= '%s'
			ORDER BY v.id ASC
				",
			mysql_real_escape_string($language),
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
			$key = sprintf('%s %s:%s', $row['book'], $row['chapter'], $row['verse']);
			$verses[$key] = $row;
		}
		mysql_free_result($result);

		return $verses;
	}
};
