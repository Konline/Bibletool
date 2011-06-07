<?php
/* Initialize Bible database from text files
 */

ini_set('include_path', ini_get('include_path') . ':' . dirname(__FILE__) . '/../lib');

require_once 'Config.php';
require_once 'ParserHelper.php';

$config = Config::getInstance();

// Initialize database
echo "Connecting to database...\n";
$db = mysql_connect($config->database->host, $config->database->user, $config->database->pass);
if (!$db)
{
	echo "Failed to connect to database\n";
	exit(1);
}
mysql_select_db($config->database->dbname);

echo "Initializing schema...\n";
$sqls = file_get_contents(__DIR__ . '/../db/schema.sql');

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

foreach ($LANGUAGES as $name => $lang)
{
	$description = $lang['description'];
	$filename = __DIR__ . '/../data/' . $lang['filename'];
	$inf = fopen($filename, 'r');
	if (!$inf)
	{
		echo "$filename not found\n";
		exit(1);
	}

	echo "Parsing $filename\n";
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
		if (preg_match("/([^ ]+) (\d+):(\d+)--(.*)/", $line, $matches))
		{
			$book = trim($matches[1]);
			$chapter = trim($matches[2]);
			$verse = trim($matches[3]);
			$body = mysql_real_escape_string(trim($matches[4]));

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

			$sql = "INSERT INTO verses (language_id, book, chapter, verse, body) VALUES ('$language_id', '$book_no', '$chapter', '$verse', '$body')";
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
