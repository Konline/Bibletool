<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第三段  第一年之傳道工作</h2>
<h3 class=gospel>第五章  在迦百農之工作</h3>
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
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:13-13&ranges=LUK:4:31-31>在迦百農傳道</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:13-13>4:13</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:4:31-31>4:31</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:18-22&ranges=MAK:1:16-20&ranges=LUK:5:1-11&ranges=PSM:33:9-9>召彼得等四門徒</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:18-22>4:18-22</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:1:16-20>1:16-20</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:5:1-11>5:1-11</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=PSM:33:9-9>詩33:9</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAK:1:21-28&ranges=LUK:4:32-37>在會堂趕逐污鬼</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=MAK:1:21-28>1:21-28</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:4:32-37>4:32-37</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/??ranges=MAT:9:9-13&ranges=MAK:2:13-17&ranges=LUK:5:27-32&ranges=HOS:6:6-6>稅史馬太被召</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:9-13>9:9-13</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:2:13-17>2:13-17</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:5:27-32>5:27-32</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=HOS:6:6-6>何6:6</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/??ranges=MAT:9:14-17&ranges=MAK:2:18-22&ranges=LUK:5:33-39>論門徒禁食</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:14-17>9:14-17</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:2:18-22>2:18-22</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:5:33-39>5:33-39</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
</table>

'));

$smarty->display('gospel.tpl');
