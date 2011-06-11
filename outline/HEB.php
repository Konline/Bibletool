<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">希伯來書簡介</h1>
<p>
希伯來書是聖經中的第五十八卷經書，是新約中的第十九卷。書中未署名作者，是寫給一群面臨困難的信徒的書信。當時這些信徒受到很大逼迫，有回到舊有信仰的危機，作者為要堅固他們的信心，鄭重地向他們指出耶穌基督是　神最真確、最完整的啟示。希伯來書中所強調的有三方面：</p>
<p>一、耶穌是 神永恆兒子；祂忍受一切苦難，始終順服父神的旨意。作為神的兒子，耶穌的地位比舊約的嵽知高，也比天使和摩西高。</p>
<p>二、神立耶穌作永遠的祭司，高過舊約的祭司們。</p>
<p>三、信徒藉著耶穌從罪惡、恐懼和死亡中被拯救出來。</p>
<p>
作為大祭司的耶穌給人真的拯救；祂在天上聖所獻上的祭遠超過猶太教禮儀的牲祭。作者教導我們學習信心的功課，列舉了古代許多難偉信心的榜樣，勸勉信徒要堅守信仰；始終仰望耶穌，忍受各種可能臨到他們身上的各種災害和迫害。最後用勸勉和警告的話作結束。</p>
<hr>
<h1 ALIGN="center">希伯來書大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 耶穌基督比天使更美</td>
<td>1:1-2:18</td>
</tr>
<tr>
<td>二、 耶穌基督比聖僕更美</td>
<td>3:1-4:13</td>
</tr>
<tr>
<td>三、 耶穌基督為更美的祭司</td>
<td>4:14-7:28</td>
</tr>
<tr>
<td>四、 耶穌基督為更美的約</td>
<td>8:1-9:22</td>
</tr>
<tr>
<td>五、 耶穌基督為更美的獻祭</td>
<td>9:23-10:39</td>
</tr>
<tr>
<td>六、 信心是更美的道路</td>
<td>13:1-13:25</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">希 伯 來 書 表 解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center" COLSPAN="2">超越的人</td>
<td ALIGN="center" COLSPAN="2">超越的祭司</td>
<td ALIGN="center">超越的能力</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">
<p>基督與天使</p>
<p>1-2</p>
</td>
<td ALIGN="center">
<p>基督與古代領袖</p>
<p>3-4</p>
</td>
<td ALIGN="center">
<p>基督與亞倫的祭司職分</p>
<p>5-7</p>
</td>
<td ALIGN="center">
<p>基督與古代律法</p>
<p>8-10</p>
</td>
<td ALIGN="center">
<p>基督與生活應用</p>
<p>11-13</p>
</td>
</tr>
<tr>
<td ALIGN="center" ROWSPAN="2">主題</td>
<td ALIGN="center" COLSPAN="2">基督─更好的道路</td>
<td ALIGN="center" COLSPAN="2">基督─惟一的道路</td>
<td ALIGN="center" COLSPAN="2">基督─信實的道路</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="2">超越</td>
<td ALIGN="center" COLSPAN="2">犧牲</td>
<td ALIGN="center" COLSPAN="2">能力</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center" COLSPAN="5">給散居的猶太信徒</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="5">約主後 64-68 年間</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
