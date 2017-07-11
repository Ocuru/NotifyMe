<?php
error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';
$_ENV['ENV_LOCATION'] = __DIR__;

use Ocuru\Notify\Notify;

$dotenv = new Dotenv\Dotenv($_ENV['ENV_LOCATION']);
$dotenv->load();

$Notify = new Notify;

$Notify->use(array('email'));
$Notify->start();

// $Notify->email->notify(array(
// 	"to" => array(
//     	"name" => "Lewis Mason",
//       	"email" => "mason8110@gmail.com"
//     ),
//   	"from" => array(
//     	"name" => "No Reply @ Ocuru",
//       	"email" => "no_reply@ocuru.com"
//     ),
//   	"reply_to" => array(
//     	"name" => "Support @ Ocuru",
//       	"email" => "support@ocuru.com"
//     ),
//   	"subject" => "Test Notification",
//   	"message" => array(
//       	"is_html" => true,
//       	"html" => "<html><body><p>This is a example notification message.</p></body></html>",
//     	"plain_text" => "This is a example notification message."
//     )
// ));

$Notify->ToName = "Lewis Mason";
$Notify->ToEmail = "mason8110@gmail.com";
$Notify->ToPhoneNumber = "07398215913";
$Notify->FromName = "No Reply @ Ocuru";
$Notify->FromSMSName = "Ocuru";
$Notify->FromPhoneNumber = "447481362878";
$Notify->FromEmail = "lewis@ocuru.com";

$Notify->ReplyToName = "Support @ Ocuru";
$Notify->ReplyToEmail = "support@ocuru.com";

$Notify->Subject = "Test Notification";
$Notify->isHTML = true;
$Notify->MessagePlainText = "This is a example notification message.";
$Notify->MessageSMS = "This is a example notification message.";
$Notify->MessageHTML = "<html><body><p>This is a example notification message.</p></body></html>";

header('Content-Type: application/json');
echo json_encode($Notify->notify());

// $Notify->send($services); // Certain Services.
// $Notify->send(); // All Enabled Services.
// 
// $Notify->ToMass = array();
// $Notify->mass($services); // Sends Mass Notification through Certain Services;
// $Notify->mass(); // Sends Mass Notification through all Enabled Services;

// $Notify->mailer->setFrom('no_reply@ocuru.com', 'No Reply - 7Rota');
// $Notify->mailer->addReplyTo("support@ocuru.com", "Support - 7Rota");

// $Notify->mailer->setFrom("no_reply@ocuru.com", "No Reply - 7Rota");
// $Notify->mailer->addReplyTo("support@ocuru.com", "Support - 7Rota");

// // $settings = array(
// // 	"from" => ["No Reply - 7Rota" => "no_reply@ocuru.com"],
// // 	"reply_to" => ["Support - 7Rota" => "support@ocuru.com"],
// // 	"to" => array(
// // 		"Lewis Mason" => "mason8110@gmail.com",	
// // 	)
// // );

// $settings = array(
// 	"to" => array(
// 		"Kieran Mason" => "lewis@ocuru.co.uk",	
// 	)
// );

// $email_data = array(
// 	"is_html" => false,
// 	// "subject" => "You have been invited to 7Rota",
// 	"body" => array(
// 		"plain_text" => "Hi lewis, you have been invited to join 7Rota. Go to http://7rota.com/invite/accept/"
// 	)
// );

// var_dump($Notify->mailer->sendEmail($settings, $email_data)); -->