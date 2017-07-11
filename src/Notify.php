<?php

namespace Ocuru\Notify;

use Ocuru\Notify\Rules\Rules;

class Notify
{
    /**
     * All Variables Excepted by Services.
     *
     * @var [type]
     */
    public $FromName;
    public $FromEmail;
    public $FromPhoneNumber;

    public $ToName;
    public $ToEmail;
    public $ToPhoneNumber;

    public $ReplyToName;
    public $ReplyToEmail;
    public $ReplyToPhoneNumber;

    public $Subject;
    public $isHTML = false;
    public $MessagePlainText;
    public $MessageHTML;
    public $MessageSMS;

    /**
     * Holds an array of notify errors.
     *
     * @var array
     */
    private $NotifyErrors = array();

    /**
     *  This holds the users services they want to notify via.
     *
     * @var array
     */
    protected $servicesToUse = ['email'];

    /**
     * Accible var to send emails via phpMailer.
     *
     * @var Class
     */
    public $email;

    /**
     * Accible var to use Twilio.
     *
     * @var Class
     */
    public $twilio;

    /**
     * This allows users to set which services to notify by
     *  currently this is via
     *  email, twilio.
     *
     * @param array $settings currently can only be (email, twilio)
     */
    public function use($arrayOfServices)
    {
        $this->servicesToUse = $arrayOfServices;
    }

    /**
     * Starts each enabled service.
     *
     * @return array wether service was started
     */
    public function start()
    {
        if (is_null($this->servicesToUse)) {
            $this->startEmail;
        }

        $array = array();
        foreach ($this->servicesToUse as $service) {
            $serviceClass = '\\Ocuru\\Notify\\Services\\'.ucfirst($service).'Service';
            $this->{$service} = new $serviceClass();
            $array[$service] = $this->{$service}->setupService(new \Dotenv\Dotenv($_ENV['ENV_LOCATION']));
        }

        return $array;
    }

    public function notify($services = null)
    {
        $this->NotifyErrors = array();
        if (!$services) {
            $services = $this->servicesToUse;
        }
        $serviceData = array();
        foreach ($services as $service) {
            $variablesToUse = $this->{$service}->variables;
            $dataArray = array();
            foreach ($variablesToUse as $variable => $value) {
                $dataArray[$variable] = $this->{$variable};
            }

            $serviceData[$service] = $dataArray;
            $this->checkData($service, $dataArray);
        }

        if (!$this->errors()) {
            $notifyErrors = array();
            foreach ($services as $service) {
                $notifyErrors[$service] = $this->{$service}->notify($serviceData[$service]);
            }

            return $notifyErrors;
        } else {
            echo '<h2>Data Declaration Error </h2>';
            echo "<p style='color:red;'>Please make sure all required fields are present and not empty.</p>";
            foreach ($this->NotifyErrors as $errorKey => $value) {
                echo '<b>'.$errorKey.'</b>'.': '.$value.'<br>';
            }
        }

        // if(!$this->errors())
        // {
        // 	foreach ($services as $service) {
        // 		$this->{$service}->notify($dataArray);
        // 		// echo "$service Notified";
        // 	}
        // } else {
        // 	echo "<p>You have errors in your data declaration,</p>";
     //    	foreach ($this->NotifyErrors as $errorKey => $value) {
     //    		echo "<b>" . $errorKey . "</b>" . ": " . $value . "<br>";
     //    	}
        // }
    }

    private function errors()
    {
        if (empty($this->NotifyErrors)) {
            return false;
        }

        return true;
    }

    private function checkData($service, $data)
    {
        foreach ($data as $key => $value) {
            if ($this->{$service}->variables[$key]) {
                if (!Common::setNEmpty($data, $key)) {
                    $this->NotifyErrors[$key] = Rules::getRuleError($key);
                }
            }
        }

        if ((isset($data['isHTML']) && $data['isHTML'] === true) && !isset($data['MessageHTML'])) {
            $this->NotifyErrors['HtmlTrue'] = Rules::getRuleError('HtmlTrue');
        }
    }
}
