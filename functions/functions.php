<?php
session_start();
date_default_timezone_set('Europe/London');

define('DOMAIN',           'https://homeloansaustralia.com');
#define('SITE_URL',         'http://www.'.DOMAIN.'/');
define('SITE_URL',         'http://' . $_SERVER['HTTP_HOST'] . '/');
define('COMPANY_NAME',     'Home Loans Australia');

define('CONTACT_ADDRESS',  '724-728 George St, Sydney, New South Wales 2000');
define('CONTACT_EMAIL',    'testimonials@' . DOMAIN);
define('CONTACT_PHONE',    '1300 190 429');
define('HELP_CENTER',    'HELP CENTER. (8AM-7PM MON-FRI)');
define('CONTACT_PHONE_2',  '');
define('CONTACT_PHONE_3',  '');

define('SOCIAL_FACEBOOK',  'https://www.facebook.com/homeloansaustralia');
define('SOCIAL_TWITTER',   'https://twitter.com/homeloansaustralia');

$aErrors   = array();
$aFormVals = array();

define('MAIL_FROM', CONTACT_EMAIL);
define('MAIL_TO',   CONTACT_EMAIL);
#define('MAIL_TO',   'luke@innuo.co.uk');
define('MAIL_CC',   false);
define('MAIL_BCC',  'homeloansaustralia@homeloansaustralia.com');

$currpage = ltrim($_SERVER['SCRIPT_NAME'], "/");

//Process forms if required
if (isset($_POST) && is_array($_POST)) {
	if (isset($_POST['form_submit']) && $_POST['form_submit'] != '') {
		switch ($_POST['form_submit']) {
			case "contact_form":

				//Grab form info
				$name    = isset($_POST['name'])    && $_POST['name']    != '' ? $_POST['name']    : false;
				$email   = isset($_POST['email'])   && $_POST['email']   != '' ? $_POST['email']   : false;
				$phone   = isset($_POST['phone'])   && $_POST['phone']   != '' ? $_POST['phone']   : false;
				$message = isset($_POST['message']) && $_POST['message'] != '' ? $_POST['message'] : false;

				//Validate form info
				if ($name    === false) { $aErrors['name']    = 'Please enter your name.'; }
				if ($email   === false) { $aErrors['email']   = 'Please enter your email address.'; }
				if ($message === false) { $aErrors['message'] = 'Please tell us about your enquiry.'; }

				if (!isset($aErrors['email']) &&
					(substr_count($email, '@') !== 1 || strrpos($email, '.') === false || strpos($email, '@') > strrpos($email, '.'))) {
					$aErrors['email'] = 'Please enter a valid email address';
				}

				if (count($aErrors) == 0) {

					$sMailSubject = COMPANY_NAME . " Website - Enquiry";
					$sMailBody    = "Hello,<br><br>".
									"The following information has been submitted via the " . COMPANY_NAME . " website:<br><br>".
									"<strong>Name</strong>: ".$name."<br>".
									"<strong>Telephone</strong>: ".$phone."<br>".
									"<strong>Email</strong>: ".$email."<br>".
									"<strong>Message</strong>:<br>".nl2br($message)."<br><br>".
									"Thank you,<br>".
									COMPANY_NAME . " Website.";

					sendEmail($sMailSubject, $sMailBody);

					$_SESSION['msgsent'] = 'sent';
					header('location: contact.php');
					die();

				}

			break;

		}

		$aFormVals[$_POST['form_submit']] = $_POST;
		$aFormVals[$_POST['form_submit']]['errors'] = $aErrors;

	}

}

function sendEmail($sSubject = false, $sMailBody = false, $sTo = MAIL_TO, $cc = true, $bcc = true) {

	if ($sTo != '' && MAIL_FROM != '' && $sSubject != '' && $sMailBody != '') {

		$sHeaders = 'From: '. MAIL_FROM . "\r\n" .
					'Reply-To: ' . MAIL_FROM . "\r\n".
					'MIME-Version: 1.0' . "\r\n".
					'Content-type: text/html; charset=iso-8859-1'."\r\n".
					(MAIL_CC  != false && $cc  != false ? 'Cc: ' . MAIL_CC . "\r\n" : false).
					(MAIL_BCC != false && $bcc != false ? 'Bcc: ' . MAIL_BCC . "\r\n" : false);

		@mail($sTo, $sSubject, $sMailBody, $sHeaders);

	}

}
?>
