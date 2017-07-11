# Ocuru\Notify

**Note: This package is under heavy development and is not recommended for production.**

## Installing New

Install using Composer.
=======
## Installing

Install using Composer.

```json
{
	"require": {
		"ocuru/notify": "dev-master"
	}
}
```

## Available Services
Below are the services we currently support, more will be added over time.

#### Email Service

| Service ID | Data Required for Notification           | Optional Data                            |
| :--------- | :--------------------------------------- | ---------------------------------------- |
| email      | `ToName, ToEmail, FromName, FromEmail, Subject, MessagePlainText` | `isHTML, MessageHTML` (if `isHTML = true`), `ReplyToName, ReplyToEmail` |

##### Data

```php
$Notify->ToName = "John Smith";
$Notify->ToEmail = "john@smith.com";

$Notify->FromName = "No Reply - Ocuru";
$Notify->FromEmail = "no-reply@ocuru.com";

// ReplyTo isnt Required
$Notify->ReplyToName = "Support - Ocuru";
$Notify->ReplyToEmail = "support@ocuru.com";

$Notify->Subject = "Example Notification";
$Notify->isHTML = true;
$Notify->MessagePlainText = "This is a example notification message.";
$Notify->MessageHTML = "<html><body><p>This is a example notification message.</p></body></html>";
```
| Service ID | Data Required for Notification           | Optional Data                            |
| :--------- | :--------------------------------------- | ---------------------------------------- |
| email      | `to.name, to.email, from.name from.email, message.is_html, message.plain_text` | `message.html` (if `message.is_html = true`) |

##### Data Format

```php
$data = [
	"to" => [
    	"name" => to.name,
      	"email" => to.email
    ],
  	"from" => [
    	"name" => from.name,
      	"email" => from.email
    ],
  	"message" => [
      	"is_html" => true,
      	"html" => "<html><body><p>This is a example notification message.</p></body></html>",
    	"plain_text" => "This is a example notification message."
    ]
];
```

#### Twilio Service

| Service ID | Data Required for Notification           |
| :--------- | :--------------------------------------- |
| twilio     | `ToPhoneNumber, FromSMSName, FromPhoneNumber, MessageSMS ` |

##### Data

```php
$Notify->ToPhoneNumber = "07704810577";

$Notify->FromSMSName = "Ocuru";
$Notify->FromPhoneNumber = "447733806389"; // Valid Twilio Number with Country Prefix

// Below Message will send with the following format.
// From Ocuru: This is a example notification message.
$Notify->MessageSMS = "This is a example notification message."; 
```

## Basic Setup
| Service ID | Data Required for Notification           |
| :--------- | ---------------------------------------- |
| twilio     | `to.name, to.number, from.name, from.number, message.short` |

##### Data Format

```php
$data = [
	"to" => [
      	"name" => to.name,
    	"number" => to.number
    ],
  	"from" => [
       	"name" => from.name,
    	"number" => from.number
    ],
  	"message" => [
    	"short" => message.short
    ]
];
```

## Basic Setup

Below is the basic setup you need to run the example code in this document.

```php
use Ocuru\Notify\Notify;

$Notify = new Notify;
```

## Environmental Variables
You need to first set the **.env** file location using the below code. **This is required.**

```php
$_ENV['ENV_LOCATION'] = __DIR__; // Directory of which your .env file is located
```

If you haven't already set up your **.env** file , *ocuru/notify* installs *vlucas/phpdotenv* onto the system.

Below is the basic setup of _**Dotenv**_ where `$_ENV['ENV_LOCATION']` is the location of your **.env** file. 

Place the below code before the _**$Notify**_ variable if setup is needed.

```php
$dotenv = new Dotenv\Dotenv($_ENV['ENV_LOCATION']);
$dotenv->load();
```

Each service will need a different set some **.env** variables, these are show below.

#### Email
=======
To set up each service you will need to set some **.env** variables, these are show below.

#### Email
```ini
Ocuru\Notify\Email.SSL.Verify_Peer=false
Ocuru\Notify\Email.SSL.Verify_Peer_Name=false
Ocuru\Notify\Email.SSL.Allow_Self_Signed=true
Ocuru\Notify\Email.Host=mail.example.com
Ocuru\Notify\Email.SMTPAuth=true
Ocuru\Notify\Email.Username=user@example.com
Ocuru\Notify\Email.Password=secret
Ocuru\Notify\Email.SMTPSecure=tls
Ocuru\Notify\Email.Mailer=smtp
Ocuru\Notify\Email.Port=587
```

#### Twilio
```ini
Ocuru\Notify\Twilio.SID=example_id
Ocuru\Notify\Twilio.Token=example_secret
```

### After Setting *.env* Variables
In the below example we show you how to setup the services you want to use. You should only run these methods once you have set up all the environmental variables you need shown [here](#environmental-variables). If you don't then an exception will be thrown.

The array can consist of any of the service names shown in the Service ID part of each service [List of Services](#available-services) area.
=======

```ini
Ocuru\Notify\Twilio.ID=example_id
Ocuru\Notify\Twilio.Secret=example_secret
```

### After Setting *.env* Variables

In the below example we show you how to setup the services you want to use. You should only run these methods once you have set up all the environmental variables you need shown [here](#environmental-variables). If you don't then an exception will be thrown.

The array can consist of any of the service names shown in square brackets in the [List of Services](#available-services) area.

```php
$Notify->use($arrayOfServices);
$Notify->start();
```

The `$Notify->start();` method is required for **Ocuru\Notify** to initialize. However the `$Notify->use();` method isn't required but if you run `$Notify->start();` without it we will attempt to setup the Email service which is **Ocuru\Notify**'s default service. If no [Environmental Variables](#environmental-variables) are found for the Email Service then a exception will be thrown.

## Notifying Users
To notify a user you can use the methods shown below. If an error occurs, we will throw an exception.

Below is the first example of how to send a notification, this sends a notification through all services you have set up.

In order to send a notification you will need to make sure all variables needed for each service are set. You can find out how to do this and what variables are required [here.](#available-services)

```php
$Notify->notify();
```

However you can also send via specific services using the same method, all you need to do is pass an array of services as the first parameter.  For Example.

```php
$Notify->notify($arrayOfServices);
```
=======
The `$Notify->start();` method is required for **Ocuru\Notify** to initialize. However the `$Notify->use();` method isn't required but if you run `$Notify->start();` without it we will attempt to setup the Email service which is set and Global Default. If no [Environmental Variables](#environmental-variables) are found for the Email Service then a exception will be thrown.

## Notifying Users

To notify a user you can use the methods shown below.

Below is the first example of how to send a notification, this sends a notification through all services you have set up.

```php

```

The next example shows you how to send a notification using a specific service. Through the `$Notify->notify($data);` method. 

```php

```

The final example shows you how to send a notification using the services base **Notify** Method. For example `$Notify->email->notify($data);`

```php

```
