<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第三段  第一年之傳道工作</h2>
<h3 class=gospel>第一章  第一個逾越節</h3>
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
	<td class=gospel><a href=../retrieve/?ranges=JHN:2:13-25&ranges=PSM:69:9-9>潔淨聖殿</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=JHN:2:13-25>2:13-25</a>
	<td class=gospel><a href=../retrieve/?ranges=PSM:69:9-9>詩69:9</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=JHN:3:1-24&ranges=NUM:21:8-9>講論重生之道</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=JHN:3:1-24>3:1-24</a>
	<td class=gospel><a href=../retrieve/?ranges=NUM:21:8-9>民21:8-9</a>
</tr>
</table>

'));

$smarty->display('gospel.tpl');
