<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第一段  降生受浸前之事蹟</h2>
<hr>

<p><a href="SEC1-01.php">第一章 福音引言</a>
<p><a href="SEC1-02.php">第二章 天使報信</a>
<p><a href="SEC1-03.php">第三章 施洗約翰的誕生</a>
<p><a href="SEC1-04.php">第四章 耶穌基督的家譜</a>
<p><a href="SEC1-05.php">第五章 耶穌基督的降生</a>
<p><a href="SEC1-06.php">第六章 在拿撒勒城成長</a>

<hr>

'));

$smarty->display('gospel.tpl');
