<?php
/* Initialize Bible database from text files
 */

ini_set('include_path', ini_get('include_path') . ':' . dirname(__FILE__) . '/../lib');

require_once 'Config.php';
require_once 'Bible.php';
require_once 'ParserHelper.php';

$config = Config::getInstance();

// Parse command line options
$long_options = array_keys($LANGUAGES);
$long_options[] = 'subjects';
$long_options[] = 'glossary';
$long_options[] = 'all';
$long_options[] = 'help';

$options = getopt('h', $long_options);

if (empty($options) || isset($options['help']) || isset($options['h']))
{
	Usage();
	exit;
}

$db = GetDatabase($config);

if (isset($options['all']))
{
	LoadSchema();
}

BeginTransaction($db);

LoadLanguages($options);

if (isset($options['glossary']) || isset($options['all']))
{
	$sql = "DELETE FROM glossary";
	mysql_query($sql);

	$glossaries = array('glossary.json', 'person_names.json', 'place_names.json');
	foreach ($glossaries as $file)
	{
		$filename = dirname(__FILE__) . '/../data/' . $file;
		LoadGlossary($filename);
	}
}

if (isset($options['subjects']) || isset($options['all']))
{
	$sql = "DELETE FROM subjects";
	mysql_query($sql);

	LoadSubjects();
}

Commit($db);

echo "Done\n\n";

exit;


/* Auxiliary functions */

function Usage()
{
	echo <<< EOF
InitDb.php: Update database with fresh content
  Available languages:
    --UCV
    --UCV_CN
    --CLV
    --CLV_CN
    --NCV
    --NCV_CN
    --LZZ
    --LZZ_CN
    --KJV

  Other data:
    --subjects
    --glossary

  Other flags:
    --all: Initialize all targets
    --help: This page


EOF;
}

/**
 * Connect to MySQL and return a db handler
 */
function GetDatabase($config)
{
	// Initialize database
	echo "Connecting to database...\n";
	$db = mysql_connect($config->database->host, $config->database->user, $config->database->pass);
	if (!$db)
	{
		echo "Failed to connect to database\n";
		exit(1);
	}
	mysql_select_db($config->database->dbname);
	return $db;
}

/**
 * Initialize database by reloading the schema
 */
function LoadSchema()
{
	echo "Initializing schema...\n";
	$sqls = file_get_contents(dirname(__FILE__) . '/../db/schema.sql');

	foreach (explode(';', $sqls) as $sql)
	{
		$sql = trim($sql);
		if (empty($sql)) continue;

		if (!mysql_query($sql))
		{
			echo "Failed to initialize schema: " . mysql_error() . "\n";
			echo "SQL: $sql\n";
			exit(1);
		}
	}
}

/**
 * Update language data
 * @param $options: Array, list of command line flag options
 */
