<?php

namespace Freegli\Component\APNs;

use Freegli\Component\APNs\Exception\ConnectionException;

class ConnectionFactory
{
    private $certificatPath;
    private $certificatPassPhrase;
    private $sandbox;

    public function __construct($certificatPath, $certificatPassPhrase, $sandbox = false)
    {
        $this->certificatPath       = $certificatPath;
        $this->certificatPassPhrase = $certificatPassPhrase;
        $this->sandbox              = $sandbox;
    }

    /**
     * Open stream connection to APNs.
     *
     * @param string $url Service URL to connect
     *
     * @return resource
     *
     * @throws ConnectionException
     */
    private function getConnection($url)
    {
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $this->certificatPath);
        if ($this->certificatPassPhrase) {
            stream_context_set_option($streamContext, 'ssl', 'passphrase', $this->certificatPassPhrase);
        }

        $connection = stream_socket_client($url, $errno, $errstr, 60, STREAM_CLIENT_CONNECT, $streamContext);
        if ($connection === false) {
            throw new ConnectionException($errstr, $errno);
        }

        return $connection;
    }
}
