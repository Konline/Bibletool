<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第捌段附錄</h2>
<h3 class=gospel>附錄 B. 耶穌所講的比喻表</h3>
<hr>
<p>
在主耶穌的教訓中，講過許多比喻；其中馬太
福音記載了二十三件，馬可福音九件，路加福音十
三件，約翰福音無記載，在四福音書中，記載了主
耶穌所講的四十件比喻。
<p>
所講的比喻大致可分為自然生物、自然事務、
主僕關係和一般人事四類。
</p>
<hr>
<table class=gospel border=0>
<tr class=gospel>
	<td class=gospel>
	<OL>
	 <li><a href="SEC8B01.html"&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79>自然生物─8件</a></li>
	 <li><a href="SEC8B02.html"&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79>自然事物─8件</a></li>
	 <li><a href="SEC8B03.html"&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79>主僕關係─12件</a></li>
	 <li><a href="SEC8B04.html"&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79>一般人事─12件</a></li>
	</ol>
	</td>
</tr>
</table>
<hr>

'));

$smarty->display('gospel.tpl');
