<?php

namespace Freegli\Component\APNs;

class NotificationHandler extends BaseHandler
{
    const PRODUCTION_HOST = 'gateway.push.apple.com';
    const SANDBOX_HOST    = 'gateway.sandbox.push.apple.com';
    const PORT            = '2195';

    public function send(Notification $pushNotification)
    {
        $binaryPushNotification = $pushNotification->toBinary();

        $written = fwrite($this->getConnection(), $binaryPushNotification);

        //TODO handle error
    }
}
