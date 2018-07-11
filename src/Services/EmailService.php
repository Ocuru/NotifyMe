<?php
namespace Ocuru\Notify\Services;

use Ocuru\Notify\Contracts\ServiceContract;

use PHPMailer;

class EmailService extends PHPMailer implements ServiceContract
{
	/**
     * Holds a array of errors from Notify Function
     * @var array
     */
	public $NotifyErrors = array();

	/**
	 * PHPMailer Variable
	 * @var array
	 */
    public $SMTPOptions;

    /**
     * PHPMailer Variable
     * @var string
     */
	public $Host;  

	/**
     * PHPMailer Variable
     * @var string
     */
	public $SMTPAuth;

	/**
     * PHPMailer Variable
     * @var string
     */
	public $Username;

	/**
     * PHPMailer Variable
     * @var string
     */
	public $Password;

	/**
     * PHPMailer Variable
     * @var string
     */
	public $SMTPSecure;

	/**
     * PHPMailer Variable
     * @var string
     */
	public $Port;

	/**
     * PHPMailer Variable
     * @var string
     */
	public $isHTML;

	/**
     * PHPMailer Variable
     * @var string
     */
	public $Mailer; 

	/**
	 * Variables the service accepts and wether or not they are required
	 * @var array
	 */
	public $variables = array(
		"FromName" => true, 
		"FromEmail" => true, 
		"ToName" => true, 
		"ToEmail" => true, 
		"ReplyToName" => false, 
		"ReplyToEmail" => false, 
		"Subject" => true, 
		"isHTML" => false, 
		"MessagePlainText" => true, 
		"MessageHTML" => false
	);

	/**
	 * This sets all the phpMailer Variables using Enviromental Variables
     * @return boolen Shows if service was successfully set up.
     */
	public function setupService(\Dotenv\Dotenv $env)
	{
		$env->required([
			'Ocuru\Notify\Email.SSL.Verify_Peer',
			'Ocuru\Notify\Email.SSL.Verify_Peer_Name',
			'Ocuru\Notify\Email.SSL.Allow_Self_Signed',
			'Ocuru\Notify\Email.Host',
			'Ocuru\Notify\Email.SMTPAuth',
			'Ocuru\Notify\Email.Username',
			'Ocuru\Notify\Email.Password',
			'Ocuru\Notify\Email.SMTPSecure',
			'Ocuru\Notify\Email.Mailer',
			'Ocuru\Notify\Email.Port',
			'Ocuru\Notify\Email.SMTPDebug'
		])->notEmpty();

		$this->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => $_ENV['Ocuru\Notify\Email.SSL.Verify_Peer'],
		        'verify_peer_name' => $_ENV['Ocuru\Notify\Email.SSL.Verify_Peer_Name'],
		        'allow_self_signed' => $_ENV['Ocuru\Notify\Email.SSL.Allow_Self_Signed']
		    )
		);
		$this->Host = $_ENV['Ocuru\Notify\Email.Host'];
		$this->SMTPAuth = $_ENV['Ocuru\Notify\Email.SMTPAuth'];
		$this->Username = $_ENV['Ocuru\Notify\Email.Username'];
		$this->Password = $_ENV['Ocuru\Notify\Email.Password'];
		$this->SMTPSecure = $_ENV['Ocuru\Notify\Email.SMTPSecure'];
		$this->Mailer = $_ENV['Ocuru\Notify\Email.Mailer'];
		$this->Port = $_ENV['Ocuru\Notify\Email.Port'];
		$this->SMTPDebug = $_ENV['Ocuru\Notify\Email.SMTPDebug'];

		return true;
	}

	/**
     * Sends a notification using current service.
	 * @param  array $data
     * @return array Shows wether notification was successfully sent.
     */
    public function notify($data)
    {
		$this->clearReplyTos();
		$this->clearAllRecipients();  	

		if((isset($data['ReplyToName']) && isset($data['ReplyToEmail'])) && (!empty($data['ReplyToEmail']) || !empty($data['ReplyToName'])))
		{
			$this->addReplyTo($data['ReplyToEmail'], $data['ReplyToName']);
		}
    	
		$this->setFrom($data['FromEmail'], $data['FromName']);
		$this->addAddress($data['ToEmail'], $data['ToName']);
		$this->Subject = $data['Subject'];
		$this->AltBody = $data['MessagePlainText'];

		if($data['isHTML'] === true && isset($data['MessageHTML']))
		{
			$this->Body = $data['MessageHTML'];
		}

		if(!$this->send()) {
			return array(
				"error" => true,
				"error_code" => "Mailer Error",
				"error_message" => $this->ErrorInfo,
			);
			// throw new Exception("Message could not be sent.", "Mailer Error: " . $this->ErrorInfo);		
		} else {
			return array(
				"error" => false,
			);
		}
    }

    /**
     * Clears PhpMailer Data
     */
	public function clearPrevious()
	{
		$this->ClearAddresses();
		$this->ClearCCs();
		$this->ClearBCCs();
	}
}
