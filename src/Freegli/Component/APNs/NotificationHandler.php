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

        return true;
    }

    /**
     * Get errors.
     *
     * @return ErrorResponse[]
     */
    public function getErrors()
    {
        $errors = array();
        foreach (str_split($this->fetchErrors(), ErrorResponse::LENGTH) as $binaryChunk) {
            try {
                $errors[] = new ErrorResponse($binaryChunk);
            } catch (\Exception $e) {
                //do nothing
            }
        }

        return $errors;
    }

    /**
     * Get binary string from resource.
     *
     * @return string
     */
    private function fetchErrors()
    {
        return stream_get_contents($this->getResource());
    }
}
