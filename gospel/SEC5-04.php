<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第伍段 第三年之傳道工作</h2>
<h3 class=gospel>第四章 在耶路撒冷之講論</h3>
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
        <td class=gospel><a href=../retrieve/?ranges=JHN:7:1-52>住棚節</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=JHN:7:1-52>7:1-52</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=JHN:8:1-11&ranges=LEV:8:11-11>誰沒有罪﹖</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=JHN:8:1-11>8:1-11</a>
	<td class=gospel><a href=../retrieve/?ranges=LEV:8:11-11>利8:11</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=JHN:8:12-59&ranges=ISA:6:9-9>光與自由</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=JHN:8:12-59>8:12-59</a>
	<td class=gospel><a href=../retrieve/?ranges=ISA:6:9-9>賽6:9</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=JHN:10:1-21>我是好牧人</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=JHN:10:1-21>10:1-21</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=JHN:10:22-39&ranges=PSM:82:6-6>修殿節</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=JHN:10:22-39>10:22-39</a>
	<td class=gospel><a href=../retrieve/?ranges=PSM:82:6-6>詩82:6</a>
</tr>
</table>

'));

$smarty->display('gospel.tpl');
