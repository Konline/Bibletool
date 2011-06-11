<?php

// put full path to Smarty.class.php
require(dirname(__FILE__).'/'.'lib/Smarty/Smarty.class.php');

$smarty = new Smarty();
$smarty->setTemplateDir(dirname(__FILE__).'/'.'smarty/templates');
$smarty->setCompileDir(dirname(__FILE__).'/'.'smarty/templates_c');
$smarty->setCacheDir(dirname(__FILE__).'/'.'smarty/cache');
$smarty->setConfigDir(dirname(__FILE__).'/'.'smarty/configs');

?>



