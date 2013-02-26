<?php

/**
 * Unittest of Bible.php class
 */

require_once 'lib/Bible.php';

class BibleTest extends PHPUnit_Framework_TestCase
{
	public function testParseBibleRange()
	{
		$bible = Bible::getInstance();

		// Check empty range
		$this->assertNull($bible->parseBibleRange(''));

		// Check for invalid range
		$this->assertNull($bible->parseBibleRange('foo'));

		// Check for $book:$chapter
		$this->assertEquals(array(array('UCV'), 'GEN', 1, 1, 1000),
							$bible->parseBibleRange('GEN:1'));

		// Check for $book:$chapter
		$this->assertEquals(array(array('UCV'), 'GEN', 1, 1, 1000),
							$bible->parseBibleRange('GEN:1'));
		$this->assertEquals(array(array('UCV'), 1, 1, 1, 1000),
							$bible->parseBibleRange('1:1'));

		// Check for $language:$book:$chapter
		$this->assertEquals(array(array('UCV'), 'GEN', 1, 1, 1000),
							$bible->parseBibleRange('UCV:GEN:1'));
		$this->assertEquals(array(array('UCV'), 1, 1, 1, 1000),
							$bible->parseBibleRange('UCV:1:1'));

		// Check for $book:$chapter:$verses
		$this->assertEquals(array(array('UCV'), 'GEN', 1, 1, 1),
							$bible->parseBibleRange('GEN:1:1'));
		$this->assertEquals(array(array('UCV'), 1, 1, 1, 1),
							$bible->parseBibleRange('1:1:1'));
		$this->assertEquals(array(array('UCV'), 'GEN', 1, 1, 10),
							$bible->parseBibleRange('GEN:1:1-10'));
		$this->assertEquals(array(array('UCV'), 1, 1, 1, 10),
							$bible->parseBibleRange('1:1:1-10'));

		// Check for $language:$book:$chapter:$verses
		$this->assertEquals(array(array('KJV'), 'GEN', 1, 1, 1),
							$bible->parseBibleRange('KJV:GEN:1:1'));
		$this->assertEquals(array(array('KJV'), 1, 1, 1, 1),
							$bible->parseBibleRange('KJV:1:1:1'));
		$this->assertEquals(array(array('KJV'), 'GEN', 1, 1, 10),
							$bible->parseBibleRange('KJV:GEN:1:1-10'));
		$this->assertEquals(array(array('KJV'), 1, 1, 1, 10),
							$bible->parseBibleRange('KJV:1:1:1-10'));
	}

	public function testConvertBookNames()
	{
		$bible = Bible::getInstance();

		$this->assertEquals('JHN', $bible->convertBookNames('John'));
		$this->assertEquals('JHN 3', $bible->convertBookNames('John 3'));
		$this->assertEquals('JHN 3:16', $bible->convertBookNames('John 3:16'));
		$this->assertEquals('JHN 3:16-18', $bible->convertBookNames('John 3:16-18'));
		$this->assertEquals('JHN', $bible->convertBookNames('約'));
		$this->assertEquals('JHN 3', $bible->convertBookNames('約 3'));
		$this->assertEquals('JHN 3:16', $bible->convertBookNames('約 3:16'));
		$this->assertEquals('JHN 3:16-18', $bible->convertBookNames('約 3:16-18'));
	}
};
