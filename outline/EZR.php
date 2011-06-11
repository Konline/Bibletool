<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">以斯拉記簡介</h1>
<p>以斯拉記是聖經中的第十五卷經書，也是舊約歷史書中的第十卷。本卷書也是
神的子民被擄以後的歷史書中的第一卷。聖經中被擄以後的書卷共有八卷：以斯拉記、尼希米記、以斯帖記、以西結書、但以理書、哈該書、撒迦利亞書和瑪拉基書；前三卷是被擄前的歷史書，後五卷是被擄後的先知書。</p>
<p>本卷書記載，　神的選民因著  神的恩典和安排(斯1:2-3),
從被擄之地歸回故國。他們在被擄中曾學到嚴厲的功課，就是棄絕偶像，因拜偶像是他們亡國的最主要原因。在被擄中，懷念故土；在被擄的七十年中，他們少有機會認識　神、明白　神的律法書，也有子民與外邦人通婚者，在回歸時期，以斯拉的職事就是重建聖殿，使歸回的子民能再次回到　神的面前，認識祂，事奉祂，並且誦讀祂的律法書，他也堅決反對百姓娶外邦女子為妻，也有多人聽其勸而休其所娶之外邦妻。</p>
<hr>
<h1 ALIGN="center">以斯拉記大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 猶太人離巴比倫返耶路撒冷</td>
<td>1:1-2:70</td>
</tr>
<tr>
<td>二、 重建耶路撒冷和聖殿</td>
<td>3:6-6:22</td>
</tr>
<tr>
<td>三、 以斯拉返國：改革開始</td>
<td>7:1-10:44</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">以斯拉記表解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center" COLSPAN="2">重建聖殿</td>
<td ALIGN="center" ROWSPAN="4">
<p>空</p>
<p>白</p>
<p>期</p>
</td>
<td ALIGN="center" COLSPAN="2">重建百姓</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">
<p>建殿的使命</p>
<p>1-3</p>
</td>
<td ALIGN="center">
<p>聖殿的完工</p>
<p>4-6</p>
</td>
<td ALIGN="center">
<p>祭司與信徒</p>
<p>7-8</p>
</td>
<td ALIGN="center">
<p>污染與潔淨</p>
<p>9-10</p>
</td>
</tr>
<tr>
<td ALIGN="center" ROWSPAN="2">主題</td>
<td ALIGN="center" COLSPAN="2">所羅巴伯率領返鄉</td>
<td ALIGN="center" COLSPAN="2">以斯拉率領返鄉</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="2">聖殿恢復</td>
<td ALIGN="center" COLSPAN="2">靈命復甦</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center" COLSPAN="5">波斯至耶路撒冷</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="2">23年(主前538-515)</td>
<td ALIGN="center">58 年</td>
<td ALIGN="center" COLSPAN="2">1年(主前457年)</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
