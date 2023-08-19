<?php

require_once 'Action_Base.php';

/**
 * Process contact us form
 */
class Action_ContactUs extends Action_Base
{
	const SENDER = 'koyao@konline.org';
	const RECIPIENT = 'webmaster@konline.org';
	const SUBJECT = 'Feedback from Bibletool';

	public function __construct($bible, $smarty)
	{
		parent::__construct($bible, $smarty);
		$this->cacheable = true;
		$this->cache_file = __FILE__;
	}

	public function process()
	{
		$posting = $_REQUEST['posting'];
		if (!isset($posting))
		{
			// Display Contact Us form
			$this->smarty->display('contactus.tmpl');
			return;
		}

		// Handle data posted to the form
		$name = $_POST['name'];
		$email = $_POST['email'];
		$category = $_POST['category'];
		$body = $_POST['body'];

		if (empty($name) || empty($email) || empty($category) || empty($body))
		{
			$this->smarty->assign('error_message', '必要項目不可空白！');
			$this->smarty->assign('name', $name);
			$this->smarty->assign('email', $email);
			$this->smarty->assign('body', $body);
			$this->smarty->display('contactus.tmpl');
			return;
		}

		$message = "Message from: $name ($email)\n\nCategory: $category\n\nBody:\n\n$body\n\n";
		$headers = "From: " . self::SENDER . "\r\n" .
			"Content-Transfer-Encoding: 8bit" . "\r\n" .
			"Content-Type: text/plain; charset=UTF-8" . "\r\n";

		$this->smarty->display('contactus_thankyou.tmpl');

		mail(self::RECIPIENT, self::SUBJECT, $message, $headers);
	}
}
