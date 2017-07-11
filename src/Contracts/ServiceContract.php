<?php
namespace Ocuru\Notify\Contracts;

interface ServiceContract
{
    /**
     * Holds a array of errors from Notify Function
     * @var array
     */
    // public $NotifyErrors;

    /**
     * Sets up the services using Enviromental Variables
     * @return boolen Shows if service was successfully set up.
     */
    public function setupService(\Dotenv\Dotenv $env);

    /**
     * Sends a notification using current service.
     * @return boolen Shows wether notification was successfully sent.
     */
    public function notify($data);
}