<?php

require_once 'Action_Base.php';

/**
 * Returns an HTML page with Opengraph tags
 * and redirects user back to the right landing page that contains Ajax calls.
 */
class Action_Opengraph extends Action_Base
{
	public function __construct($bible, $smarty, $action)
	{
		parent::__construct($bible, $smarty);
		$this->cacheable = false;
        $this->action = $action;
	}

	/**
	 * Return verses in JSON format
	 */
	public function process()
	{
		$request_uri = $_SERVER["REQUEST_URI"];
		$new_location = str_replace("/$this->action/", "$this->action/#", $request_uri);
		$this->smarty->assign("new_location", "http://bibletool.konline.org/$new_location");
		$this->smarty->assign("og_url", "http://bibletool.konline.org{$request_uri}");
		$range = $this->bible->parseBibleRange($_GET["jsonURL"]);
		if ($range)
		{
			list($languages, $book, $chapter, $start, $end) = $range;
			$language = $languages[0];
			$book_names = $this->bible->getBookNames($language, $book);
			$chapter_title = $this->bible->getChapterTitle($language, $book, $chapter);
			$verses = $this->bible->getVerses($language, $book, $chapter, $start, $end);
			$title = "耶大雅聖經工具：" . $book_names['long_name'] . $chapter . ":" . $start . "﹣" . $chapter_title;
			$this->smarty->assign("og_title", $title);
			$snippet = "";
			foreach ($verses as $verse)
			{
				$snippet .= strip_tags($verse["content"]);
				if (mb_strlen($snippet, "UTF-8") > 80)
				{
					break;
				}
			}
			$this->smarty->assign("og_description", $snippet);
		}
		else
		{
			$this->smarty->assign("og_title", "耶大雅聖經工具");
			$this->smarty->assign("og_description", "Jedaiah Bibletool by Alber Ko");
		}
		$this->smarty->assign("og_image", "http://bibletool.konline.org/images/logo_square.jpg");
		$is_facebook = (strpos($_SERVER["HTTP_USER_AGENT"], "facebookexternalhit") !== FALSE);
		$this->smarty->assign("is_facebook", $is_facebook);
		$this->smarty->display('opengraph.tmpl');
	}
}
