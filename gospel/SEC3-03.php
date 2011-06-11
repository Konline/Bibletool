<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第三段  第一年之傳道工作</h2>
<h3 class=gospel>第三章  撒瑪利亞婦人</h3>
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
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:3-42&ranges=JOS:24:32-32>與撒瑪利亞婦人談道</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=JHN:4:3-42>4:3-42</a>
	<td class=gospel><a href=../retrieve/?ranges=JOS:24:32-32>書24:32</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:12-12&ranges=MAT:14:3-5&ranges=MAK:1:14-14&ranges=MAK:6:17-20&ranges=JHN:3:19-20>施洗約翰被囚</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:12-12>4:12</a>
	<br>
	<td class=gospel><a href=../retrieve/?ranges=MAT:14:3-51>4:3-5</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:1:12-14>1:14</a>
	<br>
	<td class=gospel><a href=../retrieve/?ranges=MAK:6:17-20>6:17-20</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:1:12-14>可3:19-20</a>
</tr>
</table>

'));

$smarty->display('gospel.tpl');
