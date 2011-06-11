<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">但 以 理 書 簡 介</h1>
<p>
但以理書是全部聖經中第二十七卷書，但以理書是猶太人處在一個殘暴的異教國王迫害下忍受苦難的時期寫成的。但以理用所見異象鼓勵當代的人民，告訴他們　神將要打擊暴君的統治，恢復祂子民的主權。</p>
<p>但以理書可分兩部：</p>
<p>一、關於但以理和他同伴被擄之經過；他們怎樣藉對　神信心和順服勝過了敵人。</p>
<p>二、但以理將所看見的異象，以象徵性的事物表示巴比倫以及一些帝國的興衰，同時預言異教壓迫者的沒落和　神子民的得勝。</p>
<hr>
<h1 ALIGN="center">但 以 理 書 大 綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 但以理和三友的經歷</td>
<td>1:1-6:28</td>
</tr>
<tr>
<td>1.被選入宮</td>
<td>1:1-1:21</td>
</tr>
<tr>
<td>2.為巴比倫王解第一夢</td>
<td>2:1-2:49</td>
</tr>
<tr>
<td>3.三友拒拜金像</td>
<td>3:1-3:30</td>
</tr>
<tr>
<td>4.為巴比倫王解第二夢</td>
<td>4:1-4:37</td>
</tr>
<tr>
<td>5.解開粉牆文字</td>
<td>5:1-5:31</td>
</tr>
<tr>
<td>6.但以理在獅子坑中</td>
<td>6:1-6:28</td>
</tr>
<tr>
<td>二、 但以理見異象</td>
<td>7:1-12:13</td>
</tr>
<tr>
<td>1.四獸</td>
<td>7:1-7:28</td>
</tr>
<tr>
<td>2.綿羊與山羊</td>
<td>8:1-8:27</td>
</tr>
<tr>
<td>3.七十個七</td>
<td>9:1-9:27</td>
</tr>
<tr>
<td>4.南王與北王</td>
<td>10:1-12:13</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">但 以 理 書 表 解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center" COLSPAN="2">解夢的但以理</td>
<td ALIGN="center" COLSPAN="2">作夢的但以理</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">
<p>尼布甲尼撒的夢</p>
<p>1-3</p>
</td>
<td ALIGN="center">
<p>但以理的信心</p>
<p>4-6</p>
</td>
<td ALIGN="center">
<p>但以理的異象</p>
<p>7-9</p>
</td>
<td ALIGN="center">
<p>以色列的未來</p>
<p>10-12</p>
</td>
</tr>
<tr>
<td ALIGN="center" ROWSPAN="2">主題</td>
<td ALIGN="center" COLSPAN="2">神對外邦人計劃</td>
<td ALIGN="center" COLSPAN="2">神對外邦人計劃</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="2">歷史的洐z</td>
<td ALIGN="center" COLSPAN="2">異象的啟示</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center" COLSPAN="4">巴比倫 / 波斯</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="4">約 70 年(主前 605-536 年)</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
