<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第六段  受難前一週之事蹟</h2>
<hr>

<p><a href="SEC6-01.php">第一章  四月二日騎驢進京</a>
<p><a href="SEC6-02.php">第二章  在耶路撒冷的講論</a>
<p><a href="SEC6-03.php">第三章  耶穌論祂的權柄</a>
<p><a href="SEC6-04.php">第四章  耶穌論將要來的事</a>
<p><a href="SEC6-05.php">第五章  豫言受害</a>
<p><a href="SEC6-06.php">第六章  逾越節最後的晚餐</a>
<p><a href="SEC6-07.php">第七章  最後的講論與代禱</a>
<p><a href="SEC6-08.php">第八章  在客西馬尼園</a>
<p><a href="SEC6-09.php">第九章  被捉受審</a>
<p><a href="SEC6-10.php">第十章  被棄絕並受凌辱 </a>
<p><a href="SEC6-11.php">第十一章  各各他的十字架 </a>
<p><a href="SEC6-12.php">第十二章  十架七言</a>
<p><a href="SEC6-13.php">第十三章  斷氣前的光景</a>
<p><a href="SEC6-14.php">第十四章  被安葬</a>

<hr>

'));

$smarty->display('gospel.tpl');
