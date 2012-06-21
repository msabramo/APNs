<?php

namespace Freegli\Tests\Component\APNs;

use Freegli\Component\APNs\Notification;

class NotificationTest extends \PHPUnit_Framework_TestCase
{
    public function testToBinary()
    {
        $notification = self::getNotification();
        $bin = file_get_contents(__DIR__.'/../../../../Resources/notification.bin');
        $this->assertEquals($bin, $notification->toBinary());
    }

    public static function getNotification()
    {
        $notification = new Notification();
        $notification->setIdentifier(2);
        $notification->setExpiry(new \DateTime('2010-01-13T00:00:00+01:00'));
        $notification->setDeviceToken('4333526ff2e8b19730cab08c7a14f8b59e80aed473e06d6a2faa95bd82c3556e');
        $notification->setPayload(array(
            'aps' => array(
                'alert' => 'Alert!'
            )
        ));

        return $notification;
    }
}
