<?php

/**
 * Model layer to access Bible verses from the database.
 * This layer provides read-only access to the Bible.
 */

require_once 'Config.php';

class Bible
{
	private static $instance;
	private $db;

	public $english_bibles = array('KJV');
	public $chinese_bibles = array('UCV', 'UCV_CN', 'CLV', 'CLV_CN', 'NCV', 'NCV_CN', 'LZZ', 'LZZ_CN');

	public static function getInstance()
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
		$this->db = mysqli_connect(
			$config->database->host, $config->database->user,
			$config->database->pass,
			$config->database->dbname,
			$config->database->port);
		mysqli_query($this->db, 'SET NAMES utf8mb4');

	}

	/**
	 * Return verses given the range
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
		$escaped_languages = array();
		foreach ($languages as $language) {
			$escaped_languages[] = mysqli_real_escape_string($this->db, $language);
		}
		$languages_str = "'" . implode("','", $escaped_languages) . "'";

		$sql = sprintf("
			SELECT l.name AS language, b.short_name AS name, v.book AS book, v.chapter AS chapter, v.verse AS verse,
				v.subtitle AS subtitle, v.body AS content
			FROM verses v
				INNER JOIN books b ON (v.language_id=b.language_id AND v.book=b.book)
				INNER JOIN languages l ON (v.language_id=l.id)
			WHERE l.name IN (%s) AND b.book = '%s' AND v.chapter = '%s' AND verse >= '%s' AND verse <= '%s'
			ORDER BY v.book, v.chapter, v.verse, v.language_id
				",
			$languages_str,
			mysqli_real_escape_string($this->db, $book),
			mysqli_real_escape_string($this->db, $chapter),
			mysqli_real_escape_string($this->db, $start),
			mysqli_real_escape_string($this->db, $end)
		);

		$result = mysqli_query($this->db, $sql);
		if (!$result)
		{
			echo "ERROR: Bad query: " . mysqli_error($this->db);
			return array();
		}

		$verses = array();
		while ($row = mysqli_fetch_assoc($result))
		{
			$row = $this->annotateVerse($row, $row['language']);
			$verses[] = $row;
		}
		mysqli_free_result($result);

		return $verses;
	}

	/**
	 * Return list of Bible languages
	 * @return Array of languages
	 */
	public function getLanguages()
	{
		$sql = sprintf("
			SELECT name, description
			FROM languages");

		$result = mysqli_query($this->db, $sql);

		$languages = array();
		while ($row = mysqli_fetch_assoc($result))
		{
			$languages[] = $row;
		}

		return $languages;
	}

	/**
	 * Return list of Bible books, given a language
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

		$result = mysqli_query($this->db, $sql);

		$books = array();
		while ($row = mysqli_fetch_assoc($result))
		{
			$books[] = $row;
		}

		return $books;
	}

	/**
	 * Return number of chapters, given a book
	 * @param $book: Integer, book index
	 * @return Integer, number of chapters
	 */
	public function getNumChapters($book)
	{
		$sql = sprintf("
			SELECT COUNT(DISTINCT(chapter)) AS cnt
			FROM verses
			WHERE language_id='1' AND book='%s'", $book);

		$result = mysqli_query($this->db, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['cnt'];
	}

	/**
	 * Return book name for the requested language
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
			mysqli_real_escape_string($this->db, $language),
			mysqli_real_escape_string($this->db, $book)
		);
		$result = mysqli_query($this->db, $sql);
		return mysqli_fetch_assoc($result);
	}

	/**
	 * Return chapter title
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
			mysqli_real_escape_string($this->db, $language),
			mysqli_real_escape_string($this->db, $book),
			mysqli_real_escape_string($this->db, $chapter)
		);
		$result = mysqli_query($this->db, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['title'];
	}

	/**
	 * Return book index given the short English name (GEN => 1)
	 * @param $book_name: String
	 * @return Integer (from 1 to 66)
	 */
	public function getBookIndex($book_name)
	{
		$sql = sprintf("
			SELECT b.book
			FROM books b INNER JOIN languages l ON (b.language_id=l.id)
			WHERE l.name='KJV' AND b.short_name='%s'",
			mysqli_real_escape_string($this->db, $book_name));
		$result = mysqli_query($this->db, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['book'];
	}

	/**
	 * Return number of verses in a chapter
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
			mysqli_real_escape_string($this->db, $language),
			mysqli_real_escape_string($this->db, $book),
			mysqli_real_escape_string($this->db, $chapter)
		);
		$result = mysqli_query($this->db, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['cnt'];
	}

	/**
	 * Search bible
	 * @param $language: String, language to search against
	 * @param $q: String, query to search
	 * @param $book_filter: (optional) Array of Integer, book ids to limit search on
	 * @param $page: Integer, page number to return
	 * @param $verses_per_page: Integer, number of results to return per page
	 * @return Array of matching verses
	 */
	public function search($language, $q, $book_filter, $page, $verses_per_page)
	{
		if ($q == "")
			return;

		$book_filter_str = '';
		if (!empty($book_filter))
		{
			$book_filter_str = ' AND v.book IN (' . mysqli_real_escape_string($this->db, implode(',', $book_filter)) . ')';
		}

		$or_list = array();
		foreach (explode('OR', $q) as $or_term)
		{
			$and_list = array();
			foreach (explode(' ', $or_term) as $term)
			{
				if (empty($term) || $term == 'AND')
				{
					continue;
				}
				$and_list[] = sprintf("v.body LIKE '%%%s%%'", mysqli_real_escape_string($this->db, $term));
			}
			$and_str = '(' . implode(' AND ', $and_list) . ')';
			$or_list[] = $and_str;
		}
		$q_str = '(' . implode(' OR ', $or_list) . ')';

		$page = mysqli_real_escape_string($this->db, $page);
		$verses_per_page = mysqli_real_escape_string($this->db, $verses_per_page);

		$t1 = microtime(true);

		$sql = sprintf("
			SELECT SQL_CALC_FOUND_ROWS b.short_name AS name, v.book, v.chapter, v.verse, v.subtitle AS subtitle, v.body AS content
			FROM verses v
				INNER JOIN books b ON (v.language_id=b.language_id AND v.book=b.book)
		   		INNER JOIN languages l ON (v.language_id=l.id)
			WHERE l.name='%s'", mysqli_real_escape_string($this->db, $language)
		);
		$sql .= " AND $q_str $book_filter_str";
		$sql .= sprintf(' LIMIT %d, %d', (int)($page-1) * $verses_per_page, $verses_per_page);

		$result = mysqli_query($this->db, $sql);
		if (!$result)
		{
			echo "ERROR: Bad query: " . mysqli_error($this->db);
			return array();
		}

		// Get total number of hits, disregarding the LIMIT clause
		$row = mysqli_fetch_row(mysqli_query($this->db, 'SELECT FOUND_ROWS()'));
		$total = $row[0];

		$verses = array(
			'hits'   => $total,
			'page'   => $page,
			'time'   => null,
			'verses' => array(),
		);

		while ($row = mysqli_fetch_assoc($result))
		{
			$row = $this->annotateVerse($row, $language);
			$verses['verses'][] = $row;
		}

		$verses['time'] = round((microtime(true) - $t1) * 1000, 2);

		mysqli_free_result($result);

		return $verses;
	}

	/**
	 * Return glossary indices
	 * @return Array(Array with strokes, Array with letters)
	 */
	public function getGlossaryIndex()
	{
		$sql = "SELECT DISTINCT(strokes) FROM glossary ORDER BY strokes";
		$result = mysqli_query($this->db, $sql);

		$strokes = array();
		while ($row = mysqli_fetch_assoc($result))
		{
			$strokes[] = $row['strokes'];
		}

		$sql = "SELECT DISTINCT(letter) FROM glossary WHERE letter <> '' ORDER BY letter";
		$result = mysqli_query($this->db, $sql);

		$letters = array();
		while ($row = mysqli_fetch_assoc($result))
		{
			$letters[] = $row['letter'];
		}
		mysqli_free_result($result);

		return array($strokes, $letters);
	}

	/**
	 * Return list of words matching given stroke/letter
	 * @param $stroke: Integer, number of strokes
	 * @param $letter: String, one character English letter
	 * @return Array of words
	 */
	public function getGlossaryStroke($stroke, $letter)
	{
		if (!is_null($letter))
		{
			$sql = sprintf(
				"SELECT chinese, english, kind FROM glossary WHERE letter='%s'",
				mysqli_real_escape_string($this->db, $letter)
			);
		}
		elseif (!is_null($stroke))
		{
			$sql = sprintf(
				"SELECT chinese, english, kind FROM glossary WHERE strokes='%s'",
				mysqli_real_escape_string($this->db, $stroke)
			);
		}
		else
		{
			return;
		}

		$result = mysqli_query($this->db, $sql);

		$words = array();

		while ($row = mysqli_fetch_assoc($result))
		{
			$words[] = $row;
		}
		mysqli_free_result($result);

		return $words;
	}

	/**
	 * Return glossary definition given a Chinese word
	 * @param $word: String
	 * @return array with word definition
	 */
	public function getGlossaryWord($word)
	{
		$results = array();

		$sql = sprintf("SELECT g.id, g.strokes, g.chinese, g.english, g.kind, g.definition, g.openbible_places_id, p.lat, p.lon
			FROM glossary g LEFT JOIN openbible_places p ON (g.openbible_places_id=p.id)
			WHERE chinese='%s'", mysqli_real_escape_string($this->db, $word));
		$result = mysqli_query($this->db, $sql);
		while ($row = mysqli_fetch_assoc($result))
		{
			$id = $row['id'];

			$definition = array(
				'strokes' => $row['strokes'],
				'chinese' => $row['chinese'],
				'english' => $row['english'],
				'kind' => $row['kind'],
				'definition' => $row['definition'],
				'openbible_places_id' => $row['openbible_places_id'],
				'lat' => $row['lat'],
				'lon' => $row['lon'],
				'notes' => array(),
				'verses' => array(),
			);

			$sql = sprintf("SELECT notes FROM glossary_notes WHERE glossary_id='%s'", mysqli_real_escape_string($this->db, $id));
			$result2 = mysqli_query($this->db, $sql);
			while ($row2 = mysqli_fetch_assoc($result2))
			{
				$definition['notes'][] = $row2['notes'];
			}

			$sql = sprintf("
				SELECT book, chapter, start_verse, end_verse
				FROM glossary_verses
				WHERE glossary_id='%s'",
				mysqli_real_escape_string($this->db, $id)
			);
			$result3 = mysqli_query($this->db, $sql);
			while ($row3 = mysqli_fetch_assoc($result3))
			{
				$definition['verses'][] = array($row3['book'], $row3['chapter'], $row3['start_verse'], $row3['end_verse']);
			}

			$results[] = $definition;
		}

		return $results;
	}

	/**
	 * Get glossary match a given bible range
	 * @param $book: Integer, book index
	 * @param $start_verse: Integer, start verse
	 * @param $end_verse: Integer, end verse
	 * @return Array of glossaries
	 */
	public function getGlossaryByRange($book, $chapter, $start_verse, $end_verse)
	{
		$sql = sprintf("
			SELECT g.chinese AS chinese, g.english AS english, g.kind AS kind, v.book, v.chapter, v.start_verse, v.end_verse, p.name AS openbible_place_name
			FROM glossary g
				INNER JOIN glossary_verses v ON (g.id=v.glossary_id)
				LEFT JOIN openbible_places p ON (g.openbible_places_id=p.id)
			WHERE v.book='%s' AND v.chapter='%s' AND v.start_verse >= '%s' AND v.end_verse <= '%s'",
			mysqli_real_escape_string($this->db, $book),
			mysqli_real_escape_string($this->db, $chapter),
			mysqli_real_escape_string($this->db, $start_verse),
			mysqli_real_escape_string($this->db, $end_verse)
		);

		$result = mysqli_query($this->db, $sql);
		if (!$result)
		{
			echo "ERROR: Bad query: " . mysqli_error($this->db);
			return array();
		}

		$glossary = array();
		while ($row = mysqli_fetch_assoc($result))
		{
			$glossary[] = $row;
		}
		mysqli_free_result($result);

		return $glossary;
	}

	/**
	 * Parse the various bible range formats supported by retrieve actions
	 * @param $range: String, bible range
	 * @return Array($languages, $book, $chapter, $start, $end)
	 *         null in case of error
	 */
	public function parseBibleRange($range)
	{
		if (empty($range))
		{
			return;
		}

		$parts = explode(':', $range);
		$parts_count = count($parts);
		switch ($parts_count)
		{
			case 1:
				// Invalid range, ignore it
				return;

			case 2:
				// $book:$chapter:
				//   GEN:1
				//     1:1
				list($book, $chapter) = $parts;
				$languages = array('UCV');
				$start = 1;
				$end = 1000;
				break;

			case 3:
				// $language:$book:$chapter:
				//    UCV:GEN:1
				//    UCV:  1:1
				// or,
				// $book:$chapter:$verses:
				//    GEN:  1:1
				//      1:  1:1
				$valid_languages = array();
				foreach ($this->getLanguages() as $lang)
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
					if (count(explode('-', $parts[2])) == 2)
					{
						list($start, $end) = explode('-', $parts[2]);
					}
					else
					{
						$start = $end = $parts[2];
					}
				}
				break;

			case 4:
				// $language:$book:$chapter:$verses
				$languages = explode(',', $parts[0]);
				$book = $parts[1];
				$chapter = $parts[2];
				if (count(explode('-', $parts[3])) == 2)
				{
					list($start, $end) = explode('-', $parts[3]);
				}
				else
				{
					$start = $end = $parts[3];
				}
				break;

			default:
				// Parse error, just ignore it
				return;
		}

		if (!is_numeric($book))
		{
			$book = $this->getBookIndex($book);
		}

		if (!is_array($languages) ||
			!is_numeric($book) ||
			!is_numeric($chapter) ||
			!is_numeric($start) ||
			!is_numeric($end)) {
			// This must have been a parse error.
			return;
		}

		return array($languages, $book, $chapter, $start, $end);
	}

	/**
	 * Return update timestamp of the entity
	 * @param $entity: String, cache entity
	 * @return Integer, Unix timestamp
	 */
	public function getCacheTimestamp($entity)
	{
		if (empty($entity))
			return 0;

		$sql = sprintf("SELECT ts FROM cache_versions WHERE entity='%s'",
			mysqli_real_escape_string($this->db, $entity));
		$result = mysqli_query($this->db, $sql);
		$row = mysqli_fetch_assoc($result);
		if ($row)
		{
			return $row['ts'];
		}
		return 0;
	}

	/**
	 * Converts any Chinese book name into the 3-letter Bible name.
	 * For example, converts 「約」or 「約翰福音」to JHN.
	 */
	public function convertBookNames($input)
	{
		// Get a list of long name to 3-letter Bible name mapping.
		$sql = "
			SELECT LOWER(b1.long_name) AS search, b2.short_name AS repl
			FROM books b1
			INNER JOIN books b2 ON (b1.book=b2.book)
			INNER JOIN languages l1 ON (b1.language_id=l1.id)
			INNER JOIN languages l2 ON (b2.language_id=l2.id AND l2.name='KJV')
				UNION
			SELECT LOWER(b1.short_name) AS search, b2.short_name AS repl
			FROM books b1
				INNER JOIN books b2 ON (b1.book=b2.book)
				INNER JOIN languages l1 ON (b1.language_id=l1.id AND l1.name<>'KJV')
			INNER JOIN languages l2 ON (b2.language_id=l2.id AND l2.name='KJV')
			ORDER BY LENGTH(search) DESC;
		";

		$result = mysqli_query($this->db, $sql);
		if (!$result)
		{
			return null;
		}

		$input = mb_strtolower($input, 'UTF-8');

		while ($row = mysqli_fetch_assoc($result))
		{
			$search = $row['search'];
			$repl = $row['repl'];
			$input = str_replace($search, $repl, $input);
		}

		return $input;
	}

	/**
	 * Helper function to parse a verse and extract any annotations,
	 * such as red letter, or subtitles in the verse
	 * @param $verse: Array, a verse
	 * @param $language: String, language (eg. 'KJV')
	 * @return Array of a verse with the annotations added
	 */
	private function annotateVerse($verse, $language)
	{
		if (in_array($language, $this->chinese_bibles))
		{
			// Strings enclosed betweeen "' " and " '" are God's words
			$patterns = array("/' /", "/ '/");
			$replacements = array("<span class='browse-verse-red' style='color: red;'>", "</span>");
			$verse['content'] = preg_replace($patterns, $replacements, $verse['content']);
		}
		return $verse;
	}
};
