<?php
/**
 * Initialize Bible database from text files
 */

ini_set('include_path', ini_get('include_path') . ':' . dirname(__FILE__) . '/../lib');
ini_set('max_execution_time', 0);

require_once 'Config.php';
require_once 'Bible.php';
require_once 'ParserHelper.php';

$config = Config::getInstance();

// Parse command line options
$long_options = array_keys($LANGUAGES);
$long_options[] = 'subjects';
$long_options[] = 'glossary';
$long_options[] = 'openbible_places';
$long_options[] = 'openbible_cross_reference';
$long_options[] = 'all';
$long_options[] = 'help';

$options = MyGetOpt('h', $long_options);

if (empty($options) || isset($options['help']) || isset($options['h']))
{
	Usage();
	exit;
}

$db = GetDatabase($config);

if (isset($options['all']))
{
	LoadSchema($db);
}

BeginTransaction($db);
LoadLanguages($db, $options);
Commit($db);

BeginTransaction($db);

if (isset($options['glossary']) || isset($options['all']))
{
	$sql = "DELETE FROM glossary";
	mysqli_query($db, $sql);

	$glossaries = array(
		'glossary.json' => 'other',
		'person_names.json' => 'person',
		'place_names.json' => 'place'
	);
	foreach ($glossaries as $file => $kind)
	{
		$filename = dirname(__FILE__) . '/../data/' . $file;
		LoadGlossary($db, $filename, $kind);
	}
}

if (isset($options['openbible_places']) || isset($options['all']))
{
	$sql = "DELETE FROM openbible_places";
	mysqli_query($db, $sql);
	$filename = dirname(__FILE__) . '/../data/openbible_places.json';
	LoadOpenBiblePlaces($db, $filename);
}

if (isset($options['openbible_cross_reference']) || isset($options['all']))
{
	$sql = "DELETE FROM openbible_cross_reference";
	mysqli_query($db, $sql);
	$filename = dirname(__FILE__) . '/../data/cross_reference.txt';
	LoadOpenBibleCrossReference($db, $filename);
}

if (isset($options['subjects']) || isset($options['all']))
{
	$sql = "DELETE FROM subjects";
	mysqli_query($db, $sql);

	LoadSubjects($db);
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
    --openbible_places
    --openbible_cross_reference

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
	$db = mysqli_connect(
		$config->database->host, $config->database->user,
		$config->database->pass, $config->database->dbname,
		$config->database->port);
	if (!$db)
	{
		echo "Failed to connect to database: " . mysqli_connect_errno() . "\n";
		exit(1);
	}
	mysqli_query($db, "SET NAMES utf8mb4");
	return $db;
}

/**
 * Initialize database by reloading the schema
 */
function LoadSchema($db)
{
	echo "Initializing schema...\n";
	$sqls = file_get_contents(dirname(__FILE__) . '/../db/schema.sql');

	foreach (explode(';', $sqls) as $sql)
	{
		$sql = trim($sql);
		if (empty($sql)) continue;

		if (!mysqli_query($db, $sql))
		{
			echo "Failed to initialize schema: " . mysqli_error($db) . ". SQL: $sql\n";
			exit(1);
		}
	}
}

/**
 * Update language data
 * @param $options: Array, list of command line flag options
 */
function LoadLanguages($db, $options)
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
		mysqli_query($db, $sql);

		$sql = "INSERT INTO languages (name, description) VALUES ('$name', '$description')";
		mysqli_query($db, $sql);
		$language_id = mysqli_insert_id($db);

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
				$body = mysqli_real_escape_string($db, trim($matches[4]));

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
					if (!mysqli_query($db, $sql))
					{
						echo "ERROR: Failed to insert books: " . mysqli_error($db) . "\n";
						exit(1);
					}
				}

				$sql = "INSERT INTO verses (language_id, book, chapter, verse, subtitle, body) VALUES ('$language_id', '$book_no', '$chapter', '$verse', '$subtitle', '$body')";
				if (!mysqli_query($db, $sql))
				{
					echo "ERROR: Failed to insert verses: " . mysqli_error($db) . ". SQL: $sql\n";
					exit(1);
				}
			}
			elseif (preg_match('/"(.*)","(.*)",\d+,\d+/', $line, $matches))
			{
				$long_book_name = trim($matches[1]);
				$title = mysqli_real_escape_string($db, trim($matches[2]));
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
				if (!mysqli_query($db, $sql))
				{
					echo "ERROR: Failed to insert chapters: " . mysqli_error($db) . "\n";
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
		mysqli_query($db, $sql);
	}
}

