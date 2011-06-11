<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">約拿書簡介</h1>
<p>
約拿書是全部聖經中第三十二卷書，在寫作體裁上約拿書與其他先知書不同，是用傳記體敘述方式，記錄一個人怎樣奉　神差遣，向當日亞述大城尼尼微宣佈神的刑罰，促人悔改，遠離惡行。</p>
<p>
這個人就是約拿，是一位不聽命的先命，要經過一番與風暴和死亡掙扎，和　神奇妙的拯救，才負起責任向自己不喜歡但　神卻愛惜的異教亞述人宣講。可是由於他狹隘的排外心裏作祟，雖所傳的信息收到空前的效果，約拿反而不悅，寧死也不願見以色列的敵人得救。</p>
<p>
神使用環境來教導約拿，使他明白神的大愛廣被祂所造的全人類，連牲畜祂都看顧。祂願把真光照耀一切的人，不分種族、膚色和文化。約拿生活在主前八世紀亞述帝國全盛時期。新約福音提到「約拿的神蹟」，主耶穌且當它作自己復活的預表。</p>
<hr>
<h1 ALIGN="center">約拿書大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 約拿奉差, 拒不順服　　　　　</td>
<td>1:1-1:17</td>
</tr>
<tr>
<td>二、 約約悔悟, 獲神拯救</td>
<td>2:1-2:10</td>
</tr>
<tr>
<td>三、 約拿傳講, 尼尼微人悔改</td>
<td>3:1-3:10</td>
</tr>
<tr>
<td>四、 約拿獲神教愛全人類</td>
<td>4:1-4:11</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">約拿書表解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">第 1 章</td>
<td ALIGN="center">第 2 章</td>
<td ALIGN="center">第 3 章</td>
<td ALIGN="center">第 4 章</td>
</tr>
<tr>
<td ALIGN="center">約拿的叛逆</td>
<td ALIGN="center">約拿的困境</td>
<td ALIGN="center">約拿的宣告</td>
<td ALIGN="center">約拿的不悅</td>
</tr>
<tr>
<td ALIGN="center">在船上</td>
<td ALIGN="center">魚腹中</td>
<td ALIGN="center">在城</td>
<td ALIGN="center">日光下</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
