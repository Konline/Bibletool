<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">瑪拉基書簡介</h1>
<p>
瑪拉基書是全部聖經中第三十九卷書，也是舊約中最後一卷書，瑪拉基書是主前五世紀耶路撒冷聖城重建後寫成的；瑪拉基是神的先知，其名字的義意為「神的使者」，在書中通過對話的形式，向百姓宣告了神的責備和應許。當時神的子民生活腐化，對於敬拜的事也很疏忽。祭司和百姓都欺騙　神，不將應奉獻給神的禮物交上，也不依照神的教訓生活。在此時　神差先知瑪拉基宣告神的信息，要祭司和百姓悔改重新歸向　神，信守跟　神所立的約，免得祂來咒詛遍地(瑪4:6)。</p>
<hr>
<h1 ALIGN="center">瑪拉基書大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 序介</td>
<td>1:1</td>
</tr>
<tr>
<td>二、 呼喚：神對以色列人的慈愛</td>
<td>1:2-1:5</td>
</tr>
<tr>
<td>三、 斥責祭司</td>
<td>1:6-1:5</td>
</tr>
<tr>
<td>四、 斥責百姓</td>
<td>2:10-4:3</td>
</tr>
<tr>
<td>五、 勸民回轉,應許救恩</td>
<td>4:4-4:6</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">瑪拉基書大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">第 1 章</td>
<td ALIGN="center">第 2 章</td>
<td ALIGN="center">第 3 章</td>
<td ALIGN="center">第 4 章</td>
</tr>
<tr>
<td ALIGN="center">不忠的祭司</td>
<td ALIGN="center">不信的百姓</td>
<td ALIGN="center">潔淨神子民</td>
<td ALIGN="center">興起神子民</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="2">關係破損</td>
<td ALIGN="center" COLSPAN="2">關係修復</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
