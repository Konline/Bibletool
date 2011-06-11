<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第四段  第二年之傳道工作</h2>
<h3 class=gospel>第六章  在迦百農之醫治工作</h3>
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
	<td class=gospel><a href=../retrieve/?ranges=MAT:12:9-14&ranges=MAK:3:1-6&ranges=LUK:6:6-11>在安息日醫治枯手者</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:12:9-14>12:9-14</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:3:1-6>3:1-6</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:6:6-11>6:6-11</a>
        <td class=gospel>&nbsp;
        <td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:8:5-13&ranges=LUK:7:1-10&ranges=ISA:49:12-13>醫治百夫長的僕人</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:8:5-13>8:5-13</a>
        <td class=gospel>&nbsp;
        <td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:6:17-19>6:17-19</a>
	<td class=gospel><a href=../retrieve/?ranges=ISA:49:12-13>賽49:12-13</a>
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:18-19&ranges=MAT:9:23-26&ranges=MAK:5:21-24&ranges=MAK:5:37-43&ranges=LUK:8:40-42&ranges=LUK:8:51-56>在安息日醫治枯手者</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:18-19>9:23-26</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:5:21-24>5:37-43</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:8:40-42>8:51-56</a>
        <td class=gospel>&nbsp;
        <td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:20-22&ranges=MAK:5:25-34&ranges=LUK:8:43-48>使血漏婦人痊癒</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:20-22>9:20-22</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:5:25-34>5:25-34</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:8:43-48>8:43-48</a>
        <td class=gospel>&nbsp;
        <td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:27-31>使二個瞎子看見</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:27-31>9:27-31</a>
        <td class=gospel>&nbsp;
        <td class=gospel>&nbsp;
        <td class=gospel>&nbsp;
        <td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:32-34>使啞吧者說話</a>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:32-34>9:32-34</a>
        <td class=gospel>&nbsp;
        <td class=gospel>&nbsp;
        <td class=gospel>&nbsp;
        <td class=gospel>&nbsp;
</tr>
</table>

'));

$smarty->display('gospel.tpl');
