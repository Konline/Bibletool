<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">馬可福音簡介</h1>
<p>馬可福音是全部聖經中第四十一卷書，也是新約中第二卷書，是四福音書的第二本。馬可福音描述是耶穌是
神的僕人，因此沒有記下祂的家譜，也沒有記祂的出生和童年生活，用有力的手筆記述耶穌的事跡，把重心放在祂的工作方面，而不是祂的言論教訓。</p>
<p>
祂的工作從受洗開始、受魔鬼試探、召門徒傳道直到祂受死釘十字架，最後從死裡復活。雖說耶穌來世的目是要服事人類，但馬可也特別強調祂是　神的兒子，但也沒有忽略祂人性的一面。</p>
<hr>
<h1 ALIGN="center">馬可福音大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 耶穌傳道工作的預備</td>
<td>1:1-1:13</td>
</tr>
<tr>
<td>二、 耶穌在加利利的工作</td>
<td>1:14-6:56</td>
</tr>
<tr>
<td>三、 耶穌離開加利利地</td>
<td>7:1-9:50</td>
</tr>
<tr>
<td>四、 耶穌在比利亞的工作</td>
<td>10:1-10:52</td>
</tr>
<tr>
<td>五、 耶穌在耶路撒冷的工作</td>
<td>11:1-13:37</td>
</tr>
<tr>
<td>六、 耶穌的受死與復活</td>
<td>14:1-16:20</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">馬可福音表解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center" COLSPAN="3">僕 人 的 事 奉</td>
<td ALIGN="center" COLSPAN="2">僕 人 的 犧 牲</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">
<p>僕人的來臨</p>
<p>1-3</p>
</td>
<td ALIGN="center">
<p>僕人的表現</p>
<p>4-7</p>
</td>
<td ALIGN="center">
<p>僕人的任務</p>
<p>8-10</p>
</td>
<td ALIGN="center">
<p>僕人的最後一週</p>
<p>11-13</p>
</td>
<td ALIGN="center">
<p>僕人完成的工作</p>
<p>14-16</p>
</td>
</tr>
<tr>
<td ALIGN="center" ROWSPAN="2">主題</td>
<td ALIGN="center" COLSPAN="3">講道與神蹟</td>
<td ALIGN="center" COLSPAN="2">受死與受難</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="2">三年</td>
<td ALIGN="center">半年</td>
<td ALIGN="center" COLSPAN="2">八天</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center" COLSPAN="3">加利利與比利亞</td>
<td ALIGN="center" COLSPAN="2">猶大與耶路撒冷</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="5">主後 29 至 33 年</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
