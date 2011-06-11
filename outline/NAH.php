<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">那鴻書簡介</h1>
<p>
那鴻書是全部聖經中第三十四卷書，本書作者詩才橫溢，得　神啟示，預見當時雄踞兩河流域的亞述帝國的衰亡。先知那鴻描寫其淪陷會像搖果子已熟的樹，果子紛紛墜落那樣容易。在主前612年,尼尼微果為巴比倫所滅，長埋風沙。二千年來無人知其遺址，直到十九世紀中葉，才在底格里斯河畔掘出此城之廢墟。</p>
<p>
本書文筆辛辣，諷剌帶著眼淚，慨嘆人類何以不能從歷史中學教訓，要人知道掌管宇宙的　神，雖不輕易發怒，但祂也是公義的神，祂絕不放過殘忍無道，流人血的城，如尼尼微，那鴻書中哀悼尼尼微的話，也是向一切現在崇尚暴力，製造人間恐怖的人說的。</p>
<hr>
<h1 ALIGN="center">那鴻書大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 標題</td>
<td>1:1</td>
</tr>
<tr>
<td>二、 讚美神的公義</td>
<td>1:2-1:8</td>
</tr>
<tr>
<td>三、 宣示尼尼微的毀滅</td>
<td>1:9-1:15</td>
</tr>
<tr>
<td>四、 預言尼尼微受刑罰的情景</td>
<td>2:1-2:13</td>
</tr>
<tr>
<td>五、 亞述行惡自招毀滅</td>
<td>3:1-3:19</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">那鴻書表解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">第 1 章</td>
<td ALIGN="center">第 2 章</td>
<td ALIGN="center">第 3 章</td>
</tr>
<tr>
<td ALIGN="center">向尼尼微震怒</td>
<td ALIGN="center">對尼尼微警告</td>
<td ALIGN="center">為尼尼微哀痛</td>
</tr>
<tr>
<td ALIGN="center">毀滅</td>
<td ALIGN="center">輓歌</td>
<td ALIGN="center">死亡</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