function LoadLanguages($options)
{
	global $LANGUAGES;
	global $BOOK_NAME_MAPPING;

	$bible = Bible::getInstance();

	$updated = false;

	foreach ($LANGUAGES as $name => $lang)
	{
		if (!isset($options[$name]) && !isset($options['all']))
		{
			continue;
		}

		$updated = true;

		$description = $lang['description'];
		$filename = dirname(__FILE__) . '/../data/' . $lang['filename'];
		$inf = fopen($filename, 'r');
		if (!$inf)
		{
			echo "$filename not found\n";
			exit(1);
		}

		echo "Parsing $filename\n";

		$sql = "DELETE FROM languages WHERE name='$name'";
		mysql_query($sql);

		$sql = "INSERT INTO languages (name, description) VALUES ('$name', '$description')";
		mysql_query($sql);
		$language_id = mysql_insert_id();

		// Used to parse each verse
		$book_no = 0;
		$last_book = null;

		// Used to parse each chapter title
		$last_book_no = 0;
		$last_chapter_no = 0;
		$last_book_name = null;

		// Used to parse book names
		$long_book_name = null;
		$short_book_name = null;

		while (!feof($inf))
		{
			$line = trim(fgets($inf));
			if (preg_match("/(.*) (\d+):(\d+)--(.*)/", $line, $matches))
			{
				$book = trim($matches[1]);
				$chapter = trim($matches[2]);
				$verse = trim($matches[3]);
				$subtitle = '';
				$body = mysql_real_escape_string(trim($matches[4]));

				if ((in_array($name, $bible->chinese_bibles) && preg_match('/(【.*】)/', $body, $match)) ||
					(in_array($name, $bible->english_bibles) && preg_match('/(< .* >)/', $body, $match)))
				{
					$subtitle = $match[1];
					$body = str_replace($subtitle, '', $body);
				}

				if ($book != $last_book)
				{
					$last_book = $book;
					$book_no++;
				}

				if ($chapter == 1 && $verse == 1)
				{
					$upper_book = strtoupper($book);
					if (array_key_exists($upper_book, $BOOK_NAME_MAPPING))
					{
						$short_book_name = $BOOK_NAME_MAPPING[$upper_book];
						$long_book_name = $book;
					}
					else
					{
						$short_book_name = $book;
					}

					$sql = "INSERT INTO books (language_id, book, short_name, long_name) VALUES ('$language_id', '$book_no', '$short_book_name', '$long_book_name')";
					if (!mysql_query($sql))
					{
						echo "ERROR: Failed to insert books: " . mysql_error() . "\n";
						exit(1);
					}
				}

				$sql = "INSERT INTO verses (language_id, book, chapter, verse, subtitle, body) VALUES ('$language_id', '$book_no', '$chapter', '$verse', '$subtitle', '$body')";
				if (!mysql_query($sql))
				{
					echo "ERROR: Failed to insert verses: " . mysql_error() . "\n";
					exit(1);
				}
			}
			elseif (preg_match('/"(.*)","(.*)",\d+,\d+/', $line, $matches))
			{
				$long_book_name = trim($matches[1]);
				$title = mysql_real_escape_string(trim($matches[2]));
				if ($last_book_name == $long_book_name)
				{
					$last_chapter_no++;
				}
				else
				{
					$last_book_name = $long_book_name;
					$last_book_no++;
					$last_chapter_no = 1;
				}

				$sql = "INSERT INTO chapters (language_id, book, chapter, title) VALUES ('$language_id', '$last_book_no', '$last_chapter_no', '$title')";
				if (!mysql_query($sql))
				{
					echo "ERROR: Failed to insert chapters: " . mysql_error() . "\n";
					exit(1);
				}
			}
		}
		fclose($inf);
	}

	if ($updated)
	{
		// Update bible data timestamp
		$sql = "INSERT INTO cache_versions (entity, ts)
			VALUES ('languages', UNIX_TIMESTAMP())
			ON DUPLICATE KEY UPDATE ts = UNIX_TIMESTAMP()";
		mysql_query($sql);
	}
}

function LoadGlossary($filename)
{
	echo "Parsing $filename\n";

	$glossary = json_decode(file_get_contents($filename));

	$bible = Bible::getInstance();

	foreach ($glossary as $strokes => $terms)
	{
		foreach ($terms as $term)
		{
			$chinese = mysql_real_escape_string($term->chinese);
			$english = mysql_real_escape_string($term->english);
			$letter = strtoupper(substr($english, 0, 1));
			$definition = mysql_real_escape_string($term->definition);

			$sql = "INSERT INTO glossary (strokes, letter, chinese, english, definition) VALUES ('$strokes', '$letter', '$chinese', '$english', '$definition')";
			if (!mysql_query($sql))
			{
				echo "ERROR: Failed to insert glossary: " . mysql_error() . "\n";
				exit(1);
			}
			$glossary_id = mysql_insert_id();

			foreach ($term->notes as $note)
			{
				$note = mysql_real_escape_string($note);
				$sql = "INSERT INTO glossary_notes (glossary_id, notes) VALUES ('$glossary_id', '$note')";
				if (!mysql_query($sql))
				{
					echo "ERROR: Failed to insert glossary_verses: " . mysql_error() . "\n";
					exit(1);
				}
			}

			foreach ($term->verses as $verse)
			{
				list($book, $chapter, $start_verse, $end_verse) = ParseVerse($bible, $verse);

				$sql = "INSERT INTO glossary_verses (glossary_id, book, chapter, start_verse, end_verse) VALUES ('$glossary_id', '$book', '$chapter', '$start_verse', '$end_verse')";
				if (!mysql_query($sql))
				{
					echo "ERROR: Failed to insert glossary_verses: " . mysql_error() . "\n";
					exit(1);
				}
			}
		}
	}

	// Update glossary data timestamp
	$sql = "INSERT INTO cache_versions (entity, ts)
		VALUES ('glossary', UNIX_TIMESTAMP())
		ON DUPLICATE KEY UPDATE ts = UNIX_TIMESTAMP()";
	mysql_query($sql);
}

