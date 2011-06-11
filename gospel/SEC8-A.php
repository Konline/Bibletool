<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第捌段附錄</h2>
<h3 class=gospel>附錄 A. 耶穌所行的神蹟表</h3>
<hr>
<p>耶穌曾行過無數的神蹟奇事。馬太福音記載了 二十件，馬可福音記載了十七件，路加福音記載了 二十件，約翰福音祗記載了十件，在四本福音書中 主耶穌共行了三十五件神蹟。
<p>神蹟大致可分醫治疾病、趕逐污鬼、自然聽命 和死人復活四類。</p>
<hr>
<table class=gospel border=0>
<tr class=gospel>
	<td class=gospel>
	<ol>
	<li><a href="SEC8A01.html"&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79>醫治疾病─17件</a></li>
	<li><a href="SEC8A02.html"&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79>趕逐污鬼─6件</a></li>
	 <li><a href="SEC8A03.html"&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79>自然聽命─9件</a></li>
	 <li><a href="SEC8A04.html"&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79&LABEL=%ac%f9%bf%ab%aa%ba%b5%b2%bb%79>死人復活─3件</a></li>
	</ol>
	</td>
</tr>
</table>
<hr>

'));

$smarty->display('gospel.tpl');
