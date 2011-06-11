<?php

require_once 'Smarty/Smarty.class.php';

class Bible_Smarty extends Smarty
{
	function __construct($config)
	{
		$c = $config->smarty;
		$root = dirname(__FILE__) . '/..';
		$this->setTemplateDir("{$root}/{$c->templates_dir}");
		$this->setCompileDir("{$root}/{$c->compiler_dir}");
		$this->setCacheDir("{$root}/{$c->cache_dir}");
		$this->setConfigDir("${root}/{$c->config_dir}");
		$this->assign('webroot', $c->webroot);
	}
}
