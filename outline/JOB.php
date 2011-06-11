<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">約伯記簡介</h1>
<p>約伯記是聖經中的第十八卷經書，聖經中的詩歌書有：約伯記、詩篇、箴言、傳道書和雅歌等五卷；而約伯記是其中的第一卷。詩歌書的內容是
神的子民在生活中，所得的各種經歷，受聖靈的感動下，藉著詩詞向外傾吐；所以聖經中的詩歌並不是抽象，空想，不切實際的。</p>
<p>
本卷書的主要人物是約伯，所以名之為約伯記，而「約伯」原意即「遭痛恨」或「受逼迫」。聖經對約伯的描述是「完全正直，敬畏　神，遠離惡事」，是位義人；所以他受了撒但的痛恨和逼迫。義人受撒但的攻擊，義人要受苦，在聖經上說也是出於　神的許可，目的是要人得到更深的造就。人生在世有許多的事，我們一時不能明白，但深信萬事都互相效益，只要我們愛　神，定能得到益處。</p>
<hr>
<h1 ALIGN="center">約伯記大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 義人約伯遭遇苦難</td>
<td>1:1-2:13</td>
</tr>
<tr>
<td>二、 約伯三友的對話</td>
<td>3:1-31:40</td>
</tr>
<tr>
<td>三、 以利戶的議論</td>
<td>32:1-37:24</td>
</tr>
<tr>
<td>四、 神的回應</td>
<td>38:1-41:34</td>
</tr>
<tr>
<td>五、 約伯憬悟蒙神加倍賜福</td>
<td>42:1-42:17</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">約伯記表解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center">絕望</td>
<td ALIGN="center">辯論</td>
<td ALIGN="center" COLSPAN="2">結局</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">
<p>約伯的苦難</p>
<p>1-3</p>
</td>
<td ALIGN="center">
<p>約伯答辯</p>
<p>以利法</p>
<p>比勒達</p>
<p>以利戶</p>
<p>4-37</p>
</td>
<td ALIGN="center">
<p>神的回答</p>
<p>38-39</p>
</td>
<td ALIGN="center">
<p>約伯的釋放</p>
<p>40-42</p>
</td>
</tr>
<tr>
<td ALIGN="center" ROWSPAN="2">主題</td>
<td ALIGN="center">試煉</td>
<td ALIGN="center">紛亂</td>
<td ALIGN="center" COLSPAN="2">勝利</td>
</tr>
<tr>
<td ALIGN="center">撒但與神</td>
<td ALIGN="center">四友與約伯</td>
<td ALIGN="center" COLSPAN="2">神與約伯</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center" COLSPAN="4">烏斯地(北阿拉伯)</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="4">族長時期(約 BC.2000 年)</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