function LoadGlossary($db, $filename, $kind)
{
	echo "Parsing $filename\n";

	$glossary = json_decode(file_get_contents($filename));

	$bible = Bible::getInstance();

	foreach ($glossary as $strokes => $terms)
	{
		foreach ($terms as $term)
		{
			$chinese = mysqli_real_escape_string($db, isset($term->chinese) ? $term->chinese : "");
			$english = mysqli_real_escape_string($db, isset($term->english) ? $term->english : "");
			$letter = strtoupper(substr($english, 0, 1));
			$definition = mysqli_real_escape_string($db, isset($term->definition) ? $term->definition : "");

			$sql = "INSERT INTO glossary (strokes, letter, chinese, english, kind, definition) VALUES ('$strokes', '$letter', '$chinese', '$english', '$kind', '$definition')";
			if (!mysqli_query($db, $sql))
			{
				echo "ERROR: Failed to insert glossary: " . mysqli_error($db) . ". SQL: $sql\n";
				exit(1);
			}
			$glossary_id = mysqli_insert_id($db);

			foreach ($term->notes as $note)
			{
				$note = mysqli_real_escape_string($db, $note);
				$sql = "INSERT INTO glossary_notes (glossary_id, notes) VALUES ('$glossary_id', '$note')";
				if (!mysqli_query($db, $sql))
				{
					echo "ERROR: Failed to insert glossary_notes: " . mysqli_error($db) . ". SQL: $sql\n";
					exit(1);
				}
			}

			foreach ($term->verses as $verse)
			{
				list($book, $chapter, $start_verse, $end_verse) = ParseVerse($bible, $verse);

				$sql = "INSERT INTO glossary_verses (glossary_id, book, chapter, start_verse, end_verse) VALUES ('$glossary_id', '$book', '$chapter', '$start_verse', '$end_verse')";
				if (!mysqli_query($db, $sql))
				{
					echo "ERROR: Failed to insert '$verse' into glossary_verses: " . mysqli_error($db) . ". SQL: $sql\n";
					exit(1);
				}
			}
		}
	}

	// Update glossary data timestamp
	$sql = "INSERT INTO cache_versions (entity, ts)
		VALUES ('glossary', UNIX_TIMESTAMP())
		ON DUPLICATE KEY UPDATE ts = UNIX_TIMESTAMP()";
	mysqli_query($db, $sql);
}

