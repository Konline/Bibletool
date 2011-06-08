<?php

ini_set('include_path', ini_get('include_path') . ':' . dirname(__FILE__) . '/lib');

require_once 'Bible.php';

$bible = Bible::getInstance();

print_r($bible->getVerses(array('UCV', 'NIV'), 1, 1, 1));
// print_r($bible->getLanguages());
// print_r($bible->getBooks("NIV"));
// print_r($bible->getNumChapters(1));
