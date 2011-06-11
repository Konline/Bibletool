<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('outline', array( 'body' => '

<h1 ALIGN="center">耶利米書簡介</h1>
<p>
耶利米書是舊約聖經中的第二十四卷經書，是五卷大先知書中的第二卷，雖是被列在被擄以前的先知書中，可是在內容上也廷伸到被擄期中。</p>
<p>當時的猶大國日趨沒落，外有強鄰如亞述、埃及和巴比倫等國，虎視眈眈隨時找機會進行侵略；國內情形，上自君王、首領，下至百姓，都離棄
神拜偶像，道德低落；約西亞王年間，雖有一次復興，可惜為期甚短，到了約哈斯、約雅敬、約雅斤、西底家四王的年間，又行耶和華眼中看為惡的事。這就是先知耶利米時所處的背景，在這樣的情形下，耶利米盡了他話語的職事。</p>
<p>
「耶利米」這名字的意義有二：一是耶和華使之升高；二是耶和華使之傾倒。他的一生就是見證他那名字的含意。先知為本國的民天天流淚、哭泣，耶利米書可謂是用眼淚寫成的書，故稱為流淚的先知。他是祭司希勒家的兒子，生長在亞拿突城。他在母腹中就被聖靈揀選，他的一生也因著工作和見證的關係，一生都沒有結婚，因為　神對他說：「你在這地方不可娶妻、生兒養女」(耶16:2)他順從
神的話，使他毫無牽掛地專心服事主；他這一順從給他帶來了極大的祝福，使他在舊約時代成為　神所重用的僕人。</p>
<hr>
<h1 ALIGN="center">耶利米書大綱</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td>一、 先知的蒙召與受命</td>
<td>1 章</td>
</tr>
<tr>
<td>二、 論猶大的罪惡與未來的審判</td>
<td>2-20 章</td>
</tr>
<tr>
<td>三、 論西底家王的前途、抨擊假先知</td>
<td>21-23 章</td>
</tr>
<tr>
<td>四、 兩筐無花果的表象</td>
<td>24 章</td>
</tr>
<tr>
<td>五、 論猶大國的被侵與被擄</td>
<td>25:1-25:14</td>
</tr>
<tr>
<td>六、 概述其他國家的前途</td>
<td>25:15-25:38</td>
</tr>
<tr>
<td>七、 耶利米受難</td>
<td>26-29 章</td>
</tr>
<tr>
<td>八、 論希望之福與彌賽亞的預言</td>
<td>30-35 章</td>
</tr>
<tr>
<td>九、 附錄</td>
<td>52 章</td>
</tr>
</table>
<hr>
<h1 ALIGN="center">耶利米書表解</h1>
<table ALIGN="center" BORDER="1">
<tr>
<td ALIGN="center">重點</td>
<td ALIGN="center" COLSPAN="2">耶利米</td>
<td ALIGN="center" COLSPAN="3">猶大與諸國</td>
<td ALIGN="center" COLSPAN="2">耶路撒冷</td>
</tr>
<tr>
<td ALIGN="center">分段</td>
<td ALIGN="center">
<p>先知的呼召</p>
<p>1-2</p>
</td>
<td ALIGN="center">
<p>先知的指責</p>
<p>2-25</p>
</td>
<td ALIGN="center">
<p>先知的爭論</p>
<p>26-29</p>
</td>
<td ALIGN="center">
<p>先知的安慰</p>
<p>30-33</p>
</td>
<td ALIGN="center">
<p>先知的景況</p>
<p>34-45</p>
</td>
<td ALIGN="center">
<p>九王的罪狀</p>
<p>46-51</p>
</td>
<td ALIGN="center">
<p>聖城的陷落</p>
<p>52</p>
</td>
</tr>
<tr>
<td ALIGN="center" ROWSPAN="2">主題</td>
<td ALIGN="center" COLSPAN="2">序言</td>
<td ALIGN="center" COLSPAN="3">先知的徵兆與講道</td>
<td ALIGN="center" COLSPAN="2">後記</td>
</tr>
<tr>
<td ALIGN="center" COLSPAN="4">對猶太人的預言</td>
<td ALIGN="center" COLSPAN="3">對外邦人的預言</td>
</tr>
<tr>
<td ALIGN="center">地點</td>
<td ALIGN="center" COLSPAN="5">猶大全地</td>
<td ALIGN="center" COLSPAN="2">巴比倫</td>
</tr>
<tr>
<td ALIGN="center">時間</td>
<td ALIGN="center" COLSPAN="7">約 40 年</td>
</tr>
</table>

'));
                                                                     
$smarty->display('outline.tpl');

?>
