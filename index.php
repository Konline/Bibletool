<?php

ini_set('include_path', ini_get('include_path') . ':' . dirname(__FILE__) . '/lib');

require_once 'Bible.php';

$bible = Bible::getInstance();

print_r($bible->getVerses('UCV', 1, 1, 1));
