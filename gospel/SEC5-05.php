<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第伍段 第三年之傳道工作</h2>
<h3 class=gospel>第五章 在以法蓮之講論</h3>
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
	<td class=gospel><a href=../retrieve/?ranges=JHN:7:1-52>人子再來的日子</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:17:20-37>17:20-37</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:1-8>禱告要恆切</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:1-8>18:1-8</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:9-14>自義的人</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:9-14>18:9-14</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:19:3-12&ranges=LUK:10:1-12&ranges=DEU:24:1-4&ranges=GEN:2:23-25>不可休妻</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:19:3-12>19:3-12</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:10:1-12>10:1-12</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=DEU:24:1-4>申24:1-4</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:19:13-15&ranges=MAK:10:13-16&ranges=LUK:18:15-17&ranges=PSM:131:2-2>為小孩子祝福</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:19:13-15>19:13-15</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:10:13-16>10:13-16</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:15-17>18:15-17</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=PSM:131:2-2>詩131:2</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:19:16-30&ranges=MAK:10:17-31&ranges=LUK:18:18-30&ranges=EXO:20:1-17>財主進神的國</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:19:16-30>19:16-30</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:10:17-31>10:17-31</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:18-30>18:18-30</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=EXO:20:1-17>出20:1-17</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:20:20-28&ranges=MAK:10:35-45>爭論誰為大﹖</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:20:20-28>20:20-28</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:10:35-45>10:35-45</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
</table>

'));

$smarty->display('gospel.tpl');
