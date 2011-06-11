<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第四段  第二年之傳道工作</h2>
<hr>

<p><a href="SEC4-01.html">第一章  在耶路撒冷過節</a>
<p><a href="SEC4-02.html">第二章  講論父與子之關係</a>
<p><a href="SEC4-03.html">第三章  在迦百農之工作</a>
<p><a href="SEC4-04.html">第四章  登山寶訓</a>
<p><a href="SEC4-05.html">第五章  一般講論</a>
<p><a href="SEC4-06.html">第六章  在迦百農之醫治工作</a>
<p><a href="SEC4-07.html">第七章  在加利利之工作</a>
<p><a href="SEC4-08.html">第八章  對法利賽人之講論</a>
<p><a href="SEC4-09.html">第九章  天國之比喻</a>
<p><a href="SEC4-10.html">第十章  在加利利之工作</a>
<p><a href="SEC4-11.html">第十一章  在迦百農之神蹟大能</a>
<p><a href="SEC4-12.html">第十二章  其他事蹟之記載</a>

<hr>

'));

$smarty->display('gospel.tpl');
