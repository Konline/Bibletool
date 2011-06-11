<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">列王紀下簡介</h1>
<p>
列王記下是聖經中的第十二卷經書，也是舊約歷史書中的第七卷。本書和「列王記上」一樣，仍是載猶大國和以色列國諸王的事蹟，中間也包括著一個著名的先知以利沙的事蹟。</p>
<p>
猶大國王—從亞哈謝起到西底家止；以色列國王—從約蘭起何細亞王止的事蹟。以利沙是繼以利亞之後的大先知。「以利沙」名字的意義是「耶和華我是救主」，他的工作範圍是在以色列國。以利沙的神蹟都是慈愛的工作，他所作的總是幫助、拯救和醫治，在性質上和以利亞的神蹟不同。</p>
<p>分裂後的猶大國王共十九位 (亞他利雅不被列在內，因她在篡位期間，約阿施在聖殿內繼續大衛家的系作王)
，以色列國王也有十九位。猶大國列王中有八位是好的；以色列國王中除了耶戶是半好半惡外，沒有一個是好的。</p>
<hr>
<h1 ALIGN="center">列王紀下大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 分裂後的王國和先知的聲音</td>
<td>1:1-9:37</td>
</tr>
<tr>
<td>二、 北國以色列的衰亡</td>
<td>10:1-17:41</td>
</tr>
<tr>
<td>三、 南國猶大的中興與衰落</td>
<td>18:1-23:30</td>
</tr>
<tr>
<td>四、 耶路撒冷淪陷─以色列民被擄</td>
<td>23:31-25:30</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">列王紀下表解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center" COLSPAN="4">分裂的國家</td>
<td ALIGN="center" COLSPAN="2">倖存的國家</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">
<p>以利亞的續承</p>
<p>1-3</p>
</td>
<td ALIGN="center">
<p>以利沙的服事</p>
<p>4-8</p>
</td>
<td ALIGN="center">
<p>亞哈王的毀滅</p>
<p>9-12</p>
</td>
<td ALIGN="center">
<p>以色列的毀滅</p>
<p>13-17</p>
</td>
<td ALIGN="center">
<p>希西家的統治</p>
<p>18-20</p>
</td>
<td ALIGN="center">
<p>猶大的滅亡</p>
<p>21-25</p>
</td>
</tr>
<tr>
<td ALIGN="center" ROWSPAN="2">主題</td>
<td ALIGN="center" COLSPAN="2">一位先知</td>
<td ALIGN="center" COLSPAN="2">多位國王</td>
<td ALIGN="center" COLSPAN="2">一個國王</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="3">一個國王</td>
<td ALIGN="center" COLSPAN="3">多個國王</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center" COLSPAN="3">以色列</td>
<td ALIGN="center" COLSPAN="3">猶大</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="3">約一百三十年</td>
<td ALIGN="center" COLSPAN="3">約一百五十五年</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
