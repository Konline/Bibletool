<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第陸段 受難前一週之事跡</h2>
<h3 class=gospel>第十四章 被安葬</h3>
<table class=gospel border=1>
<tr class=gospel>
	<th class=gospel>分節標題
	<th class=gospel>馬太
	<th class=gospel>馬可
	<th class=gospel>路加
	<th class=gospel>約翰
	<th class=gospel>參考經文
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:27:57-61&ranges=MAK:15:42-47&ranges=LUK:23:50-56&ranges=JHN:19:38-42>亞利馬太安葬耶穌</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:27:57-61>27:57-61</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:15:42-47>15:42-47</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:23:50-56>23:50-56</a>
	<td class=gospel><a href=../retrieve/?ranges=JHN:19:38-42>19:38-42</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:27:62-66>兵丁看守墳墓</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:27:62-66>27:62-66</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:23:56-56&ranges=EXO:20:8-11>眾人安息</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:23:56-56>23:56</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=EXO:20:8-11>出20:8-11</a>
</tr>
</table>

'));

$smarty->display('gospel.tpl');
