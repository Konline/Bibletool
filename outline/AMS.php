<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">阿摩司書簡介</h1>
<p>
阿摩司書是全部聖經中第三十卷書，阿摩司是南國一個鄉村裡的牧人，生活要靠修理桑樹來渡日；後為　神所用，派他去北國作先知，向深陷在拜偶像邪惡風氣中的人民，宣告神的刑罰。</p>
<p>
北國在耶羅波安第二治理下，國勢日強，列邦進貢，商貿興盛，國威遠播。但社會的繁榮也滋生了社會的不平和罪惡。富人權貴用肥牛獻祭，有虔敬之名，税失去了　神所悅納的公平和憐憫，強凌弱，粫暴寡，連窮人頭上所蒙的灰，也都垂涎；道德墜落，迫國中的正直人也同流合污(摩2:12)。阿摩司在此時果敢地說出真話：「耶羅波安必被刀殺，以色列人定被擄去離開本地」。</p>
<p>書中的預言，已應驗於撒瑪利亞城為亞述人所毀，和人民被擄往北方。在書末也預言未來，以色列必復興。</p>
<hr>
<h1 ALIGN="center">阿摩司書大綱</h1>
<table BORDER="1" ALIGN="center">
<tr>
<td>一、 序介</td>
<td>1:1-1:2</td>
</tr>
<tr>
<td>二、 宣佈列邦須受的刑罰</td>
<td>1:3-2:16</td>
</tr>
<tr>
<td>三、 詳論以色列的罪和須受的刑罰</td>
<td>3:1-6:14</td>
</tr>
<tr>
<td>四、 五個審判的異像和復興的應許</td>
<td>7:1-9:15</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">阿摩司書表解</h1>
<table BORDER="1" ALIGN="center">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center" COLSPAN="2">真實的審判</td>
<td ALIGN="center" COLSPAN="2">審判的來臨</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">
<p>降火的　神</p>
<p>1-2</p>
</td>
<td ALIGN="center">
<p>墜落的家族</p>
<p>3-5</p>
</td>
<td ALIGN="center">
<p>哀痛與警告</p>
<p>6-7</p>
</td>
<td ALIGN="center">
<p>拒絕與復健</p>
<p>8-9</p>
</td>
</tr>
<tr>
<td ROWSPAN="2">主題</td>
<td ALIGN="center">報復</td>
<td ALIGN="center">證明</td>
<td ALIGN="center">異象</td>
<td ALIGN="center">勝利</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="2">宣告</td>
<td ALIGN="center" COLSPAN="2">景象</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center">鄰國</td>
<td ALIGN="center" COLSPAN="3">北國以色列</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="4">約 10 年(主前 760-750 年)</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
