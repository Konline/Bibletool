<?php

/* Model layer to access Bible verses from the database.
 * This layer provides read-only access to the Bible.
 */

require_once 'Config.php';

class Bible
{
	private static $instance;
	private $db;

	private $english_bibles = array('KJV');
	private $chinese_bibles = array('UCV', 'UCV_CN', 'CLV', 'CLV_CN', 'NCV', 'NCV_CN', 'LZZ', 'LZZ_CN');

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
	 * @param $book: Integer or String (eg. 1, OR "GEN")
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
			SELECT l.name AS language, b.short_name AS book, v.chapter AS chapter, v.verse AS verse, v.body AS content
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
			$row = $this->annotateVerse($row, $row['language']);
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

	/** Return book index given the short English name (GEN => 1)
	 * @param $book_name: String
	 * @return Integer (from 1 to 66)
	 */
	public function getBookIndex($book_name)
	{
		$sql = sprintf("
			SELECT b.book
			FROM books b INNER JOIN languages l ON (b.language_id=l.id)
			WHERE l.name='KJV' AND b.short_name='%s'",
			mysql_real_escape_string($book_name));
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		return $row['book'];
	}

	/** Return number of verses in a chapter
	 * @param $language: String
	 * @param $book: Integer
	 * @param $chapter: Integer
	 * @return Integer, number of verses
	 */
	public function getNumVerses($language, $book, $chapter)
	{
		$sql = sprintf("
			SELECT COUNT(*) AS cnt
			FROM verses v INNER JOIN languages l ON (v.language_id=l.id)
			WHERE l.name='%s' AND v.book='%s' AND v.chapter='%s'",
			mysql_real_escape_string($language),
			mysql_real_escape_string($book),
			mysql_real_escape_string($chapter)
		);
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		return $row['cnt'];
	}

	/** Search bible
	 * @param $language: String, language to search against
	 * @param $q: String, query to search
	 * @param $book_filter: (optional) Array of Integer, book ids to limit search on
	 * @param Array of matching verses
	 */
	public function search($language, $q, $book_filter=null)
	{
		if ($q == "")
			return;

		$book_filter_str = '';
		if (!empty($book_filter))
		{
			$book_filter_str = ' AND v.book IN (' . mysql_real_escape_string(implode(',', $book_filter)) . ')';
		}

		$t1 = microtime(true);

		$sql = sprintf("
			SELECT v.book, v.chapter, v.verse, v.body AS content
			FROM verses v
				INNER JOIN books b ON (v.language_id=b.language_id AND v.book=b.book)
		   		INNER JOIN languages l ON (v.language_id=l.id)
			WHERE l.name='%s' AND v.body LIKE '%%%s%%' $book_filter_str",
			mysql_real_escape_string($language),
			mysql_real_escape_string($q)
		);

		$result = mysql_query($sql);
		if (!$result)
		{
			echo "ERROR: Bad query: " . mysql_error();
			return array();
		}

		$verses = array(
			'hits'   => mysql_num_rows($result),
			'time'   => null,
			'verses' => array(),
		);

		while ($row = mysql_fetch_assoc($result))
		{
			$row = $this->annotateVerse($row, $language);
			$verses['verses'][] = $row;
		}

		$verses['time'] = round((microtime(true) - $t1) * 1000, 2);

		mysql_free_result($result);

		return $verses;
	}

	/** Return glossary indices
	 * @return Array(Array with strokes, Array with letters)
	 */
	public function getGlossaryIndex()
	{
		$sql = "SELECT DISTINCT(strokes) FROM glossary ORDER BY strokes";
		$result = mysql_query($sql);

		$strokes = array();
		while ($row = mysql_fetch_assoc($result))
		{
			$strokes[] = $row['strokes'];
		}

		$sql = "SELECT DISTINCT(letter) FROM glossary WHERE letter <> '' ORDER BY letter";
		$result = mysql_query($sql);

		$letters = array();
		while ($row = mysql_fetch_assoc($result))
		{
			$letters[] = $row['letter'];
		}

		return array($strokes, $letters);
	}

	/** Return list of words matching given stroke/letter
	 * @param $stroke: Integer, number of strokes
	 * @param $letter: String, one character English letter
	 * @return Array of words
	 */
	public function getGlossaryStroke($stroke, $letter)
	{
		if (!is_null($letter))
		{
			$sql = sprintf(
				"SELECT chinese, english FROM glossary WHERE letter='%s'",
				mysql_real_escape_string($letter)
			);
		}
		elseif (!is_null($stroke))
		{
			$sql = sprintf(
				"SELECT chinese, english FROM glossary WHERE strokes='%s'",
				mysql_real_escape_string($stroke)
			);
		}
		else
		{
			return;
		}

		$result = mysql_query($sql);

		$words = array();

		while ($row = mysql_fetch_assoc($result))
		{
			$words[] = $row;
		}

		return $words;
	}

	/** Return glossary definition given a Chinese word
	 * @param $word: String
	 * @return array with word definition
	 */
	public function getGlossaryWord($word)
	{
		$results = array();

		$sql = sprintf("SELECT id, strokes, chinese, english, definition FROM glossary WHERE chinese='%s'", mysql_real_escape_string($word));
		$result = mysql_query($sql);
		while ($row = mysql_fetch_assoc($result))
		{
			$id = $row['id'];

			$definition = array(
				'strokes' => $row['strokes'],
				'chinese' => $row['chinese'],
				'english' => $row['english'],
				'definition' => $row['definition'],
				'notes' => array(),
				'verses' => array(),
			);

			$sql = sprintf("SELECT notes FROM glossary_notes WHERE glossary_id='%s'", mysql_real_escape_string($id));
			$result2 = mysql_query($sql);
			while ($row2 = mysql_fetch_assoc($result2))
			{
				$definition['notes'][] = $row2['notes'];
			}

			$sql = sprintf("
				SELECT book, chapter, start_verse, end_verse
				FROM glossary_verses
				WHERE glossary_id='%s'",
				mysql_real_escape_string($id)
			);
			$result3 = mysql_query($sql);
			while ($row3 = mysql_fetch_assoc($result3))
			{
				$definition['verses'][] = array($row3['book'], $row3['chapter'], $row3['start_verse'], $row3['end_verse']);
			}

			$results[] = $definition;
		}

		print_r($results);exit;

		return $results;
	}

	/** Helper function to parse a verse and extract any annotations,
	 * such as red letter, or subtitles in the verse
	 * @param $verse: Array, a verse
	 * @param $language: String, language (eg. 'KJV')
	 * @return Array of a verse with the annotations added
	 */
	private function annotateVerse($verse, $language)
	{
		if (in_array($language, $this->chinese_bibles))
		{
			// Strings enclosed between '【' and '】' are considered subtitles for Chinese bibles.
			if (preg_match('/(【.*】)/', $verse['content'], $match))
			{
				$verse['subtitle'] = $match[1];
				$verse['content'] = str_replace($verse['subtitle'], '', $verse['content']);
			}

			// Strings enclosed betweeen "' " and " '" are God's words
			$patterns = array("/' /", "/ '/");
			$replacements = array("<span class='browse-verse-red' style='color: red;'>", "</span>");
			$verse['content'] = preg_replace($patterns, $replacements, $verse['content']);
		}

		if (in_array($language, $this->english_bibles))
		{
			if (preg_match('/(< .* >)/', $verse['content'], $match))
			{
				$verse['subtitle'] = $match[1];
				$verse['content'] = str_replace($verse['subtitle'], '', $verse['content']);
			}
		}

		return $verse;
	}
};