function LoadSubjects($db)
{
	$file = dirname(__FILE__) . '/../data/subjects.json';
	echo "Parsing $file\n";

	$bible = Bible::getInstance();

	$subjects = json_decode(file_get_contents($file));
	foreach ($subjects as $topic => $object)
	{
		$sql = sprintf("INSERT INTO subjects (name) VALUES ('%s')", mysqli_real_escape_string($db, $topic));
		if (!mysqli_query($db, $sql))
		{
			echo "Failed to insert subjects: " . mysqli_error($db) . ". SQL: $sql\n";
			exit(1);
		}
		$parent_id = mysqli_insert_id($db);

		if (is_array($object))
		{
			foreach ($object as $verse)
			{
				list($book, $chapter, $start_verse, $end_verse) = ParseVerse($bible, $verse);
				$sql = sprintf(
					"INSERT INTO subject_verses (subject_id, book, chapter, start_verse, end_verse)
					VALUES ('%s', '%s', '%s', '%s', '%s')",
					$parent_id,
					mysqli_real_escape_string($db, $book),
					mysqli_real_escape_string($db, $chapter),
					mysqli_real_escape_string($db, $start_verse),
					mysqli_real_escape_string($db, $end_verse)
				);

				if (!mysqli_query($db, $sql))
				{
					echo "Failed to insert '$verse' into subject_verses: " . mysqli_error($db) . ". SQL: $sql\n";
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
					mysqli_real_escape_string($db, $subtopic)
				);
				if (!mysqli_query($db, $sql))
				{
					echo "Failed to insert subtopic: " . mysqli_error($db) . ". SQL: $sql\n";
					exit(1);
				}
				$parent_id2 = mysqli_insert_id($db);

				foreach ($verses as $verse)
				{
					list($book, $chapter, $start_verse, $end_verse) = ParseVerse($bible, $verse);
					$sql = sprintf(
						"INSERT INTO subject_verses (subject_id, book, chapter, start_verse, end_verse)
						VALUES ('%s', '%s', '%s', '%s', '%s')",
						$parent_id2,
						mysqli_real_escape_string($db, $book),
						mysqli_real_escape_string($db, $chapter),
						mysqli_real_escape_string($db, $start_verse),
						mysqli_real_escape_string($db, $end_verse)
					);
					if (!mysqli_query($db, $sql))
					{
						echo "Failed to insert '$verse' sub into subject_verses: " . mysqli_error($db) . ". SQL: $sql\n";
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
	mysqli_query($db, $sql);
}

function ParseVerse($bible, $verse)
{
	list($book_name, $chapter_verse) = explode(' ', $verse);
	$book = $bible->getBookIndex($book_name);

	$chapter_verse_parts = explode(':', $chapter_verse);
	
	if (count($chapter_verse_parts) == 1)
	{
		// The entire chapter
		$chapter = $chapter_verse;
		$start_verse = 1;
		$end_verse = $bible->getNumVerses('KJV', $book, $chapter);
	}
	else
	{
		$chapter = $chapter_verse_parts[0];
		$verses = $chapter_verse_parts[1];
		$verses_parts = explode('-', $verses);
		if (count($verses_parts) == 1)
		{
			// A single verse
			$start_verse = $end_verse = $verses_parts[0];
		}
	   	else {
			$start_verse = $verses_parts[0];
			$end_verse = $verses_parts[1];
		}
	}

	return array($book, $chapter, $start_verse, $end_verse);
}

function LoadOpenBiblePlaces($db, $filename)
{
	echo "Parsing $filename\n";

	$glossary = json_decode(file_get_contents($filename));

	$bible = Bible::getInstance();

	foreach ($glossary as $name => $data)
	{
		$english = mysqli_real_escape_string($db, $data->english_name);
		$chinese = mysqli_real_escape_string($db, $data->chinese_name);
		$lat = mysqli_real_escape_string($db, $data->lat);
		$lon = mysqli_real_escape_string($db, $data->lon);
		$notes = mysqli_real_escape_string($db, $data->notes);

		$sql = "INSERT INTO openbible_places (name, lat, lon, notes) VALUES ('$name', '$lat', '$lon', '$notes')";
		if (!mysqli_query($db, $sql))
		{
			echo "Failed to insert into openbible_places: " . mysqli_error($db) . ". SQL: $sql\n";
			exit(1);
		}
		$openbible_places_id = mysqli_insert_id($db);

		$glossary_id = null;

		// Try to find a matching entry in glossary using Chinese first.
		$sql = "SELECT id FROM glossary WHERE kind='place' AND chinese='$chinese'";
		$result = mysqli_query($db, $sql);
		$rows = mysqli_num_rows($result);
		if ($rows == 1)
		{
			// Found a unique match, link the glossary item with this openbible place item
			$row = mysqli_fetch_assoc($result);
			$glossary_id = $row['id'];
		}
		else
		{
			// Try with English
			$sql = "SELECT id FROM glossary WHERE kind='place' AND english='$english'";
			$result = mysqli_query($db, $sql);
			$rows = mysqli_num_rows($result);
			if ($rows == 1)
			{
				$row = mysqli_fetch_assoc($result);
				$glossary_id = $row['id'];
			}
		}

		if ($glossary_id)
		{
			$sql = "UPDATE glossary SET openbible_places_id=$openbible_places_id WHERE id=$glossary_id";
			mysqli_query($db, $sql);
		}
	}
}

function LoadOpenBibleCrossReference($db, $filename)
{
	echo "Parsing $filename\n";

	$bible = Bible::getInstance();

	// First pass, get to know the book acronyms
	$inf = fopen($filename, "r");

	// Discard first line of header
	$line = fgets($inf);

	$last_book = null;
	$index = 1;
	$book_mapping = array();

	while ($line = fgets($inf))
	{
		$parts = explode(".", $line);
		$book = $parts[0];
		if (is_null($last_book) || $last_book != $book)
		{
			$book_mapping[$book] = $index++;
		}
		$last_book = $book;
	}

	// Second pass, parse the data
	rewind($inf);

	// Discard first line of header
	$line = fgets($inf);
	
	while ($line = fgets($inf))
	{
		list($source, $references, $votes) = explode("\t", $line);
		list($book, $chapter, $verse) = explode(".", $source);
		if (strpos($references, "-") === FALSE)
		{
			// Only one verse
			list($ref_book, $ref_chapter, $ref_start_verse) = explode(".", $references);
			$ref_end_verse = $ref_start_verse;
		}
		else
		{
			// Verse range
			$references = explode("-", $references);
			list($ref_book, $ref_chapter, $ref_start_verse) = explode(".", $references[0]);
			list($ref_book, $ref_chapter, $ref_end_verse) = explode(".", $references[1]);
		}

		$book = $book_mapping[$book];
		$ref_book = $book_mapping[$ref_book];

		$sql = sprintf("INSERT INTO openbible_cross_reference (book, chapter, verse, ref_book, ref_chapter, ref_start_verse, ref_end_verse) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
			mysqli_real_escape_string($db, $book),
			mysqli_real_escape_string($db, $chapter),
			mysqli_real_escape_string($db, $verse),
			mysqli_real_escape_string($db, $ref_book),
			mysqli_real_escape_string($db, $ref_chapter),
			mysqli_real_escape_string($db, $ref_start_verse),
			mysqli_real_escape_string($db, $ref_end_verse)
		);

		if (!mysqli_query($db, $sql))
		{
			echo "Failed to insert into openbible_places: " . mysqli_error($db) . ". SQL: $sql\n";
			exit(1);
		}
	}

	fclose($inf);
}

function BeginTransaction($db)
{
	$sql = "BEGIN";
	mysqli_query($db, $sql);
}

function Commit($db)
{
	$sql = "COMMIT";
	mysqli_query($db, $sql);
}

/**
 * PHP 5.2.x getopt() doesn't support long options, so we're reinventing the wheel here
 */
function MyGetOpt($short_str, $long_options)
{
	global $argv;

	$result = array();
	$short_options = str_split($short_str);
	foreach ($argv as $i => $arg)
	{
		$arg = str_replace('-', '', $arg);
		if (in_array($arg, $short_options) || in_array($arg, $long_options))
		{
			$result[$arg] = true;
		}
	}
	return $result;
}
