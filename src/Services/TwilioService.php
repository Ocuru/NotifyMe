<?php
namespace Ocuru\Notify\Services;

use Ocuru\Notify\Contracts\ServiceContract;
use Twilio\Rest\Client;

class TwilioService implements ServiceContract
{
    /**
     * Variables the service accepts and wether or not they are required
     * @var array
     */
    public $variables = array(
        "FromSMSName" => true, 
        "FromPhoneNumber" => true, 
        "ToPhoneNumber" => true,
        "MessageSMS" => true
    );

    public $SID;
    public $Token;

    public $client;

    /**
     * Sets up the services using Enviromental Variables
     * @return boolen Shows if service was successfully set up.
     */
    public function setupService(\Dotenv\Dotenv $env)
    {
        $env->required([
            'Ocuru\Notify\Twilio.SID',
            'Ocuru\Notify\Twilio.Token',
        ])->notEmpty();

        $this->SID = $_ENV['Ocuru\Notify\Twilio.SID'];
        $this->Token = $_ENV['Ocuru\Notify\Twilio.Token'];

        $client = new Client($this->SID, $this->Token);
        $this->client = $client->accounts($_ENV['Ocuru\Notify\Twilio.SID']);
    }

    /**
     * Sends a notification using current service.
     * @return boolen Shows wether notification was successfully sent.
     */
    public function notify($data)
    {
        $message = $this->client->messages->create(
          $data['ToPhoneNumber'], // Text this number
          array(
            'from' => $data['FromPhoneNumber'], // From a valid Twilio number
            'body' => "From {$data['FromSMSName']}. {$data['MessageSMS']}"
          )
        );

        if($message->errorCode)
        {
            return array(
                "error" => true,
                "error_code" => $message->errorCode,
                "error_message" => $message->errorMessage
            );
        }

        return array(
            "error" => false
        );
    }
}