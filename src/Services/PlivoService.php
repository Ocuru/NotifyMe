<?php
namespace Ocuru\Notify\Services;

use Ocuru\Notify\Contracts\ServiceContract;
use Twilio\Rest\Client;

class PlivoService implements ServiceContract
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
            'Ocuru\Notify\Plivio.SID',
            'Ocuru\Notify\Plivio.Token',
        ])->notEmpty();

        $this->SID = $_ENV['Ocuru\Notify\Plivio.SID'];
        $this->Token = $_ENV['Ocuru\Notify\Plivio.Token'];

        $this->client = new RestAPI($this->SID, $this->Token);
    }

    /**
     * Sends a notification using current service.
     * @return boolen Shows wether notification was successfully sent.
     */
    public function notify($data)
    {
        $message = $this->client->send_message(array(
            'src' => $data['FromPhoneNumber'],
            'dst' => $data['ToPhoneNumber'],
            'text' => "From {$data['FromSMSName']}. {$data['MessageSMS']}"
        ));

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