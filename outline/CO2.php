<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">哥林多後書簡介</h1>
<p>
哥林多後書是聖經中的第四十七卷經書，是新約中的第八卷。是保羅寫給哥林多教會的第二卷書信。當哥林多前書送出後，哥林多教會的情況未見轉好反轉趨惡劣；甚至有人責疑他使徒的權柄，懷疑他籌款救濟耶路撒冷教會聖徒的動機，更有人冒使徒之名傳虛假的道理。雖保羅屢遭攻擊，但保羅始終盼望與他們和解。</p>
<p>
本卷書前部保羅討論他和哥林多教會信徒的關係，並說明為何用嚴厲的態度責備那些反對他的人；並為他使徒的身份辯正，也顯出他為使徒的證據。書中也確立了奉獻的原則─必須捐得樂意，不可勉強。</p>
<p>身為信徒的我們，在奔跑天路的過程中，也難免會遭遇到與保羅相似狀況，我們可學保羅，從主的恩典中支取能力。</p>
<hr>
<h1 ALIGN="center">哥 林 多 後 書 大 綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 解釋與分辯</td>
<td>1:1-2:13</td>
</tr>
<tr>
<td>二、 使徒的職分</td>
<td>2:14-7:1</td>
</tr>
<tr>
<td>三、 互信的恢復</td>
<td>7:2-7:16</td>
</tr>
<tr>
<td>四、 為耶城信徒收集捐項</td>
<td>8:1-9:15</td>
</tr>
<tr>
<td>五、 使徒的證據</td>
<td>10:1-13:14</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">哥 林 多 後 書 表 解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center">安慰</td>
<td ALIGN="center">勸誡</td>
<td ALIGN="center">辯解</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">保羅福音的大使</td>
<td ALIGN="center">保羅福音的動機</td>
<td ALIGN="center">福音大使的權柄</td>
</tr>
<tr>
<td ALIGN="center" ROWSPAN="2">主題</td>
<td ALIGN="center">個性</td>
<td ALIGN="center">幕捐</td>
<td ALIGN="center">證明</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="2">悔改的多數人</td>
<td ALIGN="center">悖逆的少數人</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center" COLSPAN="3">寫於馬其頓</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="3">主後 56 年</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
