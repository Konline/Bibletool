<?php

require_once 'Action_Base.php';

/** Process contact us form
 */
class Action_ContactUs extends Action_Base
{
	const SENDER = 'webmaster@konline.org';
	const RECIPIENT = 'yaoyao@gmail.com,kojung@gmail.com';
	const SUBJECT = 'Feedback from Bibletool';

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

		$message = "Message from: $name\nCategory: $category\nBody: $body\n\n";
		$headers = "From: " . self::SENDER . "\r\n";

		$this->smarty->display('contactus_thankyou.tmpl');

		mail(self::RECIPIENT, self::SUBJECT, $message, $headers);
	}
}
