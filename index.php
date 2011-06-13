<?php

ini_set('include_path', ini_get('include_path') . ':' . dirname(__FILE__) . '/lib');

require_once 'Config.php';
require_once 'Bible.php';
require_once 'Smarty.php';

$config = Config::getInstance();
$bible = Bible::getInstance();
$smarty = new Bible_Smarty($config);

$action = $_REQUEST['action'];
$smarty->assign('action', $action);

switch ($action)
{
	case 'static':
		$smarty->assign('page', $_REQUEST['page']);
		$smarty->display('static.tmpl');
		break;

	case 'gospel':
		$page = $_REQUEST['page'] ? $_REQUEST['page'] : 'index';
		$smarty->assign('page', $page);
		$smarty->display('gospel.tmpl');
		break;

	case 'outline':
		$page = $_REQUEST['page'] ? $_REQUEST['page'] : 'GEN';
		$smarty->assign('page', $page);
		$smarty->display('outline.tmpl');
		break;

	case 'get_verses':
		require_once 'Action_GetVerses.php';
		$controller = new Action_GetVerses($bible, $smarty);
		$controller->process();
		break;

	case 'retrieve':
		require_once 'Action_Retrieve.php';
		$controller = new Action_Retrieve($bible, $smarty);
		$controller->process();
		break;

	case 'browse':
	default:
		$smarty->display('browse.tmpl');
		break;
}
