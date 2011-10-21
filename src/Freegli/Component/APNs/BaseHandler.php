<?php

namespace Freegli\Component\APNs;

abstract class BaseHandler
{
    private $connectionFactory;

    /**
     * @var resource
     */
    private $connection;

    /**
     * @var string
     */
    private $url;

    public function __construct($connectionFactory, $debug = false)
    {
        $this->connectionFactory = $connectionFactory;

        $this->url = sprintf('ssl://%s:%s',
            $debug ? static::SANDBOX_HOST : static::PRODUCTION_HOST,
            static::PORT
        );
    }

    public function __destruct()
    {
        if (is_resource($this->connection)) {
            fclose($this->connection);
        }
    }

    /**
     * @return resource
     */
    public function getConnection()
    {
        if (!$this->connection || feof($this->connection)) {
            $this->connection = $this->connectionFactory->getConnection($this->url);
        }

        return $this->connection;
    }
}
