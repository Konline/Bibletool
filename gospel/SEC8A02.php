<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合--主耶穌基督微行錄</h1>
<h2 class=gospel>第捌段 附錄</h2>
<h3 class=gospel>附錄 A.主耶穌所行的神蹟之二</h3>
<h4>趕逐污鬼之神蹟</h4>
<table class=gospel border=1>
<tr class=gospel>
	<th class=gospel>二、趕 逐 污 鬼
	<th class=gospel>時間
	<th class=gospel>馬太
	<th class=gospel>馬可      
	<th class=gospel>路加      
	<th class=gospel>約翰     
</tr>
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAK:1:23-26&ranges=LUK:4:33-35>迦百農會堂被鬼附的人</a>
	<th class=gospel>AD.28年春
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=MAK:1:23-26>1:23-26</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:4:33-35>4:33-35</a>
	<td class=gospel>&nbsp;
</tr>	
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:8:29-34&ranges=MAK:5:1-17&ranges=LUK:8:27-37>趕鬼入豬群</a>
	<th class=gospel>AD.28年春
	<td class=gospel><a href=../retrieve/?ranges=MAT:8:29-34>8:29-34</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:5:1-17>5:1-17</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:8:27-37>8:27-37</a>
	<td class=gospel>&nbsp;
</tr>	
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:32-33>被鬼附的啞吧</a>
	<th class=gospel>AD.28年秋
	<td class=gospel><a href=../retrieve/?ranges=MAT:9:32-33>9:32-33</a>
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
	<td class=gospel>&nbsp;
</tr>	
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:12:22-22&ranges=LUK:11:14-14>被鬼附著又瞎又啞的人</a>
	<th class=gospel>AD.28年秋
	<td class=gospel><a href=../retrieve/?ranges=MAT:12:22-22>12:22</a>
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=LUK:11:14-14>11:14</a>
	<td class=gospel>&nbsp;
</tr>	 
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:15:21-28&ranges=MAK:7:24-30>迦南婦人的女兒被鬼附</a>
	<th class=gospel>AD.29年夏
	<td class=gospel>&nbsp;
	<td class=gospel><a href=../retrieve/?ranges=MAT:15:21-28>15:21-28</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:7:24-30>7:24-30</a>
	<td class=gospel>&nbsp;
</tr>	 
<tr class=gospel>
	<td class=gospel><a href=../retrieve/?ranges=MAT:17:14-18&ranges=MAK:9:17-27&ranges=LUK:9:38-42>被鬼附害癲癇病的男孩</a>
	<th class=gospel>AD.29年夏
	<td class=gospel><a href=../retrieve/?ranges=MAT:17:14-18>17:14-18</a>
	<td class=gospel><a href=../retrieve/?ranges=MAK:9:17-27>9:17-27</a>
	<td class=gospel><a href=../retrieve/?ranges=LUK:9:38-42>9:38-42</a>
	<td class=gospel>&nbsp;
</tr>	
</table>

'));

$smarty->display('gospel.tpl');
