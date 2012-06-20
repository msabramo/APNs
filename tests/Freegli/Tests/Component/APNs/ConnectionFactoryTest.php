<?php

namespace Freegli\Tests\Component\APNs;

use Freegli\Component\APNs\ConnectionFactory;

class ConnectionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $cf = new ConnectionFactory();
        $connection = $cf->getConnection('tcp://www.google.com:80');

        $this->assertTrue(is_resource($connection));
        $this->assertFalse(feof($connection));
        fclose($connection);
    }
}
