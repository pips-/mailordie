<?php
//Configuration
//=============

//Here goes your email username
$mailordie_sender = 'mailordie';

//And here goes an URL to the success page
$success_page = 'success.html';

//specify tokens here
$tokens = array(
	'd41d8cd98f00b204e9800998ecf8427e' => array(
		'website' => 'test website',
		'recipient' => 'user@host.com'
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
		$token_found = true;
		break;
	}
}
if (!$token_found)
	die('Unknown token: ' . $_GET['token']);

//Check token's configuration
if (empty($website) || empty($recipient))
	die('Missing configuration, please check configuration file.');

//Construct message
if (empty($_GET['sender']))
	$sender = 'Anonymous';
else
	$sender = trim($_GET['sender']);
if (empty($_GET['subject']))
	$subject = 'No subject';
else
	$subject = clean_string($_GET['subject']);
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
