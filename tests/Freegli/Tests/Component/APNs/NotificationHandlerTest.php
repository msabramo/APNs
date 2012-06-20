<?php

namespace Freegli\Tests\Component\APNs;

use Freegli\Component\APNs\ConnectionFactory;
use Freegli\Test\NotificationHandler;

require __DIR__.'/NotificationTest.php';

class NotificationHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $cf = new ConnectionFactory();
        $nh = new NotificationHandler($cf, true);
        $notification = NotificationTest::getNotification();

        $nh->send($notification);

        $this->assertEquals($notification, $nh->lastPushNotification);
        $bin = file_get_contents(__DIR__.'/../../../../Resources/notification.bin');
        $this->assertEquals($bin, $nh->lastBinaryPushNotification);
    }
}

namespace Freegli\Test;

use Freegli\Component\APNs\NotificationHandler as BaseNotificationHandler;

/**
 * NotificationHandler Mock.
 */
class NotificationHandler extends BaseNotificationHandler
{
    public function send(\Freegli\Component\APNs\Notification $pushNotification)
    {
        $this->lastPushNotification = $pushNotification;
        $this->lastBinaryPushNotification = $pushNotification->toBinary();
    }

    public $lastPushNotification = null;
    public $lastBinaryPushNotification = null;
}
