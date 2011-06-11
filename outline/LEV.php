<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">利未記簡介</h1>
<p>利未記是聖經中的第三卷經書，原名為「神的呼召」，後因書中多記利未支派中事奉  神之條列，因而改名利未記。利未記與出埃及記的關係非常密切，在出埃及記中記載救贖的事，為被贖的子民在聖潔上、敬拜上和服事上，立下根基；利未記乃是詳細講解那些子民的生活、敬拜並服事　神的事。出埃及記是　神在山上說話，禁止人前往；但在利未記中　神乃在會幕中說話，也藉著會幕住在祂的子民中。</p>
<p>「因為　神是聖潔的，所以親近祂也必須是聖潔的」(利 11:44-45;來 12:14)。可是人是有罪的、不潔的，如何能親近　神?　神就在這卷書中解決這個問題：蒙救贖的人必須靠獻祭和血，由祭司代為贖罪，並作一個聖潔的人，這樣才可以親近　神，敬拜　神。</p>
<p>利未記共分五大段：(1) 祭和獻祭的條例；(2) 事奉的條例；(3) 聖潔的子民；(4) 耶和華的節期；(5) 蒙福之道。</p>
<hr>
<h1 ALIGN="center">利未記大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 獻祭條例</td>
<td>1:1-7:38</td>
</tr>
<tr>
<td>二、 事奉條例</td>
<td>8:1-10:20</td>
</tr>
<tr>
<td>三、 潔淨條例</td>
<td>11:1-15:33</td>
</tr>
<tr>
<td>四、 贖罪日</td>
<td>16:1-16:34</td>
</tr>
<tr>
<td>五、 聖潔子民</td>
<td>17:1-22:33</td>
</tr>
<tr>
<td>六、 耶和華的節期</td>
<td>23:1-25:55</td>
</tr>
<tr>
<td>七、 蒙福之道</td>
<td>26:1-27:34</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">利未記表解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center" COLSPAN="3">獻 祭</td>
<td ALIGN="center" COLSPAN="4">聖 潔</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">
<p>自動的奉獻</p>
<p>1-3</p>
</td>
<td ALIGN="center">
<p>義務的奉獻</p>
<p>4-7</p>
</td>
<td ALIGN="center">
<p>祭司的命令</p>
<p>8-10</p>
</td>
<td ALIGN="center">
<p>個人的潔淨</p>
<p>11-15</p>
</td>
<td ALIGN="center">
<p>全國的潔淨</p>
<p>16-20</p>
</td>
<td ALIGN="center">
<p>祭司的潔淨</p>
<p>21-23</p>
</td>
<td ALIGN="center">
<p>未來的潔淨</p>
<p>24-37</p>
</td>
</tr>
<tr>
<td ALIGN="center" ROWSPAN="2">主題</td>
<td ALIGN="center" COLSPAN="4">藉著獻祭到 神面前來</td>
<td ALIGN="center" COLSPAN="3">藉著順服到 神面前來</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="4">祭司</td>
<td ALIGN="center" COLSPAN="3">節期</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center" COLSPAN="7">西乃山</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="7">大約一個月</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
