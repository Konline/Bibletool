<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第二段  傳道前之預備工作</h2>
<hr>

<p><a href="SEC2-01.php">第一章  開路先鋒</a>
<p><a href="SEC2-02.php">第二章  受浸與受試探</a>
<p><a href="SEC2-03.php">第三章  召收門徒</a>
<p><a href="SEC2-04.php">第四章  開始傳道</a>

<hr>

'));

$smarty->display('gospel.tpl');
