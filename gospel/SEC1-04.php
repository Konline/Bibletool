<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第一段  降生受浸前之事蹟</h2>
<h3 class=gospel>第四章  耶穌基督家譜</h3>
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
	<td class=gospel><a href=../retrieve/?ranges=MAT:1:1-17>父系家譜</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:1:1-17>1:1-17</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>	
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:3:23-38>母系家譜</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:3:23-38>3:23-38</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>	
</table>

'));

$smarty->display('gospel.tpl');
