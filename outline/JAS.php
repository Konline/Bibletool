<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">雅各書大綱</h1>
<p>
雅各書是聖經中的第五十九卷經書，是新約中的第二十卷。雅各書為耶穌的弟弟雅各所寫，信主雖遲，但後來成為教會中的領袖，書中充滿了許多實際上的教導，是寫給散居在各地的神的子民的一卷書。</p>
<p>
書中包含基督徒立身處世、行事為人的實際教訓，所著重的是行道，極少神學上的探討。觸及倫理、道德的精簡智慧語甚多，主要集中在力行(雅2:14-26),慎言(雅3:1-12),
社會正義(雅2:1-13;5:1-6)和禱告的力量(雅5:13-18)上。等別強調行為和信心在信仰的根基上同等重要。</p>
<p>本卷書成書約在主後四十五年，是新約中最早的一卷。</p>
<hr>
<h1 ALIGN="center">雅各書大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 基督信徒的生活</td>
<td>1:1-1:27</td>
</tr>
<tr>
<td>二、 訓勉與責備</td>
<td>2:1-4:17</td>
</tr>
<tr>
<td>三、 聖徒的信心</td>
<td>5:1-5:20</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">雅各書表解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">第 1 章</td>
<td ALIGN="center">第 2 章</td>
<td ALIGN="center">第 3 章</td>
<td ALIGN="center">第 4 章</td>
<td ALIGN="center">第 5 章</td>
</tr>
<tr>
<td ALIGN="center">信心的試煉</td>
<td ALIGN="center">信心的作為</td>
<td ALIGN="center">信心的言語</td>
<td ALIGN="center">信心的生活</td>
<td ALIGN="center">信心的等候</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="5">只是你們要行道,不要單單聽道(雅1:22)</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
