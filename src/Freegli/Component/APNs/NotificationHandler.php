<?php

namespace Freegli\Component\APNs;

use Freegli\Component\APNs\Exception\ExceptionInterface;

class NotificationHandler extends BaseHandler
{
    const PRODUCTION_HOST = 'gateway.push.apple.com';
    const SANDBOX_HOST    = 'gateway.sandbox.push.apple.com';
    const PORT            = '2195';

    public function send(Notification $pushNotification)
    {
        $binaryPushNotification = $pushNotification->toBinary();

        $written = fwrite($this->getResource(), $binaryPushNotification);

        if ($written == false) {
            //fwrite error
            return false;
        }
        if ($written != strlen($binaryPushNotification)) {
            //uncomplete write
            return false;
        }
        if (!feof($this->getResource())) {
            //get back error response
            //TODO fix timeout issue when nothing to get
            $error = fread($this->getResource(), ErrorResponse::LENGTH);
            try {
                return new ErrorResponse($error);
            } catch (ExceptionInterface $e) {
                //do nothing
            }
        }

        return true;
    }
}
