<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第伍段 第三年之傳道工作</h2>
<h3 class=gospel>第二章 預言將要受難</h3>
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
        <td class=gospel><a href=../retrieve/?ranges=MAT:16:13-20&ranges=LUK:9:18-21>彼得認耶穌為神的兒子</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:16:13-20>16:13-20</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:8:27-30>8:27-30</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:8:18-21>9:18-21</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:16:21-28&ranges=LUK:8:31-38&ranges=LUK:9:1-1&ranges=PRV:24:12-12>首次預言遭害</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:16:21-28>16:21-28</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:8:31-38>9:1</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:9:22-27>9:22-27</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=PRV:24:12-12>箴24:12</a>
</tr>	
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:17:22-27&ranges=MAK:9:30-32&ranges=LUK:9:43-45>二次預言遭害</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:17:22-27>17:22-27</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:9:30-32>9:30-32</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:9:43-45>9:43-45</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:20:17-19&ranges=MAK:10:32-34&ranges=LUK:18:31-34&ranges=PSM:22:1-31>三度預言遭害</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:20:17-19>20:17-19</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:10:32-34>10:32-34</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:31-34>18:31-34</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=PSM:22:1-31>詩22:1-31</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:26:1-2>最後再提及受害事</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:26:1-2>26:1-2</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
</table>

'));

$smarty->display('gospel.tpl');
