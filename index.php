<?php

require(dirname(__FILE__) . '/' . 'smarty.config.php');

$smarty->assign('header', array('root' => '.'));
$smarty->assign('body', 'Hello world!');

$smarty->display('index.tpl');

?>
