<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第三段  第一年之傳道工作</h2>
<hr>

<p><a href="SEC3-01.php">第一章  第一個逾越節</a>
<p><a href="SEC3-02.php">第二章  在猶太地居住</a>
<p><a href="SEC3-03.php">第三章  撒瑪利亞婦人</a>
<p><a href="SEC3-04.php">第四章  在加利利之傳道工作</a>
<p><a href="SEC3-05.php">第五章  在迦百農之傳道工作</a>
<p><a href="SEC3-06.php">第六章  在迦百農之醫治工作</a>

<hr>

'));

$smarty->display('gospel.tpl');
