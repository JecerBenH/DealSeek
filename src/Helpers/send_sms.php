<?php
require 'C:\wamp64\www\Projet\Dealseekk\vendor\autoload.php';
use Twilio\Rest\Client;
$code= new GlobalVar;
// _3gbkyqApzwJjJhvyMCZDavkwK892tyGTZnpiFE9
// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'ACd647b9190b3c342fed49741d4b10b28c';
$auth_token = '8b368378450091e3b81ca70ba6bf8e1c';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

// A Twilio number you own with SMS capabilities
$twilio_number = "+17142527327";

try {
    $client = new Client($account_sid, $auth_token);
} catch (\Twilio\Exceptions\ConfigurationException $e) {
}
try {
    $client->messages->create(
    // Where to send a text message (your cell phone?)
        '+21654504799',
        array(
            'from' => $twilio_number,
            'body' => 'Your verififcation Code is : ' . $code->getSmscode()
        )
    );
} catch (\Twilio\Exceptions\TwilioException $e) {
}
