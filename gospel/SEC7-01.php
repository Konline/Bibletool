<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第柒段 耶穌基督復活升天
<h3 class=gospel>第一章 空的墳墓</h3>
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
	<td class=gospel><a href=../retrieve/?ranges=MAT:28:1-4&ranges=MAK:16:1-4&ranges=LUK:24:1-3&ranges=JHN:20:1-2>七日的頭一日</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:28:1-4>28:1-4</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:16:1-4>16:1-4</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:24:1-3>24:1-3</a>
	<td class=gospel><a href=../retrieve/?ranges=JHN:20:1-2>20:1-2</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:28:5-8&ranges=MAK:16:5-8&ranges=LUK:24:4-9>宣告主已復活</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:28:5-8>28:5-8</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:16:5-8>16:5-8</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:24:4-9>24:4-9</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:24:12-12&ranges=JHN:20:3-10>彼得約翰奔往察看</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:24:12-12>24:12</a>
	<td class=gospel><a href=../retrieve/?ranges=JHN:20:3-10>24:3-10</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:28:11-15>兵丁報告耶穌復活經過</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:28:11-15>24:11-15</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
</table>

'));

$smarty->display('gospel.tpl');
