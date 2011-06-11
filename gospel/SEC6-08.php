<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第陸段 受難前一週之事跡</h2>
<h3 class=gospel>第八章 在客西馬尼園</h3>
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
	<td class=gospel><a href=../retrieve/?ranges=MAT:26:30-30&ranges=MAK:14:26-26&ranges=LUK:22:29-29&ranges=JHN:18:1-2>與門徒去橄欖山</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:26:30-30>26:30</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:14:26-26>14:26</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:22:39-39>22:29</a>
	<td class=gospel><a href=../retrieve/?ranges=JHN:18:1-2>18:1-2</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:26:31-35&ranges=ranges=MAK:14:27-31>再次預言彼得不認主</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:26:31-35>26:31-35</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:14:27-31>14:27-31</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:26:36-46&ranges=ranges=MAK:14:32-42&ranges=LUK:22:40-46&ranges=PSM:42:6-6>客西馬尼園的禱告</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:26:36-46>26:36-46</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:14:32-42>14:32-42</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:22:40-46>22:40-46</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=PSM:42:6-6>詩42:6</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:26:47-56&ranges=ranges=MAK:14:43-52&ranges=LUK:22:47-53&ranges=JHN:18:3-13>耶穌被捉拿</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:26:47-56>26:47-56</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:14:43-52>14:43-52</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:3-13>18:3-13</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
</table>

'));

$smarty->display('gospel.tpl');