function LoadSubjects()
{
	$file = dirname(__FILE__) . '/../data/subjects.json';
	echo "Parsing $file\n";

	$bible = Bible::getInstance();

	$subjects = json_decode(file_get_contents($file));
	foreach ($subjects as $topic => $object)
	{
		$sql = sprintf("INSERT INTO subjects (name) VALUES ('%s')", mysql_real_escape_string($topic));
		if (!mysql_query($sql))
		{
			echo "Failed to insert subjects: " . mysql_error() . "\n";
			echo "SQL: $sql\n";
			exit(1);
		}
		$parent_id = mysql_insert_id();

		if (is_array($object))
		{
			foreach ($object as $verse)
			{
				list($book, $chapter, $start_verse, $end_verse) = ParseVerse($bible, $verse);
				$sql = sprintf(
					"INSERT INTO subject_verses (subject_id, book, chapter, start_verse, end_verse)
					VALUES ('%s', '%s', '%s', '%s', '%s')",
					$parent_id,
					mysql_real_escape_string($book),
					mysql_real_escape_string($chapter),
					mysql_real_escape_string($start_verse),
					mysql_real_escape_string($end_verse)
				);

				if (!mysql_query($sql))
				{
					echo "Failed to insert subject_verses: " . mysql_error() . "\n";
					echo "SQL: $sql\n";
					exit(1);
				}
			}
		}
		else
		{
			foreach ($object as $subtopic => $verses)
			{
				$sql = sprintf("INSERT INTO subjects (parent_id, name) VALUES ('%s', '%s')",
					$parent_id,
					mysql_real_escape_string($subtopic)
				);
				if (!mysql_query($sql))
				{
					echo "Failed to insert subtopic: " . mysql_error() . "\n";
					echo "SQL: $sql\n";
					exit(1);
				}
				$parent_id2 = mysql_insert_id();

				foreach ($verses as $verse)
				{
					list($book, $chapter, $start_verse, $end_verse) = ParseVerse($bible, $verse);
					$sql = sprintf(
						"INSERT INTO subject_verses (subject_id, book, chapter, start_verse, end_verse)
						VALUES ('%s', '%s', '%s', '%s', '%s')",
						$parent_id2,
						mysql_real_escape_string($book),
						mysql_real_escape_string($chapter),
						mysql_real_escape_string($start_verse),
						mysql_real_escape_string($end_verse)
					);
					if (!mysql_query($sql))
					{
						echo "Failed to insert sub subject_verses: " . mysql_error() . "\n";
						echo "SQL: $sql\n";
						exit(1);
					}

				}
			}
		}
	}

	// Update subjects data timestamp
	$sql = "INSERT INTO cache_versions (entity, ts)
		VALUES ('subjects', UNIX_TIMESTAMP())
		ON DUPLICATE KEY UPDATE ts = UNIX_TIMESTAMP()";
	mysql_query($sql);
}

function ParseVerse($bible, $verse)
{
	list($book, $chapter_verse) = explode(' ', $verse);
	$book = $bible->getBookIndex($book);

	list($chapter, $verses) = explode(':', $chapter_verse);
	
	list($start_verse, $end_verse) = explode('-', $verses);
	if (empty($start_verse))
	{
		// The entire chapter
		$start_verse = 1;
		$end_verse = $bible->getNumVerses('KJV', $book, $chapter);
	}
	elseif (empty($end_verse))
	{
		// A single verse
		$end_verse = $start_verse;
	}

	return array($book, $chapter, $start_verse, $end_verse);
}

function BeginTransaction($db)
{
	$sql = "BEGIN";
	mysql_query($sql);
}

function Commit($db)
{
	$sql = "COMMIT";
	mysql_query($sql);
}
