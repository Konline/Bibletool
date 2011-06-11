<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第三段  第一年之傳道工作</h2>
<h3 class=gospel>第四章在加利利之工作</h3>
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
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:17-17&ranges=MAK:1:14-15&ranges=LUK:4:14-15&ranges=JHN:4:43-45>在加利利開始傳道</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:17-17>4:17</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:1:14-15>1:14-15</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:4:14-15>4:14-15</a>
	<td class=gospel><a href=../retrieve/?ranges=JHN:4:43-45>4:43-45</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=JHN:4:46-54>醫治大臣之子</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=JHN:4:43-45>4:43-45</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:4:16-30&ranges=ISA:61:1-2>被拿撒勒人棄絕</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:4:16-30>4:16-30</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=ISA:61:1-2>賽61:1-2</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:13:54-58&ranges=MAK:6:1-6>再次被拿撒勒人棄絕</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:13:54-58>13:54-58</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:6:1-6>6:1-6</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:23-25&ranges=MAK:1:35-39&ranges=LUK:4:42-44>週遊加利利傳道</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:4:23-25>4:23-25</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:1:35-39>1:35-39</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:4:42-44>4:42-44</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:8:2-4&ranges=MAK:1:40-45&ranges=LUK:5:12-16&ranges=LEV:13:49-49>醫治長大痲瘋的人</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:8:2-4>8:2-4</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:1:40-45>1:40-45</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:5:12-16>5:12-16</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LEV:13:49-49>利13:49</a>
</tr>
</table>

'));

$smarty->display('gospel.tpl');
