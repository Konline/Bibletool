<?php

// put full path to Smarty.class.php
require('lib/Smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('smarty/templates');
$smarty->setCompileDir('smarty/templates_c');
$smarty->setCacheDir('smarty/cache');
$smarty->setConfigDir('smarty/configs');

$smarty->assign('name', 'Ned');
$smarty->display('index.tpl');

?>
