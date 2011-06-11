<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">士師記簡介</h1>
<p>
士師記是聖經中的第七卷經書，也是舊約歷史書中的第二卷。自從約書亞死後，一直到掃羅作王止，這段時期可稱為士師時期。也是以色列人陷入宗教、道德上的黑暗混亂時期。</p>
<p>在這段時期內，以色列人因為不能驅盡滅盡留在迦南地的七族，必然的結果是：漸漸離棄 神，隨從外邦的風俗，與外邦人通婚，又拜別神。所以
神照之前多次之警告的話，把他們交在外邦人手中。可是他們一有悔改，神就俯允他們的禱告，藉著士師拯救他們，幾乎這是本卷書中特有的公式：離棄
神被交於外邦人的手、悔改、拯救再離棄神。這樣循環地重複有七次之多。</p>
<p>
士師記中共提了十三位士師：俄陀聶(3:9)、以笏(3:15)、珊迦(3:31)、底波拉(4:4)、巴拉(4:6)、基甸(6:12)、陀拉(10:2)、睚珥(10:3)、耶弗他(12:7)、以比讚(12:8)、以倫(12:11)、押頓(12:4)和參孫(15:20)。</p>
<hr>
<h1 ALIGN="center">士師記簡介</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 引言：歷史背景</td>
<td>1:1-3:6</td>
</tr>
<tr>
<td>二、 以色列人犯罪、悔改與蒙拯救</td>
<td>3:7-16:31</td>
</tr>
<tr>
<td>三、 士師時代的社會</td>
<td>17:1-21:25</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">士師記表解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center">過去</td>
<td ALIGN="center" COLSPAN="4">奴役與拯救</td>
<td ALIGN="center">腐敗</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">
<p>過度與簡介</p>
<p>1-2</p>
</td>
<td ALIGN="center">
<p>五個士師</p>
<p>3-7</p>
</td>
<td ALIGN="center">
<p>基甸</p>
<p>6-8</p>
</td>
<td ALIGN="center">
<p>六個士師</p>
<p>9-12</p>
</td>
<td ALIGN="center">
<p>參孫</p>
<p>13-16</p>
</td>
<td ALIGN="center">
<p>偶像崇拜與道德混亂</p>
<p>17-21</p>
</td>
</tr>
<tr>
<td ALIGN="center" ROWSPAN="2">主題</td>
<td ALIGN="center">序幕</td>
<td ALIGN="center" COLSPAN="4">敘事</td>
<td ALIGN="center">尾聲</td>
</tr>
<tr>
<td ALIGN="center">循環原因</td>
<td ALIGN="center" COLSPAN="4">循環原因</td>
<td ALIGN="center">循環原因</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center" COLSPAN="6">迦南與約旦河以東</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="6">大約三百五十年</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
