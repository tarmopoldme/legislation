<?php

namespace AppBundle\Classes\api;

use GuzzleHttp\Client;
use Symfony\Bridge\Monolog\Logger;

/**
 * Class AbstractApiService
 * Contains base functionality for all api services
 *
 * Currently implements http client init
 *
 * @author <tarmo.poldme@brainart.ee>
 * @date 04.02.2017
 */
abstract class AbstractApiService
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Client
     */
    protected $client;


    /**
     * @param Logger $logger
     * @param Client $client
     */
    public function __construct(Logger $logger, Client $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    /**
     * @param string $error
     */
    protected function logError($error)
    {
        $this->logger->error($error);
    }

    /**
     * Defines unique id for API service
     * @return string
     */
    abstract protected function getServiceName();
}