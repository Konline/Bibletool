<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第七段  耶穌基督復活升天</h2>
<hr>

<p><a href="SEC7-01.php">第一章  七日的第一日</a>
<p><a href="SEC7-02.php">第二章  抹大拉馬利亞</a>
<p><a href="SEC7-03.php">第三章  主向門徒顯現</a>
<p><a href="SEC7-04.php">第四章  提比哩亞海邊</a>
<p><a href="SEC7-05.php">第五章  升天前的教訓</a>
<p><a href="SEC7-06.php">第六章  福音之總結</a>

<hr>

'));

$smarty->display('gospel.tpl');
