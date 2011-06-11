<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第五段  第三年之傳道工作</h2>
<hr>

<p><a href="SEC5-01.php">第一章  一般之教訓</a>
<p><a href="SEC5-02.php">第二章  預言將要受難</a>
<p><a href="SEC5-03.php">第三章  腓立比的黑門山</a>
<p><a href="SEC5-04.php">第四章  在耶路撒冷之講論</a>
<p><a href="SEC5-05.php">第五章  在以法蓮之講論</a>
<p><a href="SEC5-06.php">第六章  往伯大尼</a>
<p><a href="SEC5-07.php">第七章  經耶利哥</a>
<p><a href="SEC5-08.php">第八章  在約但河東</a>
<p><a href="SEC5-09.php">第九章  耶穌對眾人的講論</a>
<p><a href="SEC5-10.php">第十章  耶穌之醫治工作</a>
<p><a href="SEC5-11.php">第十一章  耶穌所行的神蹟</a>
<p><a href="SEC5-12.php">第十二章  耶穌所講的比喻</a>

<hr>

'));

$smarty->display('gospel.tpl');
