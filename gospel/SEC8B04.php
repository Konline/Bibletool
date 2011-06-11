<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合--主耶穌基督微行錄</h1>
<h2 class=gospel>第捌段 附錄</h2>
<h3 class=gospel>附錄B.主耶穌所講的比喻之四</h3>
<h4>一般人事之比喻</h4>
<table class=gospel border=1>
<tr class=gospel>
	<th class=gospel>四、一般人事
	<th class=gospel>時間
	<th class=gospel>馬太
	<th class=gospel>馬可
	<th class=gospel>路加
	<th class=gospel>約翰
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:10:30-37>好鄰舍</a>
	<th class=gospel>AD.30年1月
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:10:30-37>10:30-37</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:11:5-10>朋友</a>
	<th class=gospel>AD.30年1月
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:11:5-10>11:5-10</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:12:15-21>無知的財主</a>
	<th class=gospel>AD.30年1月
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:12:15-21>12:15-21</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:14:7-15>客人</a>
	<th class=gospel>AD.30年2月
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:14:7-15>14:7-15</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:14:16-24>神的宴會</a>
	<th class=gospel>AD.30年2月
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:14:16-24>14:16-24</a>
	<td class=gospel>&nbsp;
</tr> 
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:15:8-10>失錢</a>
	<th class=gospel>AD.30年2月
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:15:8-10>15:8-10</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:15:11-32>浪子回頭</a>
	<th class=gospel>AD.30年2月
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:15:11-32>15:11-32</a>
	<td class=gospel>&nbsp;
</tr> 
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:1-8>伸冤的寡婦</a>
	<th class=gospel>AD.30年3月
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:1-8>18:1-8</a>
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:9-14>自以為義的人</a>
	<th class=gospel>AD.30年3月
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:18:9-14>18:9-14</a>
	<td class=gospel>&nbsp;
</tr> 
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:21:28-32>兩個兒子</a>
	<th class=gospel>AD.30年4月4日
	<td class=gospel><a href=../retrieve/?ranges=MAT:21:28-32>21:28-32</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:22:1-14>娶親的宴席</a>
	<th class=gospel>AD.30年4月4日
	<td class=gospel><a href=../retrieve/?ranges=MAT:22:1-14>22:1-14</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:25:1-13>十個童女</a>
	<th class=gospel>AD.30年4月4日
	<td class=gospel><a href=../retrieve/?ranges=MAT:25:1-13>25:1-13</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>
</table>

'));

$smarty->display('gospel.tpl');
