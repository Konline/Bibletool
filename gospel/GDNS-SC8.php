<?php

require(dirname(__FILE__).'/'.'../smarty.config.php');

$smarty->assign('header', array('root' => '..'));
$smarty->assign('gospel', array( 'body' => '

<h1 class=gospel>四福音書綜合 -- 主耶穌基督微行錄</h1>
<h2 class=gospel>第八段 附錄</h2>
<hr>

<p><a href="SEC8-A.php">附錄A.主耶穌所行的神蹟</a>
<p><a href="SEC8-B.php">附錄B.主耶穌所講的比喻</a>

<hr>

'));

$smarty->display('gospel.tpl');
