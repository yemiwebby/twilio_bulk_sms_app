<?php

namespace app\helpers;

use Twilio\Rest\Client;
use Yii;

class TwilioSMSHelper {

    private string $phoneNumber;
    private string $messagingSID;
    private Client $twilio;

    public function __construct() {

        $params = Yii::$app->params;
        $accountSID = $params['TWILIO_ACCOUNT_SID'];
        $authToken = $params['TWILIO_AUTH_TOKEN'];
        $this->phoneNumber = $params['TWILIO_PHONE_NUMBER'];
        $this->messagingSID = $params['TWILIO_MESSAGING_SID'];
        $this->twilio = new Client($accountSID, $authToken);
    }

    public function sendBulkNotifications(array $clients, string $message) {

        foreach ($clients as $client) {
            $this->twilio->messages->create(
                $client->phoneNumber,
                [
                    'body'                => "Dear {$client->name} \n$message",
                    'from'                => $this->phoneNumber,
                    'messagingServiceSid' => $this->messagingSID
                ]
            );
        }
    }
}