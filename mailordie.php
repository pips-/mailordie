<?php
//Configuration
//=============

//Define sender of the email.
$mailordie_sender = 'mailordie';

//Define URL to the success page.
$success_page = 'success.html';

//Define tokens here.
//If the spam-filter is non-empty, the request will be considered as spam
$tokens = array(
	'd41d8cd98f00b204e9800998ecf8427e' => array(
		'website' => 'test website',
		'recipient' => 'user@host.com',
		'spam-filter' => 'phonenumber'
	),
	'a41d8cd98f00b204e9800998ecf8427e' => array(
		'website' => 'test website',
		'recipient' => 'user@host.com'
	),
	'b41d8cd98f00b204e9800998ecf8427e' => array(
		'website' => 'test website',
		'recipient' => 'user@host.com'
	)
);

// DO NOT EDIT BELOW

//Helper functions
//================

function clean_string($string) {
	return stripslashes(strip_tags(trim($string)));
}

//Actual script
//=============

//Check for required fields
if (empty($_GET['token']))
	die('Missing token');
if (empty($_GET['message']))
	die('Missing message');
if ($_SERVER['REQUEST_METHOD'] != "GET")
	die('wrong HTTP method');

//Check token
$token_found = false;
foreach ($tokens as $token => $data) {
	if ($token == $_GET['token']) {
		$website = $data['website'];
		$recipient = $data['recipient'];
		if (array_key_exists('spam-filter', $data))
			$spam_filter = $data['spam-filter'];
		$token_found = true;
		break;
	}
}
if (!$token_found)
	die('Unknown token: ' . $_GET['token']);

//Check token's configuration
if (empty($website) || empty($recipient))
	die('Missing configuration, please check configuration file.');

//Check anti-spam hidden fields
if (!empty($spam_filter))
	if (!empty($_GET[$spam_filter]))
		die('die.');

//Construct message
if (empty($_GET['sender']))
	$sender = 'Anonymous';
else
	$sender = trim($_GET['sender']);
if (empty($_GET['subject']))
	$subject = 'No subject';
else
	$subject = filter_input(INPUT_GET, 'subject', FILTER_SANITIZE_STRING);
$message = "The following message was sent from mailordie:\r\n";
foreach ($_GET as $key => $val)
	$message .= ucwords($key) . ': ' . clean_string($val) . "\r\n";

$message .= "\n\n";
$message .= 'IP: ' . $_SERVER['REMOTE_ADDR'] . "\r\n";
$message .= 'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'];

//Create headers
$headers = "FROM: $mailordie_sender\n";
$headers .= "Reply-To: $sender";

//Send email
mail($recipient, "[$website] $subject", $message, $headers) or
	die('Unable to send e-mail.'); //;)
header("Location: $success_page");
